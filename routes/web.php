<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Super Admin Dashboard
Route::middleware(['user_type:'.User::USER_TYPE_SUPER_ADMIN])->group(function () {
    Route::get('/super-admin/dashboard', [\App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('super.admin.dashboard');
});

// Admin Dashboard
Route::middleware(['auth', 'user_type:'.User::USER_TYPE_ADMIN])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Manager Dashboard
Route::middleware(['auth', 'user_type:'.User::USER_TYPE_MANAGER])->group(function () {
    Route::get('/manager/dashboard', [\App\Http\Controllers\ManagerController::class, 'dashboard'])->name('manager.dashboard');
});
