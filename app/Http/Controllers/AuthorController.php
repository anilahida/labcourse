<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = \App\Models\Author::all();

        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Krijojmë një objekt të ri nga Modeli Author
        $author = new \App\Models\Author();
        $author->emri = $request->input('emri');
        $author->mbiemri = $request->input('mbiemri');
        $author->biografia = $request->input('biografia');

        // 2. Logjika për ruajtjen e fotos
        if ($request->hasFile('foto_autori')) {
            $file = $request->file('foto_autori');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('images/', $filename); // E dërgon foton te public/images/
            $author->foto_autori = $filename; // Ruajmë vetëm emrin e skedarit në DB
        }

        // 3. Ruajtja përfundimtare në Databazë
        $author->save();

        // 4. Kthehemi te lista kryesore me një mesazh suksesi
        return redirect('authors')->with('success', 'Autori u shtua me sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Gjejmë autorin sipas ID-së dhe e fshijmë
    $author = \App\Models\Author::where('author_id', $id)->first();
    
    if($author) {
        $author->delete();
    }

    return redirect('authors')->with('success', 'Autori u fshi me sukses!');
}
}
