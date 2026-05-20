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

       
        $validated['status'] = 'pending';

        $order = Order::create($validated);

       
        return response()->json($order->load('client'), 201);
    }

public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]); // Kllapat duhet të mbyllen KËTU, saktësisht pas statusit!

        $order->update($validated);
        
        return response()->json($order->load('client'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Porosia u fshi me sukses']);
    }
}