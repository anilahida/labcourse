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

// ==========================================
// 1. RRUGËT PUBLIKE (Qasje për të gjithë)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Kushdo mund t'i shohë listat dhe detajet (Index & Show)
Route::resource('authors', AuthorController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::resource('books', BookController::class)->only(['index', 'show']);


// ==========================================
// 2. RRUGËT PËR BLERËSIT (Duhet të jenë të loguar)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    // Payments
    Route::get('/checkout/{book_id}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});


// ==========================================
// 3. RRUGËT VETËM PËR ADMININ (CRUD-et Menaxhuese)
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Admini mund të bëjë: Create, Store, Edit, Update, Destroy
    Route::resource('authors', AuthorController::class)->except(['index', 'show']);
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    Route::resource('books', BookController::class)->except(['index', 'show']);
});