<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Staff\LendingController;
use App\Http\Controllers\Staff\ItemController as StaffItemController;
use App\Http\Controllers\Staff\UserController as StaffUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::get('/items/export', [AdminItemController::class, 'export'])->name('items.export');
    Route::get('/items/{item}/lendings', [AdminItemController::class, 'lendingDetails'])->name('items.lendings');
    Route::resource('items', AdminItemController::class);
    Route::resource('users', AdminUserController::class);
    Route::get('/users/export/{role}', [AdminUserController::class, 'export'])->name('users.export');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () { return view('staff.dashboard'); })->name('dashboard');
    Route::get('/lendings/export', [LendingController::class, 'export'])->name('lendings.export');
    Route::resource('lendings', LendingController::class);
    Route::post('/lendings/{lending}/return', [LendingController::class, 'returnItem'])->name('lendings.return');
    Route::get('/items', [StaffItemController::class, 'index'])->name('items.index');
    Route::get('/profile', [StaffUserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [StaffUserController::class, 'update'])->name('profile.update');
});

