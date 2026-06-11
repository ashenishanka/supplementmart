<x-layouts.storefront title="Checkout - {{ config('app.name') }}">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST" class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Contact Details</h2>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="block text-sm font-medium text-gray-900">Full Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-900">Phone</label>
                            <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Shipping Address</h2>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label for="address_line1" class="block text-sm font-medium text-gray-900">Address Line 1</label>
                            <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="address_line2" class="block text-sm font-medium text-gray-900">Address Line 2 <span class="text-gray-400">(optional)</span></label>
                            <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}" class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-900">City / Town</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-900">District</label>
                            <select name="district" id="district" required class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">Select district</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-900">Postal Code <span class="text-gray-400">(optional)</span></label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-900">Order Notes <span class="text-gray-400">(optional)</span></label>
                            <textarea name="notes" id="notes" rows="3" class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Payment Method</h2>
                    <div class="mt-4 space-y-3">
                        <label class="flex items-start gap-3 rounded-md border border-gray-200 p-4 cursor-pointer hover:border-emerald-500">
                            <input type="radio" name="payment_method" value="cod" required @checked(old('payment_method', 'cod') === 'cod') class="mt-1 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="block font-medium text-gray-900">Cash on Delivery</span>
                                <span class="block text-sm text-gray-500">Pay with cash when your order is delivered.</span>
                            </span>
                        </label>
                        <label class="flex items-start gap-3 rounded-md border border-gray-200 p-4 cursor-pointer hover:border-emerald-500">
                            <input type="radio" name="payment_method" value="bank_transfer" required @checked(old('payment_method') === 'bank_transfer') class="mt-1 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="block font-medium text-gray-900">Bank Transfer</span>
                                <span class="block text-sm text-gray-500">We'll send you our bank details to complete payment.</span>
                            </span>
                        </label>
                        <label class="flex items-start gap-3 rounded-md border border-gray-200 p-4 opacity-50 cursor-not-allowed">
                            <input type="radio" name="payment_method" value="payhere" disabled class="mt-1 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="block font-medium text-gray-900">PayHere (Card / Online)</span>
                                <span class="block text-sm text-gray-500">Coming soon.</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>

                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach ($items as $item)
                            <li class="flex justify-between gap-4">
                                <span class="text-gray-600">
                                    {{ $item->product->name }}
                                    @if ($item->variant)
                                        <span class="block text-xs text-gray-400">{{ $item->variant->name }}</span>
                                    @endif
                                    <span class="text-xs text-gray-400">Qty: {{ $item->quantity }}</span>
                                </span>
                                <span class="font-medium text-gray-900 whitespace-nowrap">{{ money($item->subtotal) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-4 space-y-2 border-t border-gray-200 pt-4 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Subtotal</dt>
                            <dd class="font-medium text-gray-900">{{ money($subtotal) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Shipping</dt>
                            <dd class="font-medium text-gray-900">{{ $shippingFee > 0 ? money($shippingFee) : 'Free' }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2 text-base font-semibold text-gray-900">
                            <dt>Total</dt>
                            <dd>{{ money($total) }}</dd>
                        </div>
                    </dl>

                    <button type="submit" class="mt-6 block w-full rounded-md bg-emerald-600 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-emerald-700">
                        Place Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.storefront>
