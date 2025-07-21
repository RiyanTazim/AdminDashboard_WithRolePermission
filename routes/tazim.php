<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Article\ArticleController;
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

Route::middleware(['auth'])->group(function () {

    // Admin-only routes (auth + role:Admin)
    Route::middleware(['role_or_superadmin:Admin'])->group(function () {

        // AdminController
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/dashboard', 'admindashboard')->name('admin.dashboard');
            Route::get('/admin/logout', 'adminlogout')->name('admin.logout');
            Route::get('/admin/profile', 'adminprofile')->name('admin.profile');
            Route::post('/admin/profile/store', 'adminprofilestore')->name('admin.profile.store');
            Route::get('/admin/change/password', 'adminchangepassword')->name('admin.change.password');
            Route::post('/admin/update/password', 'adminupdatepassword')->name('admin.update.password');
            
            Route::get('/admin/user/list', 'adminuserlist')->name('admin.user.list');
            Route::get('/user/status/{id}', 'userstatus')->name('user.status');
            Route::get('/user/password/reset/{id}', 'userpasswordreset')->name('user.password.reset');
            Route::post('/user/password/update/{id}', 'userpasswordupdate')->name('user.password.update');
            Route::get('/user/profile/edit/{id}', 'userprofileedit')->name('user.profile.edit');
            Route::post('/user/profile/update/{id}', 'userprofileupdate')->name('user.profile.update');
            Route::get('/user/profile/delete/{id}', 'userprofiledelete')->name('user.profile.delete');
        });

        // PermissionController
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/admin/permission/list', 'index')->name('permission.list');
            Route::get('/admin/permission/create', 'create')->name('permission.create');
            Route::post('/admin/permission/store', 'store')->name('permission.store');
            Route::get('/admin/permission/edit/{id}', 'edit')->name('permission.edit');
            Route::post('/admin/permission/update/{id}', 'update')->name('permission.update');
            Route::get('/admin/permission/delete/{id}', 'destroy')->name('permission.delete');
        });

        // RoleController
        Route::controller(RoleController::class)->group(function () {
            Route::get('/admin/role/list', 'index')->name('role.list');
            Route::get('/admin/role/create', 'create')->name('role.create');
            Route::post('/admin/role/store', 'store')->name('role.store');
            Route::get('/admin/role/edit/{id}', 'edit')->name('role.edit');
            Route::post('/admin/role/update/{id}', 'update')->name('role.update');
            Route::get('/admin/role/delete/{id}', 'destroy')->name('role.delete');
        });
    });

    // Shared routes (accessible to both Admin and regular users)
    Route::controller(ArticleController::class)->group(function () {
        Route::get('/article/list', 'index')->name('article.list');
        Route::get('/article/create', 'create')->name('article.create');
        Route::post('/article/store', 'store')->name('article.store');
        Route::get('/article/edit/{id}', 'edit')->name('article.edit');
        Route::post('/article/update/{id}', 'update')->name('article.update');
        Route::get('/article/delete/{id}', 'destroy')->name('article.delete');
    });

    Route::controller(UserContoller::class)->group(function () {
        Route::get('/user/dashboard', 'userdashboard')->name('user.dashboard');
        Route::get('/user/logout', 'userlogout')->name('user.logout');
        Route::get('/user/profile', 'userprofile')->name('user.profile');
        Route::post('/user/profile/store', 'userprofilestore')->name('user.profile.store');
        Route::get('/user/change/password', 'userchangepassword')->name('user.change.password');
        Route::post('/user/update/password', 'userupdatepassword')->name('user.update.password');
    });
});
 /// End of Admin Route

//////////////// User Route ///////////////////

// Route::middleware(['auth', 'role:Editor','role:Writer', 'role:Admin'])->group(function () {

//     Route::controller(UserContoller::class)->group(function () {
//         Route::get('/user/dashboard', 'userdashboard')->name('user.dashboard');
//         Route::get('/user/logout', 'userlogout')->name('user.logout');
//         Route::get('/user/profile', 'userprofile')->name('user.profile');
//         Route::post('/user/profile/store', 'userprofilestore')->name('user.profile.store');
//         Route::get('/user/change/password', 'userchangepassword')->name('user.change.password');
//         Route::post('/user/update/password', 'userupdatepassword')->name('user.update.password');
//     });



//     Route::controller(AdminController::class)->group(function () {
//         Route::get('/admin/logout', 'adminlogout')->name('admin.logout');
//     });

//     //Article Routes
//     Route::controller(ArticleController::class)->group(function () {
//         Route::get('/user/article/list', 'index')->name('article.list');
//         Route::get('/article/create', 'create')->name('article.create');
//         Route::post('/article/store', 'store')->name('article.store');
//         Route::get('/article/edit/{id}', 'edit')->name('article.edit');
//         Route::post('/article/update/{id}', 'update')->name('article.update');
//         Route::get('/article/delete/{id}', 'destroy')->name('article.delete');
//     });

// }); /// End of User Route
