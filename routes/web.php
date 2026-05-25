<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController; // Shto këtë

// ==========================================
// 1. RRUGËT PUBLIKE
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('authors', AuthorController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::resource('books', BookController::class)->only(['index', 'show']);

// ==========================================
// 2. RRUGËT PËR BLERËSIT (Të loguar)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    Route::get('/checkout/{book_id}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// ==========================================
// 3. RRUGËT VETËM PËR ADMININ
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // ... rreshtat e tjerë ...

    // Kjo është rruga që hap faqen (View)
    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders.view');

    // Këto janë endpoint-et për të dhënat (API)
    Route::get('/api/orders', [OrderController::class, 'index']);
    Route::get('/api/clients', [OrderController::class, 'getClients']);
    Route::post('/api/orders', [OrderController::class, 'store']);
    
    // SHTO KËTË RRESHT:
    Route::delete('/api/orders/{id}', [OrderController::class, 'destroy']);
});