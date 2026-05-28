@extends('layouts.client')

@section('title', 'Vlerësimet e Mia')
@section('page-title', 'Vlerësimet')
@section('page-sub', 'Vlerësimet dhe komentet e tua për librat')

@section('styles')
<style>
    .reviews-list { display: flex; flex-direction: column; gap: 12px; }
    .review-card {
        background: white; border-radius: 14px; padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex; gap: 1rem; align-items: flex-start;
    }
    .review-book-icon {
        width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
        background: #fdf0f3; display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: var(--cherry);
    }
    .review-title { font-weight: 700; font-size: 0.88rem; color: #1a0a0f; }
    .review-isbn { font-size: 0.7rem; color: #aaa; margin-bottom: 4px; }
    .stars { color: #f59e0b; font-size: 0.85rem; letter-spacing: 1px; }
    .review-comment { font-size: 0.82rem; color: #555; margin-top: 4px; font-style: italic; }
    .review-meta { font-size: 0.7rem; color: #bbb; margin-top: 4px; }
    .btn-del {
        background: #fff0f2; color: var(--cherry); border: none;
        border-radius: 8px; padding: 0.3rem 0.6rem; font-size: 0.75rem;
        cursor: pointer; margin-top: 6px;
    }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;">{{ session('success') }}</div>
@endif

<div class="sec-title">
    Të gjitha vlerësimet
    <span style="font-size:0.78rem;color:#aaa;font-weight:400;">{{ $reviews->count() }} gjithsej</span>
</div>

@if($reviews->isEmpty())
<div class="empty-state">
    <i class="bi bi-star" style="font-size:2.5rem;color:#e0d0d4;"></i>
    <p style="color:#aaa;margin-top:0.75rem;font-size:0.9rem;">Nuk ke dhënë asnjë vlerësim ende.</p>
    <a href="{{ route('books.index') }}" style="color:var(--cherry);font-weight:700;font-size:0.85rem;text-decoration:none;">Shfleto librat →</a>
</div>
@else
<div class="reviews-list">
    @foreach($reviews as $review)
    <div class="review-card">
        <div class="review-book-icon"><i class="bi bi-book-half"></i></div>
        <div style="flex:1;min-width:0;">
            <div class="review-title">{{ $review->book->titulli ?? 'Libër i fshirë' }}</div>
            <div class="review-isbn">ISBN: {{ $review->book->isbn ?? '—' }}</div>
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= $review->nota ? '★' : '☆' }}
                @endfor
                <span style="color:#aaa;font-size:0.72rem;margin-left:4px;">{{ $review->nota }}/5</span>
            </div>
            @if($review->komenti)
            <div class="review-comment">"{{ $review->komenti }}"</div>
            @endif
            <div class="review-meta">{{ $review->created_at->format('d M Y') }}</div>
        </div>
        <div>
            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del" onclick="return confirm('Fshi vlerësimin?')">
                    <i class="bi bi-trash3"></i> Fshi
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
