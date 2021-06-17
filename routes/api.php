<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SmsController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;

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

//Authentication
Route::group(['prefix' => 'auth'], function () {
    //Register
    Route::post('register', [RegisterController::class, 'register']);

    //Login
    Route::post('login', [LoginController::class, 'login']);

    //Logout
    Route::middleware('auth:api')->post('logout', [LoginController::class, 'logout']);

    //Reset password
    Route::group(['prefix' => 'password'], function () {
        Route::post('reset', [ResetPasswordController::class, 'resetPassword']);
    });

    //Sms
    Route::group(['prefix' => 'sms'], function () {
        Route::post('send', [SmsController::class, 'send']);
        Route::post('validation', [SmsController::class, 'validation']);
    });
});

//Auth
Route::middleware('auth:api')->group(function () {
    //
});
