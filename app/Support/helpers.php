<?php

use App\Models\Setting;
use App\Support\Cart;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('cart')) {
    function cart(): Cart
    {
        return app(Cart::class);
    }
}

if (! function_exists('money')) {
    function money(mixed $amount): string
    {
        return 'Rs. '.number_format((float) $amount, 2);
    }
}
