@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Lista ime e dëshirave</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($wishlistItems as $item)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-bold text-dark">{{ $item->book->titulli }}</h5>
                            <p class="text-muted small">ISBN: {{ $item->book->isbn }}</p>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('books.show', $item->book->book_id) }}" class="btn btn-sm btn-outline-primary">Shiko Librin</a>
                            
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger w-100 p-0" onclick="return confirm('A jeni të sigurt?')">Hiqe nga lista</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Nuk keni asnjë libër në listë.</h4>
                <a href="{{ route('books.index') }}" class="btn btn-primary mt-3">Shiko librat këtu</a>
            </div>
        @endforelse
    </div>
</div>
@endsection