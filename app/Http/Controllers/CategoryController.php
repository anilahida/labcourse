<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Shfaq listën e kategorive
    public function index()
    {
        $categories = Category::with('parent')->get();
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
        'kategoria_prind_id' => 'nullable|exists:categories,kategori_id',
    ]);

    // 2. Ruajtja vetëm e të dhënave të validuara (kjo e largon _token automatikisht)
    Category::create($validatedData);

    return redirect()->route('categories.index')->with('success', 'Kategoria u krijua me sukses!');
}

    // Shtojmë edhe edit, update, destroy më vonë...
}