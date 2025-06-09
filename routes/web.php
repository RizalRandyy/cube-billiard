<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PoolTableController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BookingGroupsController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

Route::get('/', [LandingPageController::class, 'index'])->name('/');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['role:Admin|Kasir'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('pool_tables', PoolTableController::class)->middleware(['role:Admin|Kasir']);
    Route::resource('transactions', TransactionController::class)->middleware(['role:Admin|Kasir']);
});

Route::get('/gallery', [LandingPageController::class,'gallery'])->name('gallery');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('bookings', BookingController::class)->middleware(['role:User|Kasir']);
    Route::resource('booking_groups', BookingGroupsController::class)->middleware(['role:User|Kasir']);
});

// Post data ajax
Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback'])
    ->withoutMiddleware([ValidateCsrfToken::class]);


// Get data ajax
Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.users.data');
Route::get('/pool-tables-data', [PoolTableController::class, 'getPoolTables'])->name('admin.poolTables.data');

Route::get('/transaction-data', [TransactionController::class, 'initiateTransaction'])->name('transaction.data');

require __DIR__.'/auth.php';

