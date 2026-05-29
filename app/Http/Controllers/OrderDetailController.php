<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail; 
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return OrderDetail::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'item_name'  => 'required|string|max:255',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $orderDetail = OrderDetail::create($validated);

        return response()->json($orderDetail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return OrderDetail::with('order')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);

        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'item_name'  => 'required|string|max:255',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $orderDetail->update($validated);

        return response()->json($orderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->delete();

        return response()->json(['message' => 'Detaji u fshi me sukses']);
    }
}