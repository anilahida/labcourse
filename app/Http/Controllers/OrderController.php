<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        return Order::with('client')->latest()->get();
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        return Order::create($validated);
    }

    
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $order->update($validated);
        return $order->load('client');
    }

    
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}