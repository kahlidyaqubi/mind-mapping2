<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \App\Http\Controllers\Admin;

//Auth::routes();

Route::get('/', function () {
    return redirect('admin/home');
});


Route::middleware('guest')->group(function () {
    Route::get('login', [Admin\Auth\LoginController::class, 'login'])->name('admin.login');;
    Route::post('login', [Admin\Auth\LoginController::class, 'postLogin']);
});
Route::get('/no-access', [Admin\HomeController::class, 'noAccess']);
Route::get('/not-found', [Admin\HomeController::class, 'notFound']);

Route::middleware(['auth:admin', 'checkPermission'])->group(function () {
    Route::get('/home', [Admin\HomeController::class, 'index']);
    Route::post('logout', [Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['prefix' => 'admins'], function () {
        Route::get('/', [Admin\AdminController::class, 'index']);
        Route::get('/admin-data', [Admin\AdminController::class, 'anyData']);
        Route::get('/create', [Admin\AdminController::class, 'create']);
        Route::post('/create', [Admin\AdminController::class, 'store']);
        Route::get('/{id}/edit', [Admin\AdminController::class, 'edit']);
        Route::put('/{id}/edit', [Admin\AdminController::class, 'update']);
        Route::put('/active', [Admin\AdminController::class, 'changeActive']);
        Route::delete('/{id}/delete', [Admin\AdminController::class, 'delete']);
        Route::get('/{id}/permissions', [Admin\AdminController::class, 'permission']);
        Route::put('/{id}/permissions', [Admin\AdminController::class, 'permissionPost']);
        Route::get('/{id}/logs', [Admin\AdminController::class, 'logs']);
        Route::get('/{id}/logs-data', [Admin\AdminController::class, 'logsData']);

        Route::get('/profile', [Admin\AdminController::class, 'profile']);
        Route::put('/profile', [Admin\AdminController::class, 'update']);

    });
    Route::group(['prefix' => 'logs'], function () {
        Route::get('/', [Admin\LogController::class, 'index']);
        Route::get('/log-data', [Admin\LogController::class, 'anyData']);

    });
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [Admin\NotificationController::class, 'index']);
        Route::get('/notification-data', [Admin\NotificationController::class, 'anyData']);
        Route::get('/{id}/read', [Admin\NotificationController::class, 'read']);
        Route::get('/{id}/delete', [Admin\NotificationController::class, 'delete']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [Admin\UserController::class, 'index']); // Get Users
        Route::get('/user-data', [Admin\UserController::class, 'anyData']);
        Route::get('/create', [Admin\UserController::class, 'create']);
        Route::post('/create', [Admin\UserController::class, 'store']);
        Route::get('/{id}', [Admin\UserController::class, 'show']);
        Route::get('/{id}/edit', [Admin\UserController::class, 'edit']);
        Route::put('/{id}/edit', [Admin\UserController::class, 'update']);
        Route::put('/{id}/active', [Admin\UserController::class, 'changeActive']);
        Route::delete('/{id}/delete', [Admin\UserController::class, 'delete']);

    });

    Route::group(['prefix' => 'reciters'], function () {
        Route::get('/', [Admin\ReciterController::class, 'index']); // Get Reciters
        Route::get('/reciter-data', [Admin\ReciterController::class, 'anyData']);
        Route::get('/create', [Admin\ReciterController::class, 'create']);
        Route::post('/create', [Admin\ReciterController::class, 'store']);
        Route::get('/{id}', [Admin\ReciterController::class, 'show']);
        Route::get('/{id}/edit', [Admin\ReciterController::class, 'edit']);
        Route::put('/{id}/edit', [Admin\ReciterController::class, 'update']);
        Route::put('/{id}/active', [Admin\ReciterController::class, 'changeActive']);
        Route::delete('/{id}/delete', [Admin\ReciterController::class, 'delete']);

    });

    Route::group(['prefix' => 'surahs'], function () {
        Route::get('/', [Admin\SurahController::class, 'index']); // Get Surahs
        Route::get('/surah-data', [Admin\SurahController::class, 'anyData']);
        Route::get('/{id}/edit', [Admin\SurahController::class, 'edit']);
        Route::put('/{id}/edit', [Admin\SurahController::class, 'update']);
        Route::put('/{id}/active', [Admin\SurahController::class, 'changeActive']);

    });
    Route::group(['prefix' => 'maps'], function () {
        Route::get('/{surah_id}/', [Admin\PartController::class, 'index']); // Get Parts
        Route::get('/{surah_id}/tree', [Admin\PartController::class, 'tree']); // Get Parts
        Route::get('/{surah_id}/map-data', [Admin\PartController::class, 'anyData']);
        Route::get('/{surah_id}/create', [Admin\PartController::class, 'create']);
        Route::post('/{surah_id}/create', [Admin\PartController::class, 'store']);
        Route::get('/{id}/edit', [Admin\PartController::class, 'edit']);
        Route::put('/{id}/edit', [Admin\PartController::class, 'update']);
        Route::put('/{id}/active', [Admin\PartController::class, 'changeActive']);
        Route::delete('/{id}/delete', [Admin\PartController::class, 'delete']);
    });
    Route::group(['prefix' => 'verses'], function () {
        Route::get('/{part_id}/', [Admin\VerseController::class, 'index']); // Get Verses
        Route::get('/{part_id}/verse-data', [Admin\VerseController::class, 'anyData']);
        Route::get('/{id}/edit', [Admin\VerseController::class, 'edit']);
        Route::get('/{id}/tree', [Admin\VerseController::class, 'tree']); // Get tree
        Route::put('/{id}/edit', [Admin\VerseController::class, 'update']);
        Route::put('/{id}/active', [Admin\VerseController::class, 'changeActive']);
        Route::delete('/{id}/remove-image', [Admin\VerseController::class, 'removeImage']);
        Route::delete('/{id}/remove-sub', [Admin\VerseController::class, 'removeSub']);
        Route::get('/{id}/verse-subs', [Admin\VerseController::class, 'verseSubs']);
    });

    Route::group(['prefix' => 'settings'], function () {

        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [Admin\SettingController::class, 'index']); // Get Settings
            Route::get('/setting-data', [Admin\SettingController::class, 'anyData']);
            Route::get('/create', [Admin\SettingController::class, 'create']);
            Route::post('/create', [Admin\SettingController::class, 'store']);
            Route::get('/{id}/edit', [Admin\SettingController::class, 'edit']);
            Route::put('/{id}/edit', [Admin\SettingController::class, 'update']);
            Route::put('/{id}/active', [Admin\SettingController::class, 'changeActive']);
            Route::delete('/{id}/delete', [Admin\SettingController::class, 'delete']);
        });
    });
});

