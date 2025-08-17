<?php

use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredAdminController;
use App\Http\Controllers\RegisteredManagerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserManagementController;
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
Route::middleware(['auth', 'user_type:' . User::USER_TYPE_SUPER_ADMIN])
    ->prefix('super-admin')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super.admin.dashboard');

        Route::get('/user/management', [UserManagementController::class, 'index'])->name('user.management.index');
        Route::get('/user/management/edit/{id}', [UserManagementController::class, 'userEdit'])->name('user.management.edit');
        Route::post('/user/management/update/{id}', [UserManagementController::class, 'userUpdate'])->name('user.management.update');
        //Role
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::match(['get', 'post'], '/role/add', [RoleController::class, 'add'])->name('role.add');
        Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::get('/role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
        // Permission
        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::match(['get', 'post'], '/permission/add', [PermissionController::class, 'add'])->name('permission.add');
        Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::get('/permission/delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete');

        //Menu

        Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');
        Route::match(['get', 'post'], '/menu/add', [\App\Http\Controllers\MenuController::class, 'add'])->name('menu.add');
        Route::get('/menu/edit/{id}', [\App\Http\Controllers\MenuController::class, 'edit'])->name('menu.edit');
        Route::post('/menu/update/{id}', [\App\Http\Controllers\MenuController::class, 'update'])->name('menu.update');
        Route::get('/menu/delete/{id}', [\App\Http\Controllers\MenuController::class, 'delete'])->name('menu.delete');

        //Sub Menu

        Route::get('/sub-menu', [\App\Http\Controllers\SubMenuController::class, 'index'])->name('sub.menu.index');
        Route::match(['get', 'post'], '/sub-menu/add', [\App\Http\Controllers\SubMenuController::class, 'add'])->name('sub.menu.add');
        Route::get('/sub-menu/edit/{id}', [\App\Http\Controllers\SubMenuController::class, 'edit'])->name('sub.menu.edit');
        Route::post('/sub-menu/update/{id}', [\App\Http\Controllers\SubMenuController::class, 'update'])->name('sub.menu.update');
        Route::get('/sub-menu/delete/{id}', [\App\Http\Controllers\SubMenuController::class, 'delete'])->name('sub.menu.delete');
        //pages goes there
        Route::get('/page', [\App\Http\Controllers\PageController::class, 'index'])->name('page.index');
        Route::match(['get', 'post'], '/page/add', [\App\Http\Controllers\PageController::class, 'add'])->name('page.add');
        Route::get('/page/edit/{id}', [\App\Http\Controllers\PageController::class, 'edit'])->name('page.edit');
        Route::post('/page/update/{id}', [\App\Http\Controllers\PageController::class, 'update'])->name('page.update');
        Route::get('/page/delete/{id}', [\App\Http\Controllers\PageController::class, 'delete'])->name('page.delete');
        //Role Pages
        Route::match(['get', 'post'], '/role/pages', [\App\Http\Controllers\RolePageController::class, 'index'])->name('role.pages.index');
        // user role management
        Route::get('/user-role-management', [\App\Http\Controllers\UserRoleManagementController::class, 'index'])->name('user.role.index');
        Route::post('/user-role-management/save', [\App\Http\Controllers\UserRoleManagementController::class, 'save'])->name('user.role.save');

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




