<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthorController, BookController, CategoryController, OrderController};

Route::get('/', function () { return view('welcome'); });
Auth::routes();

// Rrugët e Adminit (të thjeshta, pa prefix)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/orders', function () { return view('orders.index'); });
    Route::get('/authors', function () { return view('authors.index'); });
    Route::get('/categories', function () { return view('categories.index'); });

    // API Routes
    Route::get('/api/orders', [OrderController::class, 'index']);
    Route::get('/api/clients', [OrderController::class, 'getClients']);
    Route::post('/api/orders', [OrderController::class, 'store']);
    Route::delete('/api/orders/{id}', [OrderController::class, 'destroy']);
});