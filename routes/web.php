<?php

use App\Http\Controllers\Account\OrderController as AccountOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    $url = fn(string $loc, string $priority, string $freq) =>
        "<url><loc>{$loc}</loc><changefreq>{$freq}</changefreq><priority>{$priority}</priority></url>";

    $lines   = [];
    $lines[] = $url(url('/'), '1.0', 'daily');
    $lines[] = $url(route('shop.index'), '0.9', 'daily');

    foreach (Category::where('is_active', true)->get() as $c) {
        $lines[] = $url(route('shop.index', ['category' => $c->slug]), '0.8', 'weekly');
    }
    foreach (Product::where('is_active', true)->get() as $p) {
        $lines[] = $url(route('products.show', $p->slug), '0.7', 'weekly');
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
         . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"
         . implode("\n", $lines) . "\n"
         . '</urlset>';

    return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{key}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AccountOrderController::class, 'index'])->name('dashboard');
    Route::get('/orders/{orderNumber}', [AccountOrderController::class, 'show'])->name('orders.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
