<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Kjo metodë mungonte dhe shkaktonte gabimin
    public function index()
    {
        return view('orders.index');
    }

    public function getClients()
    {
        return response()->json(Client::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required',
            'total_amount' => 'required|numeric',
            'book_title' => 'required|string|max:255',
        ]);

        $validated['status'] = 'pending'; 

        $order = Order::create($validated);
        
        return response()->json(['message' => 'Sukses!', 'order' => $order]);
    }
}