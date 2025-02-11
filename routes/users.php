<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\StoreController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.dashboard.')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::resource('users', UserController::class);
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('store', StoreController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
