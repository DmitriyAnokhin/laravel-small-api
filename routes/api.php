<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DemandController;
use App\Http\Controllers\Api\ReviewController;

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

Route::post('registration', [AuthController::class, 'registration']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::put('profile', [ProfileController::class, 'update']);
    Route::get('profile', [ProfileController::class, 'read']);

    Route::post('orders', [OrderController::class, 'create']);
    Route::get('orders', [OrderController::class, 'list']);
    Route::get('orders/{id}', [OrderController::class, 'read']);
    Route::put('orders/{id}/canceled', [OrderController::class, 'canceled']);
    Route::put('orders/{id}/completed', [OrderController::class, 'completed']);

    Route::post('orders/{order_id}/demands', [DemandController::class, 'create']);
    Route::get('orders/{order_id}/demands', [DemandController::class, 'list']);
    Route::put('orders/{order_id}/demands/{id}/accept', [DemandController::class, 'accept']);
    Route::put('orders/{order_id}/demands/{id}/canceled', [DemandController::class, 'canceled']);

    Route::post('demands/{demand_id}/reviews', [ReviewController::class, 'create']);
    Route::get('reviews/user/{user_id}', [ReviewController::class, 'list']);

});
