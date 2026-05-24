<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RRUGËT PUBLIKE TË API-së (Pa Token)
// ==========================================
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


// ==========================================
// 2. RRUGËT E MBROJTURA ME JWT (Kërkohet Token)
// ==========================================
Route::middleware(['auth:api'])->group(function () {
    
    // Merr të dhënat e përdoruesit të loguar
    Route::get('user', [AuthController::class, 'getAuthenticatedUser']);
    
    // CRUD-et e shoqes të mbrojtura me JWT
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-details', OrderDetailController::class);
    Route::apiResource('shipments', ShipmentController::class);
    Route::apiResource('coupons', CouponController::class);
    
});