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
    // E.g. merr porositë dhe i lidh me klientin
    $orders = \App\Models\Order::with('client')->orderBy('created_at', 'desc')->get();
    return response()->json($orders);
}

    public function getClients()
    {
        return response()->json(Client::all());
    }

   public function store(Request $request)
{
    // Validimi i të dhënave
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'book_title' => 'required|string|max:255',
        'total_amount' => 'required|numeric|min:0',
    ]);

    // Nëse validimi dështon, Laravel do ta kthejë automatikisht përdoruesin mbrapa me gabime.
    // Nëse kalon, vazhdo me ruajtjen:
    return \App\Models\Order::create($request->all());
}

    public function destroy($id)
{
    $order = \App\Models\Order::findOrFail($id);
    $order->delete();
    return response()->json(['message' => 'Porosia u fshi me sukses']);
}
}