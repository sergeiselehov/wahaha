<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SmsController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;

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
    //Profile
    Route::group(['prefix' => 'profile/{user}'], function () {
        Route::get('', [ProfileController::class, 'show']);
        Route::group(['prefix' => 'update'], function () {
            Route::put('', [ProfileController::class, 'update']);
            Route::put('avatar', [ProfileController::class, 'updateAvatar']);
            Route::put('password', [ProfileController::class, 'updatePassword']);
            Route::put('phone', [ProfileController::class, 'updatePhone']);
        });
    });

    //Categories
    Route::get('categories', [CategoryController::class, 'index']);

    //Products
    Route::get('products/{category}', [ProductController::class, 'index']);
    Route::get('product/{product}', [ProductController::class, 'show']);

    //Orders
    Route::get('orders', [OrderController::class, 'index']);

});
