<?php

use App\Http\Controllers\CostumerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransaksiOrderController;
use App\Http\Controllers\TransOrderController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\UserController;
use App\Models\TransOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('users', UserController::class);
Route::resource('type_of_services', TypeOfServiceController::class);
Route::resource('customers', CustomerController::class);
Route::resource('orders', TransOrderController::class);

Route::get('login', function () {
    return view('signin');
})->name('login');