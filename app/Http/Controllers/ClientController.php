<?php

namespace App\Http\Controllers;

use App\Models\User; // Importojmë modelin User
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // 1. Shfaq te gjithe klientet
    public function index()
    {
        return User::all();
    }

    // 2. Ruaj një klient te ri
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        
        return User::create($validated);
    }

    // 3. Shfaq nje klient specifik
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    // 4. Perditeso te dhenat e klientit
    public function update(Request $request, string $id)
    {
        $client = User::findOrFail($id);
        $client->update($request->all());
        return $client;
    }

    // 5. Fshij klientin
    public function destroy(string $id)
    {
        $client = User::findOrFail($id);
        $client->delete();
        return response()->json(['message' => 'Klienti u fshi me sukses']);
    }
}
