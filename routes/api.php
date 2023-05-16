<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
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

Route::prefix('v1')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('admin/login', [LoginController::class, 'login'])->name('login');

        Route::prefix('jobs')
        ->name('job.')
        ->controller(JobController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{job}', 'show')->name('show');
        });
    });

    Route::middleware('auth:sanctum')->prefix('/admin')->group(function () {
        Route::post('logout', [LoginController::class, 'logout']);

        Route::get('me', [AdminController::class, 'me']);

        Route::prefix('jobs')
        ->name('job.')
        ->controller(JobController::class)
        ->group(function () {
            Route::get('/', 'viewByAdmin')->name('view.admin');
            Route::get('/{job}', 'showByAdmin')->name('show.admin');
            Route::post('/', 'store')->name('store');
            Route::put('/{job}', 'update')->name('update');
            Route::delete('/{job}', 'destroy')->name('destroy');
        });
    });
});
