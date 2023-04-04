<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    }
    )->name('dashboard');
    Route::get('/products', [DatabaseController::class, 'show']
    )->name('products');
    Route::get('/products/{id}', [DatabaseController::class, 'showById']
    )->name('product.details');
    Route::get('/cart', [CartController::class, 'index']
    )->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/removequant/{product_id}', [CartController::class, 'removeQuantity'])->name('cart.remove.quantity');
    Route::post('/cart/addquant/{product_id}', [CartController::class, 'addQuantity'])->name('cart.add.quantity');
    Route::post('/cart/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/cart/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
});
Route::post('/webhook/stripe', [WebhookController::class, 'webhook'])->name('webhook.stripe');

Route::middleware(['admin'])->group(function () { 
    Route::get('/reports', [AdminController::class, 'index']
    )->name('reports');
    Route::get('/users', [AdminController::class, 'user']
    )->name('users');
    Route::get('/product/{id}', [AdminController::class, 'edit']
    )->name('product.edit');
    Route::put('/product/{id}', [AdminController::class, 'update']
    )->name('product.update');
});

