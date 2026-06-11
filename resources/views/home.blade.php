<x-layouts.storefront>
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-emerald-700 to-emerald-900 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-300">Sri Lanka's Supplement Store</p>
                <h1 class="mt-3 text-4xl sm:text-5xl font-bold tracking-tight">Fuel Your Fitness Journey</h1>
                <p class="mt-4 text-lg text-emerald-100">
                    Premium whey protein, mass gainers, pre-workouts, vitamins and gym gear &mdash; delivered island-wide.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('shop.index') }}" class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Value props --}}
    <section class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-12h-3v8.25m0 0H3.375a1.125 1.125 0 0 1-1.125-1.125V8.25M14.25 6.75h-2.25" />
                </svg>
                <p class="text-sm font-semibold text-gray-900">Island-wide Delivery</p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <p class="text-sm font-semibold text-gray-900">100% Genuine Products</p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                <p class="text-sm font-semibold text-gray-900">Cash on Delivery</p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a1.5 1.5 0 0 0 1.5-1.5v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                <p class="text-sm font-semibold text-gray-900">Need Help? Call Us</p>
            </div>
        </div>
    </section>

    {{-- Featured categories --}}
    @if ($featuredCategories->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-bold text-gray-900">Shop by Category</h2>
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($featuredCategories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group text-center">
                        <div class="aspect-square rounded-lg bg-white border border-gray-200 overflow-hidden flex items-center justify-center">
                            @if ($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                            @endif
                        </div>
                        <p class="mt-2 text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ $category->name }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured products --}}
    @if ($featuredProducts->isNotEmpty())
        <section class="bg-white border-y border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
                    <a href="{{ route('shop.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View all &rarr;</a>
                </div>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($featuredProducts as $product)
                        <x-storefront.product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- New arrivals --}}
    @if ($newArrivals->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">New Arrivals</h2>
                <a href="{{ route('shop.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View all &rarr;</a>
            </div>
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($newArrivals as $product)
                    <x-storefront.product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.storefront>
