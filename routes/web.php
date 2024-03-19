<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('boutiques')->name('product.')->controller(ProductController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/boutique/{slug}-{product}', 'show')->name('show')->where([
        'product' => '[0-9]+',
        'slug' => '[0-9a-z\-]+'
    ]);
});

Route::prefix('panier')->name('cart.')->controller(CartController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/ajouter', 'store')->name('store');
    Route::patch('/{rowId}', 'update')->name('update');
    Route::delete('/{rowId}', 'destroy')->name('destroy');
});

Route::prefix('paiement')->name('checkout.')->controller(CheckoutController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/ajouter', 'store')->name('store');
    Route::delete('/{rowId}', 'destroy')->name('destroy');
    Route::get('/merci', 'thankyou')->name('thankyou');
});