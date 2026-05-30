<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = ShippingAddress::where('user_id', Auth::id())->latest()->get();
        return view('client.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'emri'       => 'required|max:100',
            'mbiemri'    => 'required|max:100',
            'rruga'      => 'required|max:255',
            'qyteti'     => 'required|max:100',
            'shteti'     => 'required|max:100',
            'kodi_postar'=> 'nullable|max:20',
            'telefoni'   => 'nullable|max:20',
        ]);

        // Nëse shënohet si default, largo default-in e mëparshëm
        if ($request->boolean('default')) {
            ShippingAddress::where('user_id', Auth::id())->update(['default' => false]);
        }

        ShippingAddress::create([
            'user_id'     => Auth::id(),
            'emri'        => $request->emri,
            'mbiemri'     => $request->mbiemri,
            'rruga'       => $request->rruga,
            'qyteti'      => $request->qyteti,
            'shteti'      => $request->shteti ?? 'Kosovë',
            'kodi_postar' => $request->kodi_postar,
            'telefoni'    => $request->telefoni,
            'default'     => $request->boolean('default'),
        ]);

        return back()->with('success', 'Adresa u shtua me sukses!');
    }

    public function destroy($id)
    {
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();
        return back()->with('success', 'Adresa u fshi!');
    }

    public function setDefault($id)
    {
        ShippingAddress::where('user_id', Auth::id())->update(['default' => false]);
        ShippingAddress::where('id', $id)->where('user_id', Auth::id())->update(['default' => true]);
        return back()->with('success', 'Adresa u vendos si kryesore!');
    }
}
