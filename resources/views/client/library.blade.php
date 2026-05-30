@extends('layouts.client')

@section('title', 'Biblioteka Ime')
@section('page-title', 'Biblioteka Ime')
@section('page-sub', 'Librat e blerë dhe koleksioni yt')

@section('styles')
<style>
.books-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 2rem;
}
.bc {
    background: white; border-radius: 14px;
    overflow: hidden; transition: transform .2s, box-shadow .2s;
    cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.06);
    text-decoration: none; color: inherit; display: block;
}
.bc:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,.1); }
.bc-cover {
    aspect-ratio: 3/4;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.8rem; position: relative;
}
.bc-info { padding: .6rem .75rem .75rem; }
.bc-title { font-weight: 700; font-size: .78rem; color: #1a0a0f; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
.bc-author { font-size: .68rem; color: #999; margin-bottom: 6px; }

.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: .5rem;
}
.panel-card {
    background: white; border-radius: 14px;
    overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.panel-row {
    display: flex; align-items: center; gap: 12px;
    padding: .75rem 1rem; border-bottom: 1px solid #f5f0ec;
}
.panel-row:last-child { border-bottom: none; }
.panel-icon {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: .85rem;
}
.panel-label { font-weight: 600; font-size: .82rem; color: #1a0a0f; }
.panel-sub { font-size: .7rem; color: #aaa; }

.empty-state {
    text-align: center; padding: 2rem 1rem;
    color: #bbb; font-size: .83rem;
}
.empty-state i { font-size: 2rem; display: block; margin-bottom: .5rem; }

@media(max-width:1100px) { .books-grid { grid-template-columns: repeat(4,1fr); } }
@media(max-width:860px)  { .books-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:600px)  { .books-grid { grid-template-columns: repeat(2,1fr); } .bottom-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.7rem 1rem;margin-bottom:1.25rem;font-size:.85rem;">
    {{ session('success') }}
</div>
@endif

{{-- ── Continue Reading Banner ── --}}
<div class="continue-banner" style="margin-bottom:2rem;">
    <div style="position:relative;z-index:1;">
        <p style="color:rgba(255,255,255,.55);font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.25rem;">
            Vazhdo leximin
        </p>
        <h4 style="font-size:1.35rem;font-weight:900;color:white;margin-bottom:1rem;line-height:1.3;">
            Zbulo Librin<br>Tënd Pasardhës
        </h4>
        <a href="{{ route('books.browse') }}" class="c-btn">
            <i class="bi bi-play-circle-fill"></i> Shfleto Librat
        </a>
    </div>
    <div style="display:flex;gap:14px;align-items:flex-end;position:relative;z-index:1;">
        <div class="book-float" style="background:linear-gradient(135deg,#2d1b33,#4a1942);transform:rotate(-8deg);">
            <i class="bi bi-book-fill" style="font-size:2.5rem;color:rgba(255,255,255,.8);"></i>
        </div>
        <div class="book-float" style="background:linear-gradient(135deg,#1a3a4a,#0d5c73);transform:rotate(5deg) translateY(-12px);width:88px;height:122px;">
            <i class="bi bi-journals" style="font-size:2.8rem;color:rgba(255,255,255,.8);"></i>
        </div>
    </div>
</div>

{{-- ── Librat e Mi ── --}}
<div class="sec-title">
    Librat e Mi
    <a href="{{ route('books.browse') }}" class="see-all">Shiko të gjitha ›</a>
</div>

@php
$coverPairs = [
    ['#dbeafe','#1d4ed8'],['#dcfce7','#15803d'],['#fef3c7','#b45309'],
    ['#fce7f3','#9d174d'],['#ede9fe','#6d28d9'],['#fff0f2','#c41e3a'],
];
$icons = ['bi-book-fill','bi-book-half','bi-journal-richtext','bi-journal-bookmark-fill','bi-bookmark-fill'];
@endphp

<div class="books-grid">
    @forelse($myBooks as $i => $payment)
    @php $clr = $coverPairs[$i % count($coverPairs)]; $ico = $icons[$i % count($icons)]; @endphp
    <a href="{{ route('books.show', $payment->book->id) }}" class="bc shadow-sm">
        <div class="bc-cover" style="background:{{ $clr[0] }};">
            <i class="bi {{ $ico }}" style="font-size:2.8rem;color:{{ $clr[1] }};"></i>
        </div>
        <div class="bc-info">
            <div class="bc-title">{{ $payment->book->titulli ?? '—' }}</div>
            <div class="bc-author">{{ $payment->book->author->emri ?? '' }} {{ $payment->book->author->mbiemri ?? '' }}</div>
            <div style="font-size:.7rem;color:#16a34a;font-weight:600;">
                <i class="bi bi-check-circle-fill"></i> Blerë
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1;">
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            Nuk ke blerë asnjë libër ende.
            <br><a href="{{ route('books.browse') }}" style="color:var(--cherry);font-weight:700;font-size:.85rem;">Shfleto librat →</a>
        </div>
    </div>
    @endforelse
</div>

{{-- ── Wishlist + Payments ── --}}
<div class="bottom-grid">

    {{-- Wishlist --}}
    <div>
        <div class="sec-title">
            Lista e Dëshirave
            <a href="{{ route('wishlist.index') }}" class="see-all">Shiko ›</a>
        </div>
        <div class="panel-card">
            @forelse($wishlistItems as $item)
            <div class="panel-row">
                <div class="panel-icon" style="background:#fff0f2;">
                    <i class="bi bi-book-half" style="color:var(--cherry);"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="panel-label text-truncate" style="max-width:180px;">{{ $item->book->titulli ?? '—' }}</div>
                    <div class="panel-sub">{{ $item->book->author->emri ?? '' }} {{ $item->book->author->mbiemri ?? '' }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                    <a href="{{ route('books.show', $item->book->id) }}"
                       style="background:var(--cherry);color:white;border:none;border-radius:6px;padding:3px 10px;font-size:.72rem;font-weight:700;text-decoration:none;">
                        Shiko
                    </a>
                    <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button style="background:#fff0f2;color:var(--cherry);border:none;border-radius:6px;padding:3px 8px;font-size:.72rem;cursor:pointer;">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding:1.5rem;">
                <i class="bi bi-heart" style="font-size:1.6rem;"></i>
                Lista e dëshirave është bosh.
                <br><a href="{{ route('books.browse') }}" style="color:var(--cherry);font-weight:700;font-size:.8rem;">Shfleto librat →</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Pagesat --}}
    <div>
        <div class="sec-title">
            Pagesat Recente
            <a href="{{ route('payments.index') }}" class="see-all">Shiko ›</a>
        </div>
        <div class="panel-card">
            @forelse($recentPayments as $payment)
            <div class="panel-row">
                <div class="panel-icon" style="background:#f0fdf4;">
                    <i class="bi bi-arrow-up-right" style="color:#16a34a;font-size:.85rem;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="panel-label text-truncate" style="max-width:160px;">{{ $payment->book->titulli ?? 'Libër' }}</div>
                    <div class="panel-sub">{{ $payment->created_at->format('d M Y') }}</div>
                </div>
                <span style="font-weight:700;font-size:.82rem;color:#16a34a;flex-shrink:0;">
                    € {{ number_format($payment->shuma, 2) }}
                </span>
            </div>
            @empty
            <div class="empty-state" style="padding:1.5rem;">
                <i class="bi bi-credit-card" style="font-size:1.6rem;"></i>
                Nuk ke bërë asnjë pagesë ende.
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
