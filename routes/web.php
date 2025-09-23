<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiOrderController;
use App\Http\Controllers\TransOrderController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\UserController;
use App\Models\TransOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // buat view login
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // buat login proses
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // buat logout

Route::resource('users', UserController::class);
Route::resource('type_of_services', TypeOfServiceController::class);
Route::resource('customers', CustomerController::class);
Route::resource('orders', TransOrderController::class);

Route::patch('/orders/{order}/complete', [TransOrderController::class, 'complete'])->name('orders.complete');
Route::get('/orders/{order}/print', [TransOrderController::class, 'print'])->name('orders.print');
Route::post('orders_post', [TransOrderController::class, 'newStore'])->name('orders.orders_post');
Route::get('get-all-data-orders', [TransOrderController::class, 'getAllDataOrders'])->name('orders.getAllDataOrders');
Route::put('/orders/{id}/status', [TransOrderController::class, 'pickupLaundry'])->name('orders.pickupLaundry');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');