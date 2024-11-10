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
use App\Http\Controllers\TrackingController;
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

Route::get('/', function () {
    return view('frontend/index');
});

/**
 * User Routes
 */
Route::middleware(Authenticate::class)->group(function () {
    /**
     * View Routes
     */
    Route::get('/dashboard-user', function () {
        return view('user.user');
    })->name('user.dashboard');

    Route::get('/tracking', function () {
        return view('user.tracking');
    })->name('user.tracking');

    /**
     * CRUD Routes
     */
    Route::post('/customer/tracking', [TrackingController::class, 'getMyOrder'])->name('customer.track.order');
    Route::post('/customer/order', [OrderController::class, 'newOrderByCustomer'])->name('customer.new.order');
});

/**
 * Admin Routes
 */
Route::middleware([Authenticate::class, IsAdmin::class])->group(function () {
    /**
     * View Routes
     */
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::get('/reports', function () {
        return view('dashboard.reports');
    });

    /**
     * CRUD Routes
     */
    Route::resources([
        'category' => CategoryController::class,
        'products' => ProductController::class,
        'customers' => CustomerController::class,
        'suppliers' => SupplierController::class,
        'orders' => OrderController::class,
        'shippings' => ShippingController::class,
    ]);
});
