<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;

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
});

Route::get('/gallery', [LandingPageController::class,'gallery'])->name('gallery');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Post data ajax
Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

// Get data ajax
Route::get('/users-data', [UserController::class, 'getUsers'])->name('admin.users.data');

require __DIR__.'/auth.php';
