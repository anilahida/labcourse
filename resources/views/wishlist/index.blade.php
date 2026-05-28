@extends('layouts.client')

@section('title', 'Lista e Dëshirave')
@section('page-title', 'Lista e Dëshirave')
@section('page-sub', 'Librat që dëshiron të lexosh')

@section('styles')
<style>
    .wish-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .wish-card {
        background: white;
        border-radius: 14px;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: transform 0.2s;
    }
    .wish-card:hover { transform: translateY(-3px); }
    .wish-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; background: #fdf0f3; margin-bottom: 0.25rem;
    }
    .wish-title { font-weight: 700; font-size: 0.88rem; color: #1a0a0f; }
    .wish-isbn { font-size: 0.72rem; color: #aaa; }
    .wish-actions { display: flex; gap: 8px; margin-top: 0.5rem; }
    .btn-view {
        flex: 1; padding: 0.4rem; background: var(--cherry); color: white;
        border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 700;
        text-align: center; text-decoration: none; cursor: pointer;
        font-family: 'Nunito', sans-serif;
    }
    .btn-remove {
        width: 34px; padding: 0.4rem; background: #fff0f2; color: var(--cherry);
        border: none; border-radius: 8px; font-size: 0.8rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        grid-column: 1 / -1;
    }
    @media(max-width:900px) { .wish-grid { grid-template-columns: repeat(3, 1fr); } }
    @media(max-width:640px) { .wish-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endsection

@section('content')

@foreach(['success','info','error'] as $s)
    @if(session($s))
    <div style="background:{{ $s==='success'?'#d1fae5':($s==='error'?'#fee2e2':'#dbeafe') }};border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;">
        {{ session($s) }}
    </div>
    @endif
@endforeach

<div class="wish-grid">
    @forelse($wishlistItems as $item)
    <div class="wish-card">
        <div class="wish-icon">
            <i class="bi bi-book-half" style="color:var(--cherry);"></i>
        </div>
        <div class="wish-title">{{ $item->book->titulli }}</div>
        <div class="wish-isbn">ISBN: {{ $item->book->isbn }}</div>
        <div class="wish-actions">
            <a href="{{ route('books.show', $item->book->id) }}" class="btn-view">Shiko</a>
            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-remove" title="Hiqe">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-heart" style="font-size:2.5rem;color:#e0d0d4;"></i>
        <p style="color:#aaa;margin-top:0.75rem;font-size:0.9rem;">Lista jote e dëshirave është bosh.</p>
        <a href="{{ route('books.browse') }}" style="color:var(--cherry);font-weight:700;font-size:0.85rem;text-decoration:none;">Shfleto librat →</a>
    </div>
    @endforelse
</div>

@endsection
