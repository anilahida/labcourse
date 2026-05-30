<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->is_admin) {
            return view('admin.dashboard');
        }

        $user = Auth::user();

        // Librat e blerë (nga pagesat)
        $myBooks = \App\Models\Payment::where('user_id', $user->id)
            ->with('book.author')
            ->latest()
            ->take(5)
            ->get();

        // Wishlist
        $wishlistItems = \App\Models\Wishlist::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->take(3)
            ->get();

        // Pagesat recente
        $recentPayments = \App\Models\Payment::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->take(4)
            ->get();

        return view('client.library', compact('myBooks', 'wishlistItems', 'recentPayments'));
    }
}
