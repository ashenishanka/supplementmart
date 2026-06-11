<x-layouts.storefront>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ $activeCategory?->name ?? 'Shop' }}</h1>
        @if ($activeCategory?->description)
            <p class="mt-1 text-sm text-gray-500">{{ $activeCategory->description }}</p>
        @endif

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Categories</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li>
                                <a href="{{ route('shop.index', request()->except(['category', 'page'])) }}" class="{{ ! $activeCategory ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                                    All Products
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}" class="{{ $activeCategory?->id === $category->id ? 'font-medium text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Brands</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($brands as $brand)
                                <li class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="brands[]"
                                        id="brand-{{ $brand->id }}"
                                        value="{{ $brand->slug }}"
                                        @checked(in_array($brand->slug, (array) request('brands', [])))
                                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    >
                                    <label for="brand-{{ $brand->id }}" class="text-gray-600">{{ $brand->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Price (LKR)</h3>
                        <div class="mt-3 flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" min="0" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <span class="text-gray-400">&ndash;</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" min="0" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    @if ($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                    @endif

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Apply Filters</button>
                        <a href="{{ route('shop.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Reset</a>
                    </div>
                </form>
            </aside>

            <div class="lg:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }}</p>

                    <form method="GET" action="{{ route('shop.index') }}">
                        @foreach (request()->except(['sort', 'page']) as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Newest</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High to Low</option>
                            <option value="name" @selected(request('sort') === 'name')>Name (A-Z)</option>
                        </select>
                    </form>
                </div>

                @if ($products->isEmpty())
                    <div class="rounded-lg border border-dashed border-gray-300 py-16 text-center text-gray-500">
                        No products found. Try adjusting your filters.
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <x-storefront.product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.storefront>
