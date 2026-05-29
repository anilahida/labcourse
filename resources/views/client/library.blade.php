@extends('layouts.client')

@section('title', 'Biblioteka Ime')
@section('page-title', 'Biblioteka Ime')
@section('page-sub', 'Librat e huazuar dhe koleksioni yt')

@section('content')

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── Continue Reading Banner ── --}}
<div class="continue-banner">
    <div style="position:relative;z-index:1;">
        <p class="mb-1" style="color:rgba(255,255,255,0.55);font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">
            Vazhdo leximin
        </p>
        <h4 class="fw-bold mb-3" style="font-size:1.4rem;">Zbulo Librin<br>Tënd Pasardhës</h4>
        <a href="#" class="c-btn">
            <i class="bi bi-play-circle-fill"></i> Vazhdo Leximin
        </a>
    </div>
    <div class="d-flex gap-3 align-items-end" style="position:relative;z-index:1;">
        <div class="book-float" style="background:linear-gradient(135deg,#2d1b33,#4a1942);transform:rotate(-8deg);">📖</div>
        <div class="book-float" style="background:linear-gradient(135deg,#1a3a4a,#0d5c73);transform:rotate(5deg) translateY(-12px);width:90px;height:125px;font-size:2.8rem;">📚</div>
    </div>
</div>

{{-- ── My Books ── --}}
<div class="sec-title">
    Librat e Mi
    <a href="#" class="see-all">Shiko të gjitha ›</a>
</div>
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 mb-4">
    @foreach([
        ['📘','#e8f4fd','Filozofia','Plato','78'],
        ['📗','#e8fdf4','Historia e Shqipërisë','Kristo Frashëri','45'],
        ['📙','#fdf4e8','Gjenerali i Ushtrisë','Ismail Kadare','92'],
        ['📕','#fde8f4','1984','George Orwell','31'],
        ['📓','#f4e8fd','Atomic Habits','James Clear','60'],
    ] as $b)
    <div class="col">
        <div class="card bc shadow-sm">
            <div class="bc-cover" style="background:{{ $b[1] }};">{{ $b[0] }}</div>
            <div class="p-3">
                <p class="fw-bold mb-0 text-truncate" style="font-size:0.8rem;">{{ $b[2] }}</p>
                <p class="text-muted mb-2" style="font-size:0.7rem;">{{ $b[3] }}</p>
                <div class="prog-bar mb-1">
                    <div class="prog-fill" style="width:{{ $b[4] }}%;"></div>
                </div>
                <p class="text-muted mb-0" style="font-size:0.68rem;">{{ $b[4] }}% lexuar</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Wishlist + Payments ── --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="sec-title">
            Lista e Dëshirave <a href="#" class="see-all">Shiko ›</a>
        </div>
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-0">
                @foreach([
                    ['📗','Dune','Frank Herbert'],
                    ['📘','The Alchemist','Paulo Coelho'],
                    ['📕','Brave New World','Aldous Huxley'],
                ] as $w)
                <div class="d-flex align-items-center gap-3 p-3" style="border-bottom:1px solid #f5f0ec;">
                    <span style="font-size:1.5rem;">{{ $w[0] }}</span>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size:0.82rem;">{{ $w[1] }}</p>
                        <p class="text-muted mb-0" style="font-size:0.7rem;">{{ $w[2] }}</p>
                    </div>
                    <button class="btn btn-sm ms-auto border-0 p-1" style="color:var(--cherry);">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sec-title">
            Pagesat Recente <a href="#" class="see-all">Shiko ›</a>
        </div>
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-0">
                @foreach([
                    ['Abonimi Mujor','€ 9.99','up','Kartë'],
                    ['Porosi #00042','€ 24.50','up','PayPal'],
                    ['Kupon −15%','−€ 3.75','dn','Zbritje'],
                    ['Porosi #00039','€ 18.00','up','Kartë'],
                ] as $p)
                <div class="d-flex align-items-center gap-3 p-3" style="border-bottom:1px solid #f5f0ec;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:36px;height:36px;background:{{ $p[2]==='up'?'#f0fdf4':'#fff0f2' }};">
                        <i class="bi bi-arrow-{{ $p[2]==='up'?'up':'down' }}-right"
                           style="color:{{ $p[2]==='up'?'#16a34a':'var(--cherry)' }};font-size:0.8rem;"></i>
                    </div>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size:0.82rem;">{{ $p[0] }}</p>
                        <p class="text-muted mb-0" style="font-size:0.7rem;">{{ $p[3] }}</p>
                    </div>
                    <span class="ms-auto fw-bold" style="font-size:0.83rem;color:{{ $p[2]==='up'?'#16a34a':'var(--cherry)' }};">
                        {{ $p[1] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
