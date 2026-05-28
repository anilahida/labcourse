@extends('layouts.client')

@section('title', 'Biblioteka Ime')
@section('page-title', 'Biblioteka Ime')
@section('page-sub', 'Librat e huazuar dhe koleksioni yt')

@section('styles')
<style>
    .books-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 2rem;
    }
    .bc {
        background: white;
        border-radius: 14px;
        border: none;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .bc:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,0.1); }
    .bc-cover {
        aspect-ratio: 3 / 4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        position: relative;
    }
    .bc-info { padding: 0.6rem 0.75rem 0.75rem; }
    .bc-title { font-weight: 700; font-size: 0.78rem; color: #1a0a0f; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
    .bc-author { font-size: 0.68rem; color: #999; margin-bottom: 6px; }
    .prog-bar { height: 4px; background: #f0ebe8; border-radius: 2px; overflow: hidden; }
    .prog-fill { height: 100%; background: var(--cherry); border-radius: 2px; }
    .bc-pct { font-size: 0.65rem; color: #aaa; margin-top: 3px; }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 0.5rem;
    }
    .panel-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .panel-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f5f0ec;
    }
    .panel-row:last-child { border-bottom: none; }
    .panel-icon-circle {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 0.85rem;
    }
    .panel-label { font-weight: 600; font-size: 0.82rem; color: #1a0a0f; }
    .panel-sub { font-size: 0.7rem; color: #aaa; }

    @media(max-width:1100px) { .books-grid { grid-template-columns: repeat(4, 1fr); } }
    @media(max-width:860px)  { .books-grid { grid-template-columns: repeat(3, 1fr); } }
    @media(max-width:600px)  { .books-grid { grid-template-columns: repeat(2, 1fr); } .bottom-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

@if (session('status'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#065f46;">
        {{ session('status') }}
    </div>
@endif

{{-- ── Continue Reading Banner ── --}}
<div class="continue-banner">
    <div style="position:relative;z-index:1;">
        <p class="mb-1" style="color:rgba(255,255,255,0.55);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">
            Vazhdo leximin
        </p>
        <h4 class="fw-bold mb-3" style="font-size:1.35rem;line-height:1.3;">Zbulo Librin<br>Tënd Pasardhës</h4>
        <a href="#" class="c-btn"><i class="bi bi-play-circle-fill"></i> Vazhdo Leximin</a>
    </div>
    <div style="display:flex;gap:14px;align-items:flex-end;position:relative;z-index:1;">
        <div class="book-float" style="background:linear-gradient(135deg,#2d1b33,#4a1942);transform:rotate(-8deg);">📖</div>
        <div class="book-float" style="background:linear-gradient(135deg,#1a3a4a,#0d5c73);transform:rotate(5deg) translateY(-12px);width:88px;height:122px;font-size:2.8rem;">📚</div>
    </div>
</div>

{{-- ── My Books ── --}}
<div class="sec-title">
    Librat e Mi
    <a href="{{ route('books.browse') }}" class="see-all">Shiko të gjitha ›</a>
</div>

<div class="books-grid">
    @foreach([
        ['bi-book-fill','#dbeafe','#1d4ed8','Filozofia','Plato','78'],
        ['bi-book-half','#dcfce7','#15803d','Historia e Shqipërisë','Kristo Frashëri','45'],
        ['bi-journal-richtext','#fef3c7','#b45309','Gjenerali i Ushtrisë','Ismail Kadare','92'],
        ['bi-book-fill','#fce7f3','#9d174d','1984','George Orwell','31'],
        ['bi-journal-bookmark-fill','#ede9fe','#6d28d9','Atomic Habits','James Clear','60'],
    ] as $b)
    <div class="bc shadow-sm">
        <div class="bc-cover" style="background:{{ $b[1] }};">
            <i class="bi {{ $b[0] }}" style="font-size:2.8rem;color:{{ $b[2] }};"></i>
        </div>
        <div class="bc-info">
            <div class="bc-title">{{ $b[3] }}</div>
            <div class="bc-author">{{ $b[4] }}</div>
            <div class="prog-bar">
                <div class="prog-fill" style="width:{{ $b[5] }}%;"></div>
            </div>
            <div class="bc-pct">{{ $b[5] }}% lexuar</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Wishlist + Payments ── --}}
<div class="bottom-grid">
    <div>
        <div class="sec-title">
            Lista e Dëshirave <a href="#" class="see-all">Shiko ›</a>
        </div>
        <div class="panel-card">
            @foreach([
                ['bi-book-half','#dcfce7','#15803d','Dune','Frank Herbert'],
                ['bi-journal-richtext','#dbeafe','#1d4ed8','The Alchemist','Paulo Coelho'],
                ['bi-book-fill','#fce7f3','#9d174d','Brave New World','Aldous Huxley'],
            ] as $w)
            <div class="panel-row">
                <div class="panel-icon-circle" style="background:{{ $w[1] }};">
                    <i class="bi {{ $w[0] }}" style="color:{{ $w[2] }};"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="panel-label text-truncate">{{ $w[3] }}</div>
                    <div class="panel-sub">{{ $w[4] }}</div>
                </div>
                <i class="bi bi-heart-fill" style="color:var(--cherry);font-size:0.85rem;flex-shrink:0;"></i>
            </div>
            @endforeach
        </div>
    </div>

    <div>
        <div class="sec-title">
            Pagesat Recente <a href="#" class="see-all">Shiko ›</a>
        </div>
        <div class="panel-card">
            @foreach([
                ['Abonimi Mujor','€ 9.99','up','Kartë'],
                ['Porosi #00042','€ 24.50','up','PayPal'],
                ['Kupon −15%','−€ 3.75','dn','Zbritje'],
                ['Porosi #00039','€ 18.00','up','Kartë'],
            ] as $p)
            <div class="panel-row">
                <div class="panel-icon-circle" style="background:{{ $p[2]==='up'?'#f0fdf4':'#fff0f2' }};">
                    <i class="bi bi-arrow-{{ $p[2]==='up'?'up':'down' }}-right"
                       style="color:{{ $p[2]==='up'?'#16a34a':'var(--cherry)' }};font-size:0.85rem;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="panel-label">{{ $p[0] }}</div>
                    <div class="panel-sub">{{ $p[3] }}</div>
                </div>
                <span style="font-weight:700;font-size:0.82rem;color:{{ $p[2]==='up'?'#16a34a':'var(--cherry)' }};flex-shrink:0;">
                    {{ $p[1] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
