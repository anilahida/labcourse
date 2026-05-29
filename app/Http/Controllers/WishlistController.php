<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->with('book')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $exists = Wishlist::where('user_id', Auth::id())
                          ->where('book_id', $request->book_id)
                          ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id
            ]);
            return redirect()->route('wishlist.index')->with('success', 'U shtua me sukses!');
        }

        return redirect()->route('wishlist.index')->with('info', 'Libri eshte ne liste.');
    }

    public function destroy($id)
    {
        Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'U hoq nga lista.');
    }
}