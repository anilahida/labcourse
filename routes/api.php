<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes  —  JWT Authentication
|--------------------------------------------------------------------------
*/

// ── Publike (pa token) ──────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// Librat dhe kategoritë publike (për Vue komponentin)
Route::get('books', [BookController::class, 'apiIndex']);
Route::get('books/{id}', [BookController::class, 'apiShow']);
Route::get('categories-list', function () {
    return response()->json(\App\Models\Category::orderBy('emri')->get(['id', 'emri']));
});

// ── Me JWT Token ────────────────────────────────────────────────────────
Route::middleware('auth:api')->group(function () {

    // Auth endpoints
    Route::prefix('auth')->group(function () {
        Route::post('logout',  [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me',       [AuthController::class, 'me']);
    });

    // Resurset e mbrojtura
    Route::apiResource('authors',       AuthorController::class);
    Route::apiResource('categories',    CategoryController::class);
    Route::apiResource('clients',       ClientController::class);
    Route::apiResource('orders',        OrderController::class);
    Route::apiResource('order-details', OrderDetailController::class);
    Route::apiResource('shipments',     ShipmentController::class);
    Route::apiResource('coupons',       CouponController::class);
});