<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});
Route::get('/fetch/{id}', [DatabaseController::class, 'fetchDataById']);
Route::get('/fetch', [DatabaseController::class, 'fetchAll']);
// Route::post('/cart/add', [CartController::class, 'add'])->name('add');