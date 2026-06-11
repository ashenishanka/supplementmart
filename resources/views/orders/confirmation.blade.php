<x-layouts.storefront title="Order Confirmed - {{ config('app.name') }}">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Thank you for your order!</h1>
            <p class="mt-2 text-gray-600">
                Your order <span class="font-semibold text-gray-900">{{ $order->order_number }}</span> has been placed successfully.
                A confirmation has been sent to {{ $order->customer_email }}.
            </p>
        </div>

        @if ($order->payment_method === 'bank_transfer')
            <div class="mt-8 rounded-lg border border-emerald-200 bg-emerald-50 p-6">
                <h2 class="font-semibold text-emerald-900">Bank Transfer Details</h2>
                <p class="mt-1 text-sm text-emerald-800">Please transfer the total amount to the account below and use your order number as the reference.</p>
                <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                    <div class="flex justify-between sm:block">
                        <dt class="text-emerald-700">Bank</dt>
                        <dd class="font-medium text-emerald-900">{{ setting('bank_name', '-') }}</dd>
                    </div>
                    <div class="flex justify-between sm:block">
                        <dt class="text-emerald-700">Account Name</dt>
                        <dd class="font-medium text-emerald-900">{{ setting('bank_account_name', '-') }}</dd>
                    </div>
                    <div class="flex justify-between sm:block">
                        <dt class="text-emerald-700">Account Number</dt>
                        <dd class="font-medium text-emerald-900">{{ setting('bank_account_number', '-') }}</dd>
                    </div>
                    <div class="flex justify-between sm:block">
                        <dt class="text-emerald-700">Branch</dt>
                        <dd class="font-medium text-emerald-900">{{ setting('bank_branch', '-') }}</dd>
                    </div>
                </dl>
            </div>
        @elseif ($order->payment_method === 'cod')
            <div class="mt-8 rounded-lg border border-emerald-200 bg-emerald-50 p-6 text-sm text-emerald-800">
                Please keep <span class="font-semibold">{{ money($order->total) }}</span> ready in cash for our delivery rider.
            </div>
        @endif

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
                <h2 class="font-semibold text-gray-900">Order Summary</h2>
                <ul class="mt-2 space-y-2 text-sm">
                    @foreach ($order->items as $item)
                        <li class="flex justify-between gap-4">
                            <span class="text-gray-600">
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
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('shop.index') }}" class="inline-block rounded-md bg-emerald-600 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                Continue Shopping
            </a>
        </div>
    </div>
</x-layouts.storefront>
