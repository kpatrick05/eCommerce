<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DatabaseController;

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

// Route::middleware(['guestOrVerified'])->group(function () {
//     Route::prefix('/cart')->name('cart.')->group(function () {
//         Route::get('/', [CartController::class, 'index'])->name('index');
//         Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
//         Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
//         Route::post('/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('update-quantity');

//     });
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // }
    // )->name('dashboard');
    // Route::get('/products', [DatabaseController::class, 'show']
    // )->name('products');
    // Route::get('/products/{id}', [DatabaseController::class, 'showById']
    // )->name('product.details');
    // Route::get('/cart', [CartController::class, 'index']
    // )->name('cart');
// });

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
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/removequant/{product_id}', [CartController::class, 'removeQuantity'])->name('cart.remove.quantity');
    Route::post('/cart/addquant/{product_id}', [CartController::class, 'addQuantity'])->name('cart.add.quantity');
    Route::post('/cart/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/succes', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/cart/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
});



