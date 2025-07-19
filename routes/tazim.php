<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Permission\PermissionController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\UserContoller;
use App\Http\Controllers\ProfileController;
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

require __DIR__ . '/auth.php';

//////////////// Admin Route ///////////////////

Route::middleware('auth', 'roles:admin')->group(function () {

    Route::get('/admin/dashboard',            [AdminController::class, 'admindashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',               [AdminController::class, 'adminlogout'])->name('admin.logout');
    Route::get('/admin/profile',              [AdminController::class, 'adminprofile'])->name('admin.profile');
    Route::post('/admin/profile/store',       [AdminController::class, 'adminprofilestore'])->name('admin.profile.store');
    Route::get('/admin/change/password',      [AdminController::class, 'adminchangepassword'])->name('admin.change.password');
    Route::post('/admin/update/password',     [AdminController::class, 'adminupdatepassword'])->name('admin.update.password');
    Route::get('/admin/user/list',            [AdminController::class, 'adminuserlist'])->name('admin.user.list');
    Route::get('/user/status/{id}',           [AdminController::class, 'userstatus'])->name('user.status');
    Route::get('/user/password/reset/{id}',   [AdminController::class, 'userpasswordreset'])->name('user.password.reset');
    Route::post('/user/password/update/{id}', [AdminController::class, 'userpasswordupdate'])->name('user.password.update');
    Route::get('/user/profile/edit/{id}',     [AdminController::class, 'userprofileedit'])->name('user.profile.edit');
    Route::post('/user/profile/update/{id}',  [AdminController::class, 'userprofileupdate'])->name('user.profile.update');
    Route::get('/user/profile/delete/{id}',   [AdminController::class, 'userprofiledelete'])->name('user.profile.delete');

    //Permission Routes
    Route::get('/admin/permission/list',            [PermissionController::class, 'index'])->name('permission.list');
    Route::get('/admin/permission/create',          [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/admin/permission/store',          [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/admin/permission/edit/{id}',       [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/admin/permission/update/{id}',    [PermissionController::class, 'update'])->name('permission.update');
    Route::get('/admin/permission/delete/{id}',     [PermissionController::class, 'destroy'])->name('permission.delete');

    //Role Routes
    Route::get('/admin/role/list',                  [RoleController::class, 'index'])->name('role.list');
    Route::get('/admin/role/create',                [RoleController::class, 'create'])->name('role.create');
    Route::post('/admin/role/store',                [RoleController::class, 'store'])->name('role.store');
    Route::get('/admin/role/edit/{id}',             [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/admin/role/update/{id}',          [RoleController::class, 'update'])->name('role.update');
    Route::get('/admin/role/delete/{id}',           [RoleController::class, 'destroy'])->name('role.delete');

}); /// End of Admin Route

//////////////// User Route ///////////////////

Route::middleware('auth', 'roles:user')->group(function () {

    Route::get('/user/dashboard',             [UserContoller::class, 'userdashboard'])->name('user.dashboard');
    Route::get('/user/logout',                [UserContoller::class, 'userlogout'])->name('user.logout');
    Route::get('/user/profile',               [UserContoller::class, 'userprofile'])->name('user.profile');
    Route::post('/user/profile/store',        [UserContoller::class, 'userprofilestore'])->name('user.profile.store');
    Route::get('/user/change/password',       [UserContoller::class, 'userchangepassword'])->name('user.change.password');
    Route::post('/user/update/password',      [UserContoller::class, 'userupdatepassword'])->name('user.update.password');

}); /// End of User Route
