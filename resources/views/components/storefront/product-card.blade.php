@props(['product'])

<a href="{{ route('products.show', $product->slug) }}" class="group flex flex-col rounded-lg border border-gray-200 bg-white overflow-hidden hover:shadow-lg transition-shadow">
    <div class="aspect-square w-full bg-gray-100 overflow-hidden">
        @if ($product->images->isNotEmpty())
            <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform">
        @else
            <div class="flex h-full w-full items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75 8.69 9.31a1.5 1.5 0 0 1 2.12 0l3.44 3.44m0 0 1.94-1.94a1.5 1.5 0 0 1 2.12 0l3.44 3.44M2.25 4.5h19.5A.75.75 0 0 1 22.5 5.25v13.5a.75.75 0 0 1-.75.75H2.25a.75.75 0 0 1-.75-.75V5.25a.75.75 0 0 1 .75-.75Zm10.5 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-4">
        @if ($product->brand)
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">{{ $product->brand->name }}</p>
        @endif

        <h3 class="mt-1 text-sm font-medium text-gray-900 line-clamp-2">{{ $product->name }}</h3>

        <div class="mt-2 flex items-center gap-2">
            @if ($product->is_on_sale)
                <span class="text-base font-semibold text-emerald-600">{{ money($product->sale_price) }}</span>
                <span class="text-sm text-gray-400 line-through">{{ money($product->price) }}</span>
            @else
                <span class="text-base font-semibold text-gray-900">{{ money($product->price) }}</span>
            @endif
        </div>

        @if ($product->stock_quantity < 1)
            <span class="mt-2 inline-block text-xs font-medium text-red-600">Out of stock</span>
        @endif
    </div>
</a>
