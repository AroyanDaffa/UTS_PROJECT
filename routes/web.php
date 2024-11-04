<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;

/**
 * Global Routes
 */
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(Authenticate::class)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/**
 * User Routes
 */
Route::get('/', function () {
    return view('frontend/index');
});


/**
 * Admin Routes
 */
Route::middleware([Authenticate::class, IsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('shippings', ShippingController::class);

    Route::resource('shippings', ShippingController::class);

    Route::get('/shippings/{shipping}/edit', [ShippingController::class, 'edit'])->name('shippings.edit');

    Route::get('/reports', function () {
        return view('dashboard/reports');
    });
});

Route::get('/dashboard-user', function () {
    return view('user.user');
})->middleware('auth')->name('user.dashboard');

Route::get('/user', function () {
    return view('user/user');
});

Route::get('/tracking', function () {
    return view('user/tracking');
});
