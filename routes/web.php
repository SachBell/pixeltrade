<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\Stores\CategoryController;
use App\Http\Controllers\Stores\CheckoutController;
use App\Http\Controllers\Stores\ProductController;
use App\Http\Controllers\Stores\StoreController;
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

Route::view('/', 'welcome')->name('home');

Route::prefix('register/server')->name('server.')->group(function () {
    Route::resource('create', ServerController::class);
});

require __DIR__ . '/users.php';

Route::domain('{serverSlug}.pixeltrade.test')->name('stores.')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('index');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('checkout', CheckoutController::class);
});
