<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = cart()->items();
        $subtotal = cart()->subtotal();

        $shippingFee = (float) setting('shipping_fee', 0);
        $freeShippingThreshold = setting('free_shipping_threshold');

        if ($freeShippingThreshold !== null && $subtotal >= (float) $freeShippingThreshold) {
            $shippingFee = 0;
        }

        $total = $subtotal + $shippingFee;

        return view('cart.index', compact('items', 'subtotal', 'shippingFee', 'total', 'freeShippingThreshold'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::with('variants')->findOrFail($validated['product_id']);

        $variant = null;

        if (! empty($validated['variant_id'])) {
            $variant = $product->variants->firstWhere('id', $validated['variant_id']);
            abort_unless($variant, 404);
        }

        $stock = $variant ? $variant->stock_quantity : $product->stock_quantity;

        if ($stock < 1) {
            return back()->with('error', 'Sorry, this item is out of stock.');
        }

        cart()->add($product->id, $variant?->id, min($validated['quantity'], $stock));

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        cart()->update($key, $validated['quantity']);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(string $key)
    {
        cart()->remove($key);

        return back()->with('success', 'Item removed from cart.');
    }
}
