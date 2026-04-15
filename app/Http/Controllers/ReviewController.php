<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,book_id',
            'nota' => 'required|integer|min:1|max:5',
            'komenti' => 'nullable|string|max:500',
        ]);

        Review::create([
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'nota' => $request->nota,
            'komenti' => $request->komenti,
        ]);

        return back()->with('success', 'Faleminderit! Vlerësimi juaj u ruajt.');
    }

    public function update(Request $request, Review $review)
    {
        // Sigurohemi që vetëm autori mund ta ndryshojë
        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'Nuk keni autorizim.');
        }

        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'komenti' => 'nullable|string'
        ]);

        $review->update($request->only('nota', 'komenti'));

        return back()->with('success', 'Vlerësimi u përditësua!');
    }

    public function destroy(Review $review)
    {
        // Vetëm autori ose admini mund ta fshijë (për momentin po e lëmë vetëm autorin)
        if (Auth::id() === $review->user_id) {
            $review->delete();
            return back()->with('success', 'Vlerësimi u fshi me sukses.');
        }

        return back()->with('error', 'Nuk keni autorizim për ta fshirë këtë vlerësim.');
    }
}