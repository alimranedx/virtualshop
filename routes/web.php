<?php

use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredAdminController;
use App\Http\Controllers\RegisteredManagerController;
use App\Models\User;
use Common\Services\Authentication\UserDashboardControlService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $redirect_to = (new UserDashboardControlService())->redirectToDashboard(Auth::user());
    if($redirect_to != 'dashboard'){
        return redirect()->route($redirect_to);
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/super-admin/login', [CustomLoginController::class, 'superAdminLogin'])->name('super.admin.login');
    Route::get('/admin/login', [CustomLoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('/manager/login', [CustomLoginController::class, 'managerLogin'])->name('manager.login');

    //register routes =========
    Route::get('admin/register', [RegisteredAdminController::class, 'create'])->name('admin.register');
    Route::get('manager/register', [RegisteredManagerController::class, 'create'])->name('manager.register');

    Route::get('/super-admin', [\App\Http\Controllers\SuperAdminController::class, 'index'])->name('super.admin.index');
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/manager', [\App\Http\Controllers\ManagerController::class, 'index'])->name('manager.index');

});

// Super Admin Dashboard
Route::middleware(['auth','user_type:'.User::USER_TYPE_SUPER_ADMIN])->group(function () {
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
Route::get('/testing', [\App\Http\Controllers\TestController::class, 'index']);
