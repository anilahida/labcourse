<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\CouponController;
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

Route::apiResource('clients',App\Http\Controllers\ClientController::class);
Route::apiResource('orders', App\Http\Controllers\OrderController::class);
Route::apiResource('order-details', App\Http\Controllers\OrderDetailController::class);
Route::apiResource('shipments', App\Http\Controllers\ShipmentController::class);
Route::apiResource('coupons',App\Http\Controllers\CouponController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
