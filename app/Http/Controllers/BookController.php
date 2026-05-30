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
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
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
        'author_id' => 'required|exists:authors,id',
        'category_id' => 'required|exists:categories,id',
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
    $book = Book::with(['author', 'category', 'reviews.user'])->findOrFail($id);
    // Klientët shikojnë view-in e klientit, adminët shikojnë view-in e adminit
    if (auth()->user()->is_admin) {
        return view('books.show', compact('book'));
    }
    return view('client.book_show', compact('book'));
}

/**
 * @OA\Get(
 *     path="/api/books",
 *     tags={"Books"},
 *     summary="Merr listën e të gjithë librave",
 *     @OA\Response(response=200, description="Lista e librave me autor, kategori dhe vlerësim mesatar",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="id",                type="integer", example=1),
 *             @OA\Property(property="titulli",           type="string",  example="Gjenerali i Ushtrisë së Vdekur"),
 *             @OA\Property(property="isbn",              type="string",  example="978-9928-08-000-1"),
 *             @OA\Property(property="cmimi",             type="number",  example=14.99),
 *             @OA\Property(property="sasia",             type="integer", example=5),
 *             @OA\Property(property="reviews_avg_nota",  type="number",  example=4.7)
 *         ))
 *     )
 * )
 */
// API — listë librash (JSON) për Vue
public function apiIndex()
{
    $books = Book::with(['author', 'category'])
                 ->withAvg('reviews', 'nota')
                 ->get();
    return response()->json($books);
}

/**
 * @OA\Get(
 *     path="/api/books/{id}",
 *     tags={"Books"},
 *     summary="Merr detajet e një libri me reviews",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer"), example=1),
 *     @OA\Response(response=200, description="Libri me autor, kategori dhe reviews"),
 *     @OA\Response(response=404, description="Libri nuk u gjet")
 * )
 */
// API — libri i vetëm me reviews (JSON) për Vue
public function apiShow($id)
{
    $book = Book::with(['author', 'category', 'reviews.user'])->findOrFail($id);
    return response()->json($book);
}

// Shfletim për klientë
public function browse()
{
    $books      = Book::with(['author', 'category'])->withAvg('reviews', 'nota')->get();
    $categories = \App\Models\Category::orderBy('emri')->get();
    return view('client.browse', compact('books', 'categories'));
}
}