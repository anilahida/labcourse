<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthorController, BookController, CategoryController, OrderController,
    WishlistController, ReviewController, PaymentController, ShipmentController, CouponController, HomeController};

Route::get('/', function () {
    $featuredBooks = \App\Models\Book::with('author')->withAvg('reviews','nota')->latest()->take(6)->get();
    $categories    = \App\Models\Category::withCount('books')->orderBy('emri')->get();
    return view('welcome', compact('featuredBooks','categories'));
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rrugët e Librave për KLIENTË (shfletim + detaje)
Route::middleware('auth')->group(function () {
    Route::get('/browse',      [BookController::class, 'browse'])->name('books.browse');
    Route::get('/books/{id}',  [BookController::class, 'show'])->name('books.show')->where('id', '[0-9]+');
    Route::post('/payments/checkout/{book_id}', [PaymentController::class, 'process'])->name('payments.process');
    Route::get('/payments/checkout/{book_id}',  [PaymentController::class, 'checkout'])->name('payments.checkout');
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
    Route::get('/orders', [OrderController::class, 'webIndex'])->name('orders.index');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::resource('books',      BookController::class)->except(['show']);
    Route::resource('authors',    AuthorController::class);
    Route::resource('categories', CategoryController::class);

    // Global search
    Route::get('/admin/search', function (\Illuminate\Http\Request $request) {
        $q = trim($request->get('q', ''));
        if (mb_strlen($q) < 2) return response()->json([]);
        $results = [];
        \App\Models\Book::where('titulli','like',"%$q%")->limit(5)->each(function($b) use (&$results) {
            $results[] = ['type'=>'Libër','icon'=>'bi-book-fill','name'=>$b->titulli,'url'=>route('books.edit',$b->id)];
        });
        \App\Models\Author::where('emri','like',"%$q%")->orWhere('mbiemri','like',"%$q%")->limit(5)->each(function($a) use (&$results) {
            $results[] = ['type'=>'Autor','icon'=>'bi-person-fill','name'=>$a->emri.' '.$a->mbiemri,'url'=>url('authors/'.$a->id.'/edit')];
        });
        \App\Models\Category::where('emri','like',"%$q%")->limit(5)->each(function($c) use (&$results) {
            $results[] = ['type'=>'Kategori','icon'=>'bi-grid-fill','name'=>$c->emri,'url'=>route('categories.edit',$c->id)];
        });
        return response()->json($results);
    })->name('admin.search');

    // Admin panelet
    Route::get('/admin/coupons', function () {
        return view('admin.coupons', ['coupons' => \App\Models\Coupon::latest()->get()]);
    })->name('admin.coupons');
    Route::post('/admin/coupons', function (\Illuminate\Http\Request $request) {
        $request->validate(['code'=>'required|max:30|unique:coupons,code','type'=>'required|in:percent,fixed','value'=>'required|numeric|min:0']);
        \App\Models\Coupon::create($request->only('code','type','value'));
        return back()->with('success','Kuponi u shtua me sukses!');
    })->name('admin.coupons.store');
    Route::put('/admin/coupons/{id}', function (\Illuminate\Http\Request $request, $id) {
        $coupon = \App\Models\Coupon::findOrFail($id);
        $request->validate(['code'=>'required|max:30|unique:coupons,code,'.$id,'type'=>'required|in:percent,fixed','value'=>'required|numeric|min:0']);
        $coupon->update($request->only('code','type','value'));
        return back()->with('success','Kuponi u përditësua!');
    })->name('admin.coupons.update');

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