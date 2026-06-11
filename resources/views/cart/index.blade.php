<x-layouts.storefront title="Your Cart - {{ config('app.name') }}">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">Your Cart</h1>

        @if ($items->isEmpty())
            <div class="mt-8 rounded-lg border border-dashed border-gray-300 py-16 text-center">
                <p class="text-gray-500">Your cart is empty.</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block rounded-md bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($items as $item)
                        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4">
                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-md bg-gray-100">
                                @if ($item->product->images->isNotEmpty())
                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75 8.69 9.31a1.5 1.5 0 0 1 2.12 0l3.44 3.44m0 0 1.94-1.94a1.5 1.5 0 0 1 2.12 0l3.44 3.44M2.25 4.5h19.5A.75.75 0 0 1 22.5 5.25v13.5a.75.75 0 0 1-.75.75H2.25a.75.75 0 0 1-.75-.75V5.25a.75.75 0 0 1 .75-.75Zm10.5 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="font-medium text-gray-900 hover:text-emerald-600 line-clamp-1">
                                    {{ $item->product->name }}
                                </a>
                                @if ($item->variant)
                                    <p class="text-sm text-gray-500">{{ $item->variant->name }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-500">{{ money($item->price) }} each</p>
                            </div>

                            <form action="{{ route('cart.update', $item->key) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    onchange="this.form.submit()"
                                    class="w-16 rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                >
                            </form>

                            <p class="w-28 shrink-0 text-right font-semibold text-gray-900">{{ money($item->subtotal) }}</p>

                            <form action="{{ route('cart.destroy', $item->key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach

                    <a href="{{ route('shop.index') }}" class="inline-block text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Continue Shopping</a>
                </div>

                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-gray-200 bg-white p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>

                        <dl class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Subtotal</dt>
                                <dd class="font-medium text-gray-900">{{ money($subtotal) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Shipping</dt>
                                <dd class="font-medium text-gray-900">{{ $shippingFee > 0 ? money($shippingFee) : 'Free' }}</dd>
                            </div>
                            @if ($freeShippingThreshold && $shippingFee > 0)
                                <p class="text-xs text-gray-400">
                                    Free shipping on orders over {{ money($freeShippingThreshold) }}
                                </p>
                            @endif
                            <div class="flex justify-between border-t border-gray-200 pt-2 text-base font-semibold text-gray-900">
                                <dt>Total</dt>
                                <dd>{{ money($total) }}</dd>
                            </div>
                        </dl>

                        <a href="{{ route('checkout.index') }}" class="mt-6 block w-full rounded-md bg-emerald-600 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-emerald-700">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
