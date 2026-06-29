<x-layouts.storefront :title="'Order ' . $order->order_number">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Back to Orders</a>

        <div class="mt-4 flex items-center justify-between flex-wrap gap-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                <p class="mt-1 text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <x-storefront.order-status-badge :status="$order->status" />
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <h2 class="font-semibold text-gray-900">Shipping Address</h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $order->shipping_address['recipient_name'] ?? $order->customer_name }}<br>
                    {{ $order->shipping_address['address_line1'] ?? '' }}<br>
                    @if (! empty($order->shipping_address['address_line2']))
                        {{ $order->shipping_address['address_line2'] }}<br>
                    @endif
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['district'] ?? '' }}<br>
                    @if (! empty($order->shipping_address['postal_code']))
                        {{ $order->shipping_address['postal_code'] }}<br>
                    @endif
                    {{ $order->shipping_address['phone'] ?? $order->customer_phone }}
                </p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <h2 class="font-semibold text-gray-900">Payment</h2>
                <dl class="mt-2 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Method</dt>
                        <dd class="font-medium text-gray-900">
                            @switch ($order->payment_method)
                                @case ('cod') Cash on Delivery @break
                                @case ('bank_transfer') Bank Transfer @break
                                @case ('payhere') PayHere @break
                                @default {{ ucfirst($order->payment_method) }}
                            @endswitch
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Payment Status</dt>
                        <dd class="font-medium text-gray-900">{{ ucfirst($order->payment_status) }}</dd>
                    </div>
                </dl>

                @if ($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                    <div class="mt-4 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
                        Please transfer {{ money($order->total) }} to {{ setting('bank_name', 'our bank account') }}
                        ({{ setting('bank_account_number', '-') }}) using your order number as reference.
                    </div>
                @elseif ($order->payment_method === 'cod' && $order->payment_status === 'pending')
                    <div class="mt-4 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
                        Please keep {{ money($order->total) }} ready in cash for our delivery rider.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6">
            <h2 class="font-semibold text-gray-900">Items</h2>
            <ul class="mt-4 divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <li class="flex justify-between gap-4 py-3">
                        <span class="text-sm text-gray-600">
                            {{ $item->product_name }}
                            @if ($item->variant_name)
                                <span class="block text-xs text-gray-400">{{ $item->variant_name }}</span>
                            @endif
                            <span class="text-xs text-gray-400">Qty: {{ $item->quantity }}</span>
                        </span>
                        <span class="font-medium text-gray-900 whitespace-nowrap">{{ money($item->line_total) }}</span>
                    </li>
                @endforeach
            </ul>
            <dl class="mt-4 space-y-2 border-t border-gray-200 pt-4 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Subtotal</dt>
                    <dd class="font-medium text-gray-900">{{ money($order->subtotal) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Shipping</dt>
                    <dd class="font-medium text-gray-900">{{ $order->shipping_fee > 0 ? money($order->shipping_fee) : 'Free' }}</dd>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2 text-base font-semibold text-gray-900">
                    <dt>Total</dt>
                    <dd>{{ money($order->total) }}</dd>
                </div>
            </dl>
        </div>

        @if (! empty($order->notes))
            <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6">
                <h2 class="font-semibold text-gray-900">Order Notes</h2>
                <p class="mt-2 text-sm text-gray-600">{{ $order->notes }}</p>
            </div>
        @endif
    </div>
</x-layouts.storefront>
