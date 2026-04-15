@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h2 class="fw-bold">{{ $book->titulli }}</h2>
                    <p class="text-muted small">ISBN: {{ $book->isbn }}</p>
                    <hr>
                    <ul class="list-unstyled text-start">
                        <li><strong>Autori:</strong> {{ $book->author->emri }} {{ $book->author->mbiemri }}</li>
                        <li><strong>Kategoria:</strong> {{ $book->category->emri }}</li>
                        <li><strong>Çmimi:</strong> <span class="text-success fw-bold">{{ $book->cmimi }} €</span></li>
                    </ul>
                    
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100 mt-3">Kthehu te Lista</a>

                    @auth
                        <form action="{{ route('wishlist.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fa fa-heart"></i> Shto në List
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-white fw-bold">Vlerësimet e Lexuesve</div>
                <div class="card-body">
                    @forelse($book->reviews as $review)
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-warning text-dark">{{ $review->nota }} / 5 ★</span>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <h6 class="mt-2 mb-1 fw-bold">{{ $review->user->name ?? 'Përdorues i paidentifikuar' }}</h6>
                            <p class="mb-0 text-secondary">{{ $review->komenti }}</p>
                            
                            {{-- Butonat Update/Delete për Review --}}
                            @if(auth()->id() == $review->user_id)
                                <div class="mt-2">
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('A jeni të sigurt?')">Fshij</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Nuk ka ende vlerësime për këtë libër.</p>
                    @endforelse
                </div>
            </div>

            @auth
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Lini një vlerësim</h5>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Nota</label>
                                <select name="nota" class="form-select" required>
                                    <option value="5">5 - Shkëlqyeshëm</option>
                                    <option value="4">4 - Shumë mirë</option>
                                    <option value="3">3 - Mirë</option>
                                    <option value="2">2 - Mjaftueshëm</option>
                                    <option value="1">1 - Dobët</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Komenti (Opsionale)</label>
                                <textarea name="komenti" class="form-control" rows="3" placeholder="Shkruani mendimin tuaj..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary px-4">Dërgo Vlerësimin</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-light border text-center">
                    Duhet të jeni të <a href="{{ route('login') }}">loguar</a> për të lënë një vlerësim ose për të shtuar në Wishlist.
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection