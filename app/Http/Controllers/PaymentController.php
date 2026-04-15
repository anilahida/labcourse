<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // 1. Shfaqja e formes se checkout
    public function checkout($book_id)
    {
        $book = Book::where('book_id', $book_id)->firstOrFail();
        return view('payments.checkout', compact('book'));
    }

    // 2. Procesimi i pageses (Ruajtja ne databaze)
    public function process(Request $request)
    {
        Payment::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'shuma' => $request->shuma,
            'metoda_pageses' => 'Kredit Kartel',
            'statusi' => 'e perfunduar'
        ]);

        return redirect()->route('books.index')->with('success', 'Pagesa u krye me sukses!');
    }
}