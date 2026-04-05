<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * 1. Shfaqja e listës së autorëve (Read)
     */
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    /**
     * 2. Hapja e formës për krijim (Create)
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * 3. Ruajtja e autorit të ri në Databazë (Store)
     */
    public function store(Request $request)
    {
        $author = new Author();
        $author->emri = $request->input('emri');
        $author->mbiemri = $request->input('mbiemri');
        $author->biografia = $request->input('biografia');

        if ($request->hasFile('foto_autori')) {
            $file = $request->file('foto_autori');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('images/', $filename);
            $author->foto_autori = $filename;
        }

        $author->save();
        return redirect('authors')->with('success', 'Autori u shtua me sukses!');
    }

    /**
     * 4. Shfaqja e formës për editim (Edit)
     */
    public function edit($id)
    {
        $author = Author::find($id);
        return view('authors.edit', compact('author'));
    }

    /**
     * 5. Përditësimi i të dhënave ekzistuese (Update)
     */
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        
        $author->emri = $request->input('emri');
        $author->mbiemri = $request->input('mbiemri');
        $author->biografia = $request->input('biografia');

        if ($request->hasFile('foto_autori')) {
            $file = $request->file('foto_autori');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('images/', $filename);
            $author->foto_autori = $filename;
        }

        $author->save();
        return redirect('authors')->with('success', 'Të dhënat u përditësuan me sukses!');
    }

    /**
     * 6. Fshirja e autorit (Delete)
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        
        if($author) {
            $author->delete();
        }

        return redirect('authors')->with('success', 'Autori u fshi me sukses!');
    }

    /**
     * Opsionale: Shfaqja e një autori specifik
     */
    public function show($id)
    {
        $author = Author::find($id);
        return view('authors.show', compact('author'));
    }
}