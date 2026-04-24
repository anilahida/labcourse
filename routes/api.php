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
// Rrugët për CRUD-at e rinj
Route::apiResource('clients', ClientController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-details', OrderDetailController::class);
Route::apiResource('shipments', ShipmentController::class);
Route::apiResource('coupons', CouponController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
