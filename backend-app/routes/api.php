<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth' ], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// buyer
Route::middleware(['auth:api', 'role:buyer'])->group(function () {
    Route::post('v1/store', [StoreController::class, 'store']);
});

// merchant
Route::middleware(['auth:api', 'role:merchant'])->group(function () {
    Route::put('v1/store/{id}', [StoreController::class, 'update']);
    Route::post('v1/product', [ProductController::class, 'store']);
    Route::put('v1/product/{id}', [ProductController::class, 'update']);
    Route::delete('v1/product/{id}', [ProductController::class, 'destroy']);
});

// admin
Route::group(['middleware' => ['auth:api', 'role:admin']], function(){
    Route::delete('v1/store/{id}', [StoreController::class, 'destroy']);
});

Route::get('v1/product', [ProductController::class, 'index']);
Route::get('v1/product/{id}', [ProductController::class, 'show']);
Route::get('v1/store', [StoreController::class, 'index']);
Route::get('v1/store/{id}', [StoreController::class, 'show']);
