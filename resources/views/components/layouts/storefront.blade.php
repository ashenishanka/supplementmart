@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'SupplementMart') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 flex min-h-screen flex-col">

        <header class="bg-white border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
            <div class="bg-gray-900 text-gray-300 text-xs">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex h-9 items-center justify-between">
                    <p class="hidden sm:block">{{ setting('store_name', config('app.name')) }} &mdash; Sri Lanka's home for gym &amp; sports nutrition</p>
                    <div class="flex items-center gap-4 ms-auto">
                        @if (setting('store_phone'))
                            <a href="tel:{{ setting('store_phone') }}" class="hover:text-white">{{ setting('store_phone') }}</a>
                        @endif
                        @auth
                            <a href="{{ route('dashboard') }}" class="hover:text-white">My Account</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="hover:text-white">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-white">Log in</a>
                            <a href="{{ route('register') }}" class="hover:text-white">Register</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="shrink-0 text-2xl font-bold tracking-tight text-emerald-600">
                        Supplement<span class="text-gray-900">Mart</span>
                    </a>

                    <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-auto">
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                    </form>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center text-gray-700 hover:text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            @if ($cartCount > 0)
                                <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-600 text-xs font-semibold text-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-gray-700 border-t border-gray-100 h-12">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
                    <a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Shop</a>
                    @foreach ($navCategories as $category)
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="hover:text-emerald-600">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-gray-200 py-3 space-y-3">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                    </form>
                    <nav class="flex flex-col gap-2 text-sm font-medium text-gray-700">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
                        <a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Shop</a>
                        @foreach ($navCategories as $category)
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="hover:text-emerald-600">{{ $category->name }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-md bg-emerald-50 px-4 py-3 text-sm text-emerald-800 border border-emerald-200">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-md bg-red-50 px-4 py-3 text-sm text-red-800 border border-red-200">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-md bg-red-50 px-4 py-3 text-sm text-red-800 border border-red-200">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-gray-900 text-gray-300 mt-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-xl font-bold text-white">Supplement<span class="text-emerald-500">Mart</span></p>
                    <p class="mt-3 text-sm text-gray-400">{{ setting('store_address', 'Sri Lanka') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wide">Shop</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($navCategories as $category)
                            <li><a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="hover:text-white">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wide">Contact</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-400">
                        @if (setting('store_phone'))
                            <li>{{ setting('store_phone') }}</li>
                        @endif
                        @if (setting('store_email'))
                            <li>{{ setting('store_email') }}</li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wide">Payment Methods</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-400">
                        <li>Cash on Delivery</li>
                        <li>Bank Transfer</li>
                        <li>PayHere (coming soon)</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 text-sm text-gray-400 text-center">
                    &copy; {{ now()->year }} {{ setting('store_name', config('app.name')) }}. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>
