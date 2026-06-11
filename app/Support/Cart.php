<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

class Cart
{
    protected const SESSION_KEY = 'cart';

    /**
     * @return Collection<int, object>
     */
    public function items(): Collection
    {
        $items = session(self::SESSION_KEY, []);

        if (empty($items)) {
            return collect();
        }

        $products = Product::with(['images', 'variants'])
            ->whereIn('id', collect($items)->pluck('product_id')->unique())
            ->get()
            ->keyBy('id');

        return collect($items)
            ->map(function (array $item, string $key) use ($products) {
                $product = $products->get($item['product_id']);

                if (! $product) {
                    return null;
                }

                $variant = $item['variant_id']
                    ? $product->variants->firstWhere('id', $item['variant_id'])
                    : null;

                $price = $variant ? $variant->current_price : $product->current_price;

                return (object) [
                    'key' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => (float) $price,
                    'subtotal' => (float) $price * $item['quantity'],
                ];
            })
            ->filter()
            ->values();
    }

    public function add(int $productId, ?int $variantId, int $quantity = 1): void
    {
        $items = session(self::SESSION_KEY, []);
        $key = $productId.'-'.($variantId ?? '0');

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $items[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ];
        }

        session([self::SESSION_KEY => $items]);
    }

    public function update(string $key, int $quantity): void
    {
        $items = session(self::SESSION_KEY, []);

        if (! isset($items[$key])) {
            return;
        }

        if ($quantity < 1) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        session([self::SESSION_KEY => $items]);
    }

    public function remove(string $key): void
    {
        $items = session(self::SESSION_KEY, []);
        unset($items[$key]);
        session([self::SESSION_KEY => $items]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return collect(session(self::SESSION_KEY, []))->sum('quantity');
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    public function isEmpty(): bool
    {
        return empty(session(self::SESSION_KEY, []));
    }
}
