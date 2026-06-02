<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/loggingIn', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/customers',           [AdminController::class, 'index'])->name('customers');
    Route::post('/customers',          [AdminController::class, 'store'])->name('customers.store');
    Route::put('/customers/{user}',    [AdminController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{user}', [AdminController::class, 'destroy'])->name('customers.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders',            [OrderController::class, 'index'])->name('orders');
    Route::post('/orders',           [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/sales', [SaleController::class, 'index'])->name('sales');
    Route::get('/showProfile', [ProfileController::class, 'showProfile']);
    Route::put('/updateProfile', [ProfileController::class, 'updateProfile']);
    Route::post('/editPicture', [ProfileController::class, 'editPicture']);
});

Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');