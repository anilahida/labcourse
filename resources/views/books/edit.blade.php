@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edito Librin: {{ $book->titulli }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('books.update', $book->book_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Titulli</label>
                        <input type="text" name="titulli" class="form-control" value="{{ $book->titulli }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Autori</label>
                        <select name="author_id" class="form-select" required>
                            @foreach($authors as $author)
                                <option value="{{ $author->author_id }}" {{ $book->author_id == $author->author_id ? 'selected' : '' }}>
                                    {{ $author->emri }} {{ $author->mbiemri }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategoria</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->kategori_id }}" {{ $book->category_id == $category->kategori_id ? 'selected' : '' }}>
                                    {{ $category->emri }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Çmimi (€)</label>
                        <input type="number" step="0.01" name="cmimi" class="form-control" value="{{ $book->cmimi }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sasia</label>
                        <input type="number" name="sasia" class="form-control" value="{{ $book->sasia }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4">Përditëso</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Anulo</a>
            </form>
        </div>
    </div>
</div>
@endsection