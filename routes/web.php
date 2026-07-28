<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('services', ServiceController::class);

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');

    Route::post('/cart/{service}', [TransactionController::class, 'addToCart'])
        ->name('cart.add');

    Route::patch('/cart/increase/{service}', [TransactionController::class, 'increaseQty'])
        ->name('cart.increase');

    Route::patch('/cart/decrease/{service}', [TransactionController::class, 'decreaseQty'])
        ->name('cart.decrease');

    Route::patch('/cart/update/{service}', [TransactionController::class, 'updateQty'])
    ->name('cart.update');

    Route::delete('/cart/{service}', [TransactionController::class, 'removeCart'])
        ->name('cart.remove');

    Route::delete('/cart', [TransactionController::class, 'clearCart'])
        ->name('cart.clear');

    Route::get('/transactions/report', [TransactionController::class, 'report'])
        ->name('transactions.report');

    Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf'])
        ->name('transactions.pdf');

    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');

    Route::post('/transactions/{transaction}/payment', [TransactionController::class, 'addPayment'])
        ->name('transactions.payment');

    Route::get('/transactions/{transaction}/invoice', [TransactionController::class, 'invoicePdf'])
        ->name('transactions.invoice');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
    ->name('transactions.destroy');
});

require __DIR__.'/auth.php';