@props([
    'title'       => null,
    'description' => null,
    'ogImage'     => null,
    'canonical'   => null,
])
@php
    $siteTitle   = config('app.name', 'SupplementMart');
    $pageTitle   = $title ? "{$title} | {$siteTitle}" : "{$siteTitle} — Sri Lanka's #1 Supplement Store";
    $metaDesc    = $description ?? "Shop premium gym & sports nutrition supplements in Sri Lanka. Whey protein, mass gainers, pre-workouts and more — fast delivery island-wide.";
    $ogImg       = $ogImage ?? asset('images/logo.png');
    $canonicalUrl = $canonical ?? url()->current();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $metaDesc }}">
        <link rel="canonical" href="{{ $canonicalUrl }}">

        {{-- Open Graph --}}
        <meta property="og:type"        content="website">
        <meta property="og:site_name"   content="{{ $siteTitle }}">
        <meta property="og:title"       content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $metaDesc }}">
        <meta property="og:image"       content="{{ $ogImg }}">
        <meta property="og:url"         content="{{ $canonicalUrl }}">

        {{-- Twitter Card --}}
        <meta name="twitter:card"        content="summary_large_image">
        <meta name="twitter:title"       content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $metaDesc }}">
        <meta name="twitter:image"       content="{{ $ogImg }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {!! $head ?? '' !!}
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 flex min-h-screen flex-col">

        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="bg-gray-900 text-gray-300 text-xs">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex h-9 items-center justify-between">
                    <p class="hidden sm:block tracking-wide">{{ setting('store_name', config('app.name')) }} &mdash; Sri Lanka's home for gym &amp; sports nutrition</p>
                    <div class="flex items-center gap-4 ms-auto">
                        @if (setting('store_phone'))
                            <a href="tel:{{ setting('store_phone') }}" class="hover:text-white transition-colors">{{ setting('store_phone') }}</a>
                        @endif
                        @auth
                            <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">My Account</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="hover:text-white transition-colors">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-white transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between gap-4 sm:gap-8">
                    <a href="{{ route('home') }}" class="shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
                    </a>

                    <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-auto">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="w-full rounded-full border-gray-200 bg-gray-50 pl-10 text-sm shadow-sm focus:border-emerald-500 focus:bg-white focus:ring-emerald-500"
                            >
                        </div>
                    </form>

                    <div class="flex items-center gap-5">
                        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center text-gray-700 hover:text-emerald-600 transition-colors">
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

                <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold uppercase tracking-wide text-gray-600 border-t border-gray-100 h-12">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-emerald-600 {{ request()->routeIs('home') ? 'text-emerald-600' : '' }}">Home</a>
                    <a href="{{ route('shop.index') }}" class="transition-colors hover:text-emerald-600 {{ request()->routeIs('shop.index') && ! request('category') ? 'text-emerald-600' : '' }}">Shop</a>
                    @foreach ($navCategories as $category)
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="transition-colors hover:text-emerald-600 {{ request('category') === $category->slug ? 'text-emerald-600' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-gray-200 py-3 space-y-3">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="w-full rounded-full border-gray-200 bg-gray-50 pl-10 text-sm shadow-sm focus:border-emerald-500 focus:bg-white focus:ring-emerald-500"
                            >
                        </div>
                    </form>
                    <nav class="flex flex-col gap-1 text-sm font-semibold uppercase tracking-wide text-gray-600">
                        <a href="{{ route('home') }}" class="rounded-md px-2 py-2 transition-colors hover:bg-emerald-50 hover:text-emerald-600 {{ request()->routeIs('home') ? 'text-emerald-600' : '' }}">Home</a>
                        <a href="{{ route('shop.index') }}" class="rounded-md px-2 py-2 transition-colors hover:bg-emerald-50 hover:text-emerald-600 {{ request()->routeIs('shop.index') && ! request('category') ? 'text-emerald-600' : '' }}">Shop</a>
                        @foreach ($navCategories as $category)
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="rounded-md px-2 py-2 transition-colors hover:bg-emerald-50 hover:text-emerald-600 {{ request('category') === $category->slug ? 'text-emerald-600' : '' }}">{{ $category->name }}</a>
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
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto brightness-0 invert">
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
