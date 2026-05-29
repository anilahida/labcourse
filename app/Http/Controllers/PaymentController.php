<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())->with('book')->latest()->get();
        return view('client.payments', compact('payments'));
    }

    // 1. Shfaqja e formes se checkout
    public function checkout($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('payments.checkout', compact('book'));
    }

    // 2. Procesimi i pageses (Ruajtja ne databaze)
    public function process(Request $request)
    {
        Payment::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'shuma'   => $request->shuma,
            'metoda_pageses' => 'Kartë Krediti',
            'statusi' => 'e perfunduar',
        ]);

        return redirect()->route('payments.index')->with('success', 'Pagesa u krye me sukses! Libri është i juaji.');
    }
}