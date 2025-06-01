<?php

use App\Http\Controllers\PoolTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('/');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['role:Admin|Kasir'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('pool_tables', PoolTableController::class)->middleware(['role:Admin|Kasir']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Post data ajax
Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

// Get data ajax
Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.users.data');
Route::get('/pool-tables-data', [PoolTableController::class, 'getPoolTables'])->name('admin.poolTables.data');

require __DIR__.'/auth.php';
