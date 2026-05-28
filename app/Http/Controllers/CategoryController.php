<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Shfaq listën e kategorive
    public function index() {
    $categories = \App\Models\Category::all();
    return view('categories.index', compact('categories'));
}

    // 2. Shfaq formën për krijim
    public function create()
    {
        $parentCategories = Category::whereNull('kategoria_prind_id')->get();
        return view('categories.create', compact('parentCategories'));
    }

    // 3. Ruaj kategorinë e re në DB
    public function store(Request $request)
{
    // 1. Validimi
    $validatedData = $request->validate([
        'emri' => 'required|max:255',
        'pershkrimi' => 'nullable',
        'kategoria_prind_id' => 'nullable|exists:categories,id',
    ]);

    // 2. Ruajtja vetëm e të dhënave të validuara (kjo e largon _token automatikisht)
    Category::create($validatedData);

    return redirect()->route('categories.index')->with('success', 'Kategoria u krijua me sukses!');
}

    // 4. Shfaq formën për editim
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::whereNull('kategoria_prind_id')
                                    ->where('id', '!=', $id)
                                    ->get();
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    // 5. Ruaj ndryshimet
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'emri'               => 'required|max:255',
            'pershkrimi'         => 'nullable',
            'kategoria_prind_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategoria u përditësua me sukses!');
    }

    // 6. Fshij kategorinë
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categories.index')->with('success', 'Kategoria u fshi me sukses!');
    }
}