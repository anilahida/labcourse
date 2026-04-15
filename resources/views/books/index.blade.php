@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista e Librave</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Shto Libër të Ri</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('books.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Kërko titullin ose autorin..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Kërko</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover border bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Titulli</th>
                    <th>ISBN</th>
                    <th>Autori</th>
                    <th>Kategoria</th>
                    <th>Çmimi</th>
                    <th>Stoku</th>
                    <th class="text-center">Veprimet</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
    <div class="fw-bold">{{ $book->titulli }}</div>
    @if($book->reviews_avg_nota)
        <span class="text-warning small">
            {{ number_format($book->reviews_avg_nota, 1) }} ★
            <span class="text-muted">({{ $book->reviews_count ?? $book->reviews()->count() }})</span>
        </span>
    @else
        <span class="text-muted small">Pa vlerësime</span>
    @endif
</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->author->emri }} {{ $book->author->mbiemri }}</td>
                    <td>{{ $book->category->emri }}</td>
                    <td>{{ number_format($book->cmimi, 2) }} €</td>
                    <td>
                        <span class="badge {{ $book->sasia > 5 ? 'bg-success' : 'bg-danger' }}">
                            {{ $book->sasia }}
                        </span>
                    </td>
                    <td class="text-center">
    <div class="btn-group" role="group">
        <a href="{{ route('books.show', $book->book_id) }}" class="btn btn-sm btn-outline-info">Shiko</a>
        
        <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
        
        <form action="{{ route('books.destroy', $book->book_id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('A jeni të sigurt?')">Fshij</button>
        </form>
    </div>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Nuk u gjet asnjë libër.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection