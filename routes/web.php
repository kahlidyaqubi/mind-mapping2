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

use App\Http\Controllers;
use \UniSharp\LaravelFilemanager\Lfm;

Route::get('/', function () {
    return redirect('admin/home');
});

Auth::routes();
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
    try {
        auth()->attempt(['email' => 'test@test.com', 'password' => 'test@test.com']);
    } catch (Exception $e) {
    }
    Lfm::routes();
});

Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');
Route::get('/no-access', [Controllers\HomeController::class, 'noAccess']);
Route::get('/not-found', [Controllers\HomeController::class, 'notFound']);

Route::get('image/{size}/{folder}/{path}', function ($size, $folder, $path) {
    return getPublicImage($size, $folder, $path);
});
