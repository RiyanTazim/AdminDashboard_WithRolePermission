<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Article\ArticleController;
use App\Http\Controllers\Backend\DynamicPage\DynamicPageController;
use App\Http\Controllers\Backend\SMTP\SMTPController;
use App\Http\Controllers\Backend\Permission\PermissionController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\User\UserContoller;
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
            Route::get('/admin/user/getData', 'getData')->name('admin.user.getData');
            Route::get('/admin/user/create', 'adminusercreate')->name('admin.user.create');
            Route::post('/admin/user/store', 'adminUserStore')->name('admin.user.store');
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
            Route::get('/admin/permission/getData', 'getData')->name('permission.getData');
            Route::get('/admin/permission/create', 'create')->name('permission.create');
            Route::post('/admin/permission/store', 'store')->name('permission.store');
            Route::get('/admin/permission/edit/{id}', 'edit')->name('permission.edit');
            Route::post('/admin/permission/update/{id}', 'update')->name('permission.update');
            Route::get('/admin/permission/delete/{id}', 'destroy')->name('permission.delete');
        });

        // RoleController
        Route::controller(RoleController::class)->group(function () {
            Route::get('/admin/role/list', 'index')->name('role.list');
            Route::get('/admin/role/getData', 'getData')->name('role.getData');
            Route::get('/admin/role/create', 'create')->name('role.create');
            Route::post('/admin/role/store', 'store')->name('role.store');
            Route::get('/admin/role/edit/{id}', 'edit')->name('role.edit');
            Route::post('/admin/role/update/{id}', 'update')->name('role.update');
            Route::get('/admin/role/delete/{id}', 'destroy')->name('role.delete');
        });

        //SMTP Mail Configuration
        Route::controller(SMTPController::class)->group(function () {
            Route::get('/admin/mailconfig', 'index')->name('mailconfig.index');
            Route::post('/admin/mailconfig/store', 'store')->name('mailconfig.store');
            Route::get('/admin/mailconfig/send-mail', 'sendMail')->name('mailconfig.sendMail');
            // Route::get('/admin/mail/edit/{id}', 'edit')->name('mail.edit');
            // Route::post('/admin/mail/update/{id}', 'update')->name('mail.update');
            // Route::get('/admin/mail/delete/{id}', 'destroy')->name('mail.delete');
        });

        //Dynamic Page
        Route::controller((DynamicPageController::class))->group(function () {
            Route::get('/admin/dynamicpage/list', 'index')->name('dynamicpage.list');
            Route::get('/admin/dynamicpage/getData', 'getData')->name('dynamicpage.getData');
            Route::get('/admin/dynamicpage/create', 'create')->name('dynamicpage.create');
            Route::post('/admin/dynamicpage/store', 'store')->name('dynamicpage.store');
            Route::get('/admin/dynamicpage/edit/{id}', 'edit')->name('dynamicpage.edit');
            Route::post('/admin/dynamicpage/update/{id}', 'update')->name('dynamicpage.update');
            Route::get('/admin/dynamicpage/delete/{id}', 'destroy')->name('dynamicpage.delete');
        });
    });

    // Shared routes (accessible to both Admin and regular users)
    Route::controller(ArticleController::class)->group(function () {
        Route::get('/article/list', 'index')->name('article.list');
        Route::get('/article/getData', 'getData')->name('article.getData');
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
