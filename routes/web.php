<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoolTableController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BookingGroupsController;

Route::get('/', [LandingPageController::class, 'index'])->name('/');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['role:Admin|Kasir'])->name('dashboard');
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('pool_tables', PoolTableController::class)->middleware(['role:Admin|Kasir']);
    Route::resource('transactions', TransactionController::class)->middleware(['role:Admin|Kasir']);
    Route::prefix('report')->name('report.')->group(function(){
        Route::post('/transactions/export/excel', [ReportController::class, 'exportTransactionsExcel'])->name('transactions.export.excel');
    });
});

Route::get('/gallery', [LandingPageController::class, 'gallery'])->name('gallery');
Route::get('/paymentHistory', [LandingPageController::class,'paymentHistory'])->name('paymentHistory')->middleware(['auth']);
Route::get('/paymentHistory/show/{transaction}', [LandingPageController::class,'show'])->name('user.paymentHistory.show')->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('bookings', BookingController::class)->middleware(['role:User|Kasir']);
    Route::resource('booking_groups', BookingGroupsController::class)->middleware(['role:User|Kasir']);
});

// Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback'])
//     ->withoutMiddleware([ValidateCsrfToken::class]);


// Get data ajax
Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.users.data')->middleware(['role:Admin|Kasir']);
Route::get('/pool-tables-data', [PoolTableController::class, 'getPoolTables'])->name('admin.poolTables.data');
Route::get('/transactions-data', [TransactionController::class, 'getTransactions'])->name('admin.transactions.data')->middleware(['role:Admin|Kasir']);
Route::get('/booked-tables-user-data/{booking_group_id}', [TransactionController::class, 'getBookedTablesUser'])->name('admin.bookedTablesUser.data')->middleware(['auth']); //Admin

Route::get('/initiate-transaction', [TransactionController::class, 'initiateTransaction'])->name('initiate-transaction.data')->middleware(['auth']);
Route::post('/update-transaction/{id}', [TransactionController::class, 'updateTransaction'])->name('update-transaction.data')->middleware(['auth']);
Route::get('/payment-history-data', [LandingPageController::class, 'getPaymentHistory'])->name('payment-history.data')->middleware(['auth']); //User

require __DIR__ . '/auth.php';