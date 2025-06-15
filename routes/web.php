<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PoolTableController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BookingGroupsController;

Route::get('/', [LandingPageController::class, 'index'])->name('/');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['role:Admin|Kasir'])->name('dashboard');
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('pool_tables', PoolTableController::class)->middleware(['role:Admin|Kasir']);
    Route::resource('transactions', TransactionController::class)->middleware(['role:Admin|Kasir']);
});

Route::get('/gallery', [LandingPageController::class, 'gallery'])->name('gallery');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('bookings', BookingController::class)->middleware(['role:User|Kasir']);
    Route::resource('booking_groups', BookingGroupsController::class)->middleware(['role:User|Kasir']);
});

// Post data ajax
Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

// Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback'])
//     ->withoutMiddleware([ValidateCsrfToken::class]);


// Get data ajax
Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.users.data');
Route::get('/pool-tables-data', [PoolTableController::class, 'getPoolTables'])->name('admin.poolTables.data');
Route::get('/transactions-data', [TransactionController::class, 'getTransactions'])->name('admin.transactions.data');
Route::get('/booked-tables-user-data/{booking_group_id}', [TransactionController::class, 'getBookedTablesUser'])->name('admin.bookedTablesUser.data');

Route::get('/initiate-transaction', [TransactionController::class, 'initiateTransaction'])->name('initiate-transaction.data');
Route::post('/update-transaction/{id}', [TransactionController::class, 'updateTransaction'])->name('update-transaction.data');

require __DIR__ . '/auth.php';
