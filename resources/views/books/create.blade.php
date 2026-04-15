@extends('layouts.app')

@section('content')
<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger mb-4 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Shto Libër të Ri</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Titulli i Librit</label>
                        <input type="text" name="titulli" class="form-control" placeholder="Shkruaj titullin..." required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Psh: 978-3-16-148410-0" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Zgjidh Autorin</label>
                        <select name="author_id" class="form-select" required>
                            <option value="">-- Zgjidh --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->author_id }}">{{ $author->emri }} {{ $author->mbiemri }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Zgjidh Kategorinë</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Zgjidh --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->kategori_id }}">{{ $category->emri }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Çmimi (€)</label>
                        <input type="number" step="0.01" name="cmimi" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Sasia në Stok</label>
                        <input type="number" name="sasia" class="form-control" placeholder="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Përshkrimi i shkurtër</label>
                    <textarea name="pershkrimi" class="form-control" rows="3" placeholder="Përshkruaj librin..."></textarea>
                </div>

                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-success px-5">Ruaj Librin</button>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary px-4">Anulo</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection