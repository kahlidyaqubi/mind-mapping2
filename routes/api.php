<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use \App\Http\Controllers\Api;
use \App\Http\Controllers\Auth;


Route::post('login', [Api\UserController::class, 'login'])->name('login'); //
Route::post('refresh-token', [Api\UserController::class, 'refreshToken']); //
Route::post('forget', [Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('sign-up', [Api\UserController::class, 'create'])->name('user.create');
Route::get('countries', [Api\ConstantController::class, 'countries']);
Route::get('lookups', [Api\SettingController::class, 'getLookUps']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('profile', [Api\UserController::class, 'profile']); //
    Route::put('user', [Api\UserController::class, 'update']); //
    Route::post('logout', [Api\UserController::class, 'logout']);

    // app services
    Route::post('suras', [Api\AppController::class, 'suras']); //
    Route::get('surah/{id}', [Api\AppController::class, 'surah']); //
    Route::get('map/{id}', [Api\AppController::class, 'part']); //
    Route::post('verses', [Api\AppController::class, 'verses']); //
    Route::post('verse/{id}', [Api\AppController::class, 'verse']); //
    Route::get('reciters', [Api\AppController::class, 'reciters']);

});

