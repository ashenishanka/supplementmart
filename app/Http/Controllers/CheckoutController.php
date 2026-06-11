<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        if (cart()->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = cart()->items();
        $subtotal = cart()->subtotal();

        $shippingFee = (float) setting('shipping_fee', 0);
        $freeShippingThreshold = setting('free_shipping_threshold');

        if ($freeShippingThreshold !== null && $subtotal >= (float) $freeShippingThreshold) {
            $shippingFee = 0;
        }

        $total = $subtotal + $shippingFee;
        $districts = config('sri-lanka.districts');

        return view('checkout.index', compact('items', 'subtotal', 'shippingFee', 'total', 'freeShippingThreshold', 'districts'));
    }

    public function store(Request $request)
    {
        if (cart()->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', Rule::in(config('sri-lanka.districts'))],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'payment_method' => ['required', Rule::in(['cod', 'bank_transfer'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $items = cart()->items();

        $order = DB::transaction(function () use ($validated, $items) {
            $subtotal = 0;
            $orderItemsData = [];

            foreach ($items as $item) {
                $stockRecord = $item->variant
                    ? ProductVariant::where('id', $item->variant->id)->lockForUpdate()->first()
                    : Product::where('id', $item->product->id)->lockForUpdate()->first();

                if ($stockRecord->stock_quantity < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Sorry, \"{$item->product->name}\" only has {$stockRecord->stock_quantity} left in stock.",
                    ]);
                }

                $stockRecord->decrement('stock_quantity', $item->quantity);

                $lineTotal = $item->price * $item->quantity;
                $subtotal += $lineTotal;

                $orderItemsData[] = [
                    'product_id' => $item->product->id,
                    'product_variant_id' => $item->variant?->id,
                    'product_name' => $item->product->name,
                    'variant_name' => $item->variant?->name,
                    'sku' => $item->variant?->sku ?? $item->product->sku,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'line_total' => $lineTotal,
                ];
            }

            $shippingFee = (float) setting('shipping_fee', 0);
            $freeShippingThreshold = setting('free_shipping_threshold');

            if ($freeShippingThreshold !== null && $subtotal >= (float) $freeShippingThreshold) {
                $shippingFee = 0;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $subtotal + $shippingFee,
                'currency' => 'LKR',
                'shipping_address' => [
                    'recipient_name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                    'address_line1' => $validated['address_line1'],
                    'address_line2' => $validated['address_line2'] ?? null,
                    'city' => $validated['city'],
                    'district' => $validated['district'],
                    'postal_code' => $validated['postal_code'] ?? null,
                ],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->items()->createMany($orderItemsData);

            return $order;
        });

        cart()->clear();

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('orders.confirmation', compact('order'));
    }
}
