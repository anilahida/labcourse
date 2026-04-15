<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 1. Shfaq listën e librave
public function index(Request $request)
{
    $query = Book::with(['author', 'category'])
                 ->withAvg('reviews', 'nota'); // Kjo shton fushën 'reviews_avg_nota'

    if ($request->has('search')) {
        $search = $request->get('search');
        $query->where('titulli', 'like', "%{$search}%")
              ->orWhereHas('author', function($q) use ($search) {
                  $q->where('emri', 'like', "%{$search}%")
                    ->orWhere('mbiemri', 'like', "%{$search}%");
              });
    }

    $books = $query->get();
    return view('books.index', compact('books'));
}

    // 2. Shfaq formën për krijim
    public function create()
    {
        $authors = Author::all(); // Marrim krejt autorët për dropdown
        $categories = Category::all(); // Marrim krejt kategoritë për dropdown
        return view('books.create', compact('authors', 'categories'));
    }

    // 3. Ruaj librin në databazë
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulli' => 'required|max:255',
            'isbn' => 'required|unique:books,isbn',
            'cmimi' => 'required|numeric',
            'sasia' => 'required|integer',
            'author_id' => 'required|exists:authors,author_id',
            'category_id' => 'required|exists:categories,kategori_id',
            'pershkrimi' => 'nullable'
        ]);

        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Libri u shtua me sukses!');
    }

   // 4. Shfaq formën për editim
public function edit(string $id)
{
    $book = Book::findOrFail($id);
    $authors = Author::all();
    $categories = Category::all();
    return view('books.edit', compact('book', 'authors', 'categories'));
}

// 5. Ruaj ndryshimet në databazë
public function update(Request $request, string $id)
{
    $book = Book::findOrFail($id);

    $validatedData = $request->validate([
        'titulli' => 'required|max:255',
        'isbn' => 'required|unique:books,isbn,' . $book->book_id . ',book_id',
        'cmimi' => 'required|numeric',
        'sasia' => 'required|integer',
        'author_id' => 'required|exists:authors,author_id',
        'category_id' => 'required|exists:categories,kategori_id',
        'pershkrimi' => 'nullable'
    ]);

    $book->update($validatedData);

    return redirect()->route('books.index')->with('success', 'Libri u përditësua me sukses!');
}

// 6. Fshij librin
public function destroy(string $id)
{
    $book = Book::findOrFail($id);
    $book->delete();

    return redirect()->route('books.index')->with('success', 'Libri u fshi me sukses!');
}
public function show($id)
{
    // E marrim librin bashkë me autorin, kategorinë dhe vlerësimet (bashkë me emrat e përdoruesve)
    $book = Book::with(['author', 'category', 'reviews.user'])->findOrFail($id);
    
    return view('books.show', compact('book'));
}
}