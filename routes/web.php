<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthorController, BookController, CategoryController, OrderController,
    WishlistController, ReviewController, PaymentController, ShipmentController, CouponController, HomeController};

Route::get('/', function () { return view('welcome'); });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rrugët e Librave (publike + auth)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
    Route::post('/payments/checkout/{book_id}', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments/checkout/{book_id}', [PaymentController::class, 'checkout'])->name('payments.checkout');
});

// Rrugët e Klientit
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/addresses', function () { return view('client.addresses'); })->name('addresses.index');
});

// Rrugët e Adminit
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/orders', function () { return view('orders.index'); });
    Route::resource('authors',    AuthorController::class);
    Route::resource('categories', CategoryController::class);

    // Admin panelet
    Route::get('/admin/coupons',   function () {
        return view('admin.coupons', ['coupons' => \App\Models\Coupon::all()]);
    })->name('admin.coupons');

    Route::get('/admin/payments',  function () {
        return view('admin.payments', ['payments' => \App\Models\Payment::with('book')->latest()->get()]);
    })->name('admin.payments');

    Route::get('/admin/reviews',   function () {
        return view('admin.reviews', ['reviews' => \App\Models\Review::with('book','user')->latest()->get()]);
    })->name('admin.reviews');

    Route::get('/admin/shipments', function () {
        return view('admin.shipments', ['shipments' => \App\Models\Shipment::all()]);
    })->name('admin.shipments');

    Route::get('/admin/wishlist',  function () {
        return view('admin.wishlist', ['items' => \App\Models\Wishlist::with('book')->get()]);
    })->name('admin.wishlist');

    Route::delete('/admin/coupons/{id}',   function ($id) {
        \App\Models\Coupon::destroy($id);
        return back()->with('success', 'U fshi.');
    })->name('admin.coupons.destroy');

    Route::delete('/admin/payments/{id}',  function ($id) {
        \App\Models\Payment::destroy($id);
        return back()->with('success', 'U fshi.');
    })->name('admin.payments.destroy');

    Route::delete('/admin/reviews/{id}',   function ($id) {
        \App\Models\Review::destroy($id);
        return back()->with('success', 'U fshi.');
    })->name('admin.reviews.destroy');

    Route::delete('/admin/shipments/{id}', function ($id) {
        \App\Models\Shipment::destroy($id);
        return back()->with('success', 'U fshi.');
    })->name('admin.shipments.destroy');

    Route::delete('/admin/wishlist/{id}',  function ($id) {
        \App\Models\Wishlist::destroy($id);
        return back()->with('success', 'U fshi.');
    })->name('admin.wishlist.destroy');

    // API Routes
    Route::get('/api/orders',         [OrderController::class, 'index']);
    Route::get('/api/clients',        [OrderController::class, 'getClients']);
    Route::post('/api/orders',        [OrderController::class, 'store']);
    Route::delete('/api/orders/{id}', [OrderController::class, 'destroy']);
});