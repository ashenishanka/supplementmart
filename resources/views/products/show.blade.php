<x-layouts.storefront :title="$product->name . ' - ' . config('app.name')">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <nav class="mb-6 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Shop</a>
            @if ($product->category)
                <span class="mx-1">/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-emerald-600">{{ $product->category->name }}</a>
            @endif
            <span class="mx-1">/</span>
            <span class="text-gray-700">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Gallery --}}
            <div x-data="{ active: 0 }">
                <div class="aspect-square w-full overflow-hidden rounded-lg border border-gray-200 bg-white">
                    @if ($product->images->isNotEmpty())
                        @foreach ($product->images as $i => $image)
                            <img x-show="active === {{ $i }}" src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @endforeach
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75 8.69 9.31a1.5 1.5 0 0 1 2.12 0l3.44 3.44m0 0 1.94-1.94a1.5 1.5 0 0 1 2.12 0l3.44 3.44M2.25 4.5h19.5A.75.75 0 0 1 22.5 5.25v13.5a.75.75 0 0 1-.75.75H2.25a.75.75 0 0 1-.75-.75V5.25a.75.75 0 0 1 .75-.75Zm10.5 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </div>
                    @endif
                </div>

                @if ($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @foreach ($product->images as $i => $image)
                            <button
                                type="button"
                                @click="active = {{ $i }}"
                                class="aspect-square overflow-hidden rounded-md border-2"
                                :class="active === {{ $i }} ? 'border-emerald-600' : 'border-transparent'"
                            >
                                <img src="{{ $image->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div
                x-data="productVariantPicker(
                    @js($variantsData),
                    {{ $defaultVariantId ?? 'null' }},
                    {{ $product->current_price }},
                    {{ $product->price }},
                    {{ $product->stock_quantity }}
                )"
            >
                @if ($product->brand)
                    <p class="text-sm font-medium uppercase tracking-wide text-emerald-600">{{ $product->brand->name }}</p>
                @endif

                <h1 class="mt-1 text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                <div class="mt-4 flex items-center gap-3">
                    <span class="text-2xl font-bold text-gray-900" x-text="formatPrice(price)"></span>
                    <span class="text-lg text-gray-400 line-through" x-show="onSale" x-text="formatPrice(comparePrice)"></span>
                </div>

                @if ($product->short_description)
                    <p class="mt-4 text-gray-600">{{ $product->short_description }}</p>
                @endif

                @if ($product->variants->isNotEmpty())
                    <div class="mt-6">
                        <label for="variant" class="block text-sm font-medium text-gray-900">Options</label>
                        <select id="variant" x-model.number="selected" class="mt-2 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            @foreach ($product->variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <p class="mt-4 text-sm">
                    <template x-if="stock > 0">
                        <span class="font-medium text-emerald-600" x-text="'In stock (' + stock + ' available)'"></span>
                    </template>
                    <template x-if="stock <= 0">
                        <span class="font-medium text-red-600">Out of stock</span>
                    </template>
                </p>

                <form action="{{ route('cart.store') }}" method="POST" class="mt-6 flex items-end gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if ($product->variants->isNotEmpty())
                        <input type="hidden" name="variant_id" x-model.number="selected">
                    @endif

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-900">Qty</label>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            x-model.number="quantity"
                            min="1"
                            :max="stock"
                            class="mt-2 w-20 rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                    </div>

                    <button
                        type="submit"
                        :disabled="stock < 1"
                        class="rounded-md bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>

        @if ($product->description)
            <div class="mt-16 max-w-3xl">
                <h2 class="text-xl font-bold text-gray-900">Description</h2>
                <p class="mt-4 text-gray-600 whitespace-pre-line">{{ $product->description }}</p>
            </div>
        @endif

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-xl font-bold text-gray-900">You may also like</h2>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <x-storefront.product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
