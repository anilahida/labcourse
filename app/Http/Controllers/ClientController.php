<?php

namespace App\Http\Controllers;

use App\Models\Client; // Importojmë modelin User
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // 1. Shfaq te gjithe klientet
    public function index()
    {
        return Client::all();
    }

    // 2. Ruaj një klient te ri
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
             'phone' => 'nullable|string|max:20'
             ]);

        return response()->json(Client::create($validated), 201);
    }

    // 3. Shfaq nje klient specifik
    public function show(string $id)
    {
        return Client::findOrFail($id);
    }

    // 4. Perditeso te dhenat e klientit
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->only(['name', 'email', 'phone']));
        return $client;
    }

    // 5. Fshij klientin
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(['message' => 'Klienti u fshi me sukses']);
    }
}
