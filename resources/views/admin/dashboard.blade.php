@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
/* Stats row */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    border: 1px solid #eef0f5;
}
.stat-label {
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: #aaa; margin-bottom: 6px;
}
.stat-value {
    font-size: 1.75rem; font-weight: 900;
    color: #16181D; line-height: 1; margin-bottom: 12px;
}
.stat-bar-wrap { height: 5px; background: #f0f0f5; border-radius: 3px; margin-bottom: 8px; }
.stat-bar      { height: 100%; border-radius: 3px; }
.stat-foot     { font-size: .72rem; color: #aaa; display: flex; align-items: center; justify-content: space-between; }
.bdg-up { background:#dcfce7; color:#16a34a; padding:2px 8px; border-radius:20px; font-size:.68rem; font-weight:700; }
.bdg-dn { background:#fee2e2; color:#dc2626; padding:2px 8px; border-radius:20px; font-size:.68rem; font-weight:700; }

/* Module cards */
.module-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
.mod-card {
    background: white; border-radius: 14px; padding: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05); border: 1px solid #eef0f5;
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; color: inherit;
    transition: transform .2s, box-shadow .2s;
}
.mod-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.1); color: inherit; }
.mod-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; }
.mod-name { font-weight: 800; font-size: .82rem; color: #16181D; margin-bottom: 1px; }
.mod-count { font-size: .68rem; color: #aaa; font-weight: 600; }

/* Bottom grid */
.bottom-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 16px;
}
.panel { background: white; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.05); border: 1px solid #eef0f5; overflow: hidden; }
.panel-hdr { padding: 1rem 1.5rem .75rem; border-bottom: 1px solid #f5f5f7; display: flex; align-items: center; justify-content: space-between; }
.panel-hdr h6 { font-weight: 800; font-size: .9rem; margin: 0; }
.panel-hdr a { color: var(--cherry); font-size: .75rem; font-weight: 700; text-decoration: none; }

/* Table */
.adm-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.adm-table th { padding: .6rem 1rem; font-size: .72rem; font-weight: 700; color: #aaa; text-transform: uppercase; letter-spacing: .3px; background: #fafafa; border-bottom: 1px solid #f0f0f0; text-align: left; }
.adm-table td { padding: .7rem 1rem; border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
.adm-table tr:last-child td { border-bottom: none; }
.adm-table tr:hover td { background: #fafafa; }

/* Recent items panel */
.recent-item { display: flex; align-items: center; gap: 10px; padding: .7rem 1.25rem; border-bottom: 1px solid #f5f5f7; }
.recent-item:last-child { border-bottom: none; }
.ri-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .85rem; }
.ri-name { font-weight: 700; font-size: .8rem; color: #16181D; }
.ri-sub  { font-size: .7rem; color: #aaa; }

/* Status badges */
.s-delivered { background: #dcfce7; color: #16a34a; }
.s-shipped   { background: #dbeafe; color: #2563eb; }
.s-pending   { background: #fef9c3; color: #ca8a04; }
.s-new       { background: #fee2e2; color: var(--cherry); }
.status-pill { padding: 3px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; }

@media(max-width:1200px) { .stats-grid{grid-template-columns:repeat(2,1fr);} .module-grid{grid-template-columns:repeat(3,1fr);} }
@media(max-width:900px)  { .stats-grid{grid-template-columns:repeat(2,1fr);} .module-grid{grid-template-columns:repeat(2,1fr);} .bottom-grid{grid-template-columns:1fr;} }
@media(max-width:600px)  { .stats-grid{grid-template-columns:1fr;} .module-grid{grid-template-columns:repeat(2,1fr);} }
</style>
@endsection

@section('content')

@php
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\User;
use App\Models\Shipment;
use App\Models\Coupon;

$totalRevenue   = Payment::sum('shuma');
$totalBooks     = Book::count();
$totalUsers     = User::count();
$totalAuthors   = Author::count();
$totalCats      = Category::count();
$totalReviews   = Review::count();
$totalWishlist  = Wishlist::count();
$totalCoupons   = Coupon::count();
$totalOrders    = Order::count();
$totalShipments = Shipment::count();
$totalPayments  = Payment::count();

$recentBooks    = Book::with('author')->latest()->take(5)->get();
@endphp

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:10px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;font-size:1.15rem;">Mirë se vini, {{ Auth::user()->name }}! 👋</h4>
        <p style="color:#aaa;margin:0;font-size:.82rem;">Pasqyra e sistemit të bibliotekës</p>
    </div>
    <div style="font-size:.78rem;color:#aaa;">{{ now()->format('d M Y') }}</div>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Të Ardhurat Totale</div>
        <div class="stat-value">€ {{ number_format($totalRevenue, 0) }}</div>
        <div class="stat-bar-wrap"><div class="stat-bar" style="width:65%;background:var(--cherry);"></div></div>
        <div class="stat-foot"><span style="color:#aaa;">Nga {{ $totalPayments }} pagesa</span><span class="bdg-up">▲ Aktiv</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Libra në Sistem</div>
        <div class="stat-value">{{ $totalBooks }}</div>
        <div class="stat-bar-wrap"><div class="stat-bar" style="width:80%;background:#6366f1;"></div></div>
        <div class="stat-foot"><span style="color:#aaa;">{{ $totalAuthors }} autorë</span><span class="bdg-up">▲ Aktiv</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Anëtarë</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-bar-wrap"><div class="stat-bar" style="width:72%;background:#f59e0b;"></div></div>
        <div class="stat-foot"><span style="color:#aaa;">Përdorues aktivë</span><span class="bdg-up">▲ Aktiv</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Vlerësime</div>
        <div class="stat-value">{{ $totalReviews }}</div>
        <div class="stat-bar-wrap"><div class="stat-bar" style="width:45%;background:#22c55e;"></div></div>
        <div class="stat-foot"><span style="color:#aaa;">Nga klientët</span><span class="bdg-up">▲ Aktiv</span></div>
    </div>
</div>

{{-- Module shortcuts --}}
<div class="module-grid">
    <a href="{{ route('books.index') }}" class="mod-card">
        <div class="mod-icon" style="background:#fff0f2;"><i class="bi bi-book-fill" style="color:var(--cherry);"></i></div>
        <div><div class="mod-name">Librat</div><div class="mod-count">{{ $totalBooks }} total</div></div>
    </a>
    <a href="{{ route('authors.index') }}" class="mod-card">
        <div class="mod-icon" style="background:#eff6ff;"><i class="bi bi-person-lines-fill" style="color:#2563eb;"></i></div>
        <div><div class="mod-name">Autorët</div><div class="mod-count">{{ $totalAuthors }} total</div></div>
    </a>
    <a href="{{ route('categories.index') }}" class="mod-card">
        <div class="mod-icon" style="background:#f0fdf4;"><i class="bi bi-grid-fill" style="color:#16a34a;"></i></div>
        <div><div class="mod-name">Kategoritë</div><div class="mod-count">{{ $totalCats }} total</div></div>
    </a>
    <a href="{{ route('orders.index') }}" class="mod-card">
        <div class="mod-icon" style="background:#fefce8;"><i class="bi bi-bag-check-fill" style="color:#ca8a04;"></i></div>
        <div><div class="mod-name">Porositë</div><div class="mod-count">{{ $totalOrders }} total</div></div>
    </a>
    <a href="{{ route('admin.payments') }}" class="mod-card">
        <div class="mod-icon" style="background:#faf5ff;"><i class="bi bi-credit-card-2-front-fill" style="color:#7c3aed;"></i></div>
        <div><div class="mod-name">Pagesat</div><div class="mod-count">{{ $totalPayments }} total</div></div>
    </a>
    <a href="{{ route('admin.coupons') }}" class="mod-card">
        <div class="mod-icon" style="background:#fff0f2;"><i class="bi bi-tag-fill" style="color:var(--cherry);"></i></div>
        <div><div class="mod-name">Kuponat</div><div class="mod-count">{{ $totalCoupons }} total</div></div>
    </a>
</div>

{{-- Bottom: Table + Recent books --}}
<div class="bottom-grid">

    {{-- Orders/Payments table --}}
    <div class="panel">
        <div class="panel-hdr">
            <h6>Pagesat e Fundit</h6>
            <a href="{{ route('admin.payments') }}">Shiko të gjitha →</a>
        </div>
        <table class="adm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Libri</th>
                    <th>Shuma</th>
                    <th>Metoda</th>
                    <th>Data</th>
                    <th>Statusi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(Payment::with('book')->latest()->take(6)->get() as $p)
                <tr>
                    <td style="font-weight:700;color:#aaa;">#{{ str_pad($p->id, 4,'0',STR_PAD_LEFT) }}</td>
                    <td style="font-weight:600;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $p->book->titulli ?? '—' }}</td>
                    <td style="font-weight:700;color:var(--cherry);">€ {{ number_format($p->shuma,2) }}</td>
                    <td style="color:#888;">{{ $p->metoda_pageses ?? 'Kartë' }}</td>
                    <td style="color:#aaa;">{{ $p->created_at->format('d M Y') }}</td>
                    <td><span class="status-pill s-delivered">E kryer</span></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa;">Nuk ka pagesa ende.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent books --}}
    <div class="panel">
        <div class="panel-hdr">
            <h6>Librat e Fundit</h6>
            <a href="{{ route('books.index') }}">Shiko të gjitha →</a>
        </div>
        @foreach($recentBooks as $i => $book)
        @php
        $colors = [['#fff0f2','var(--cherry)'],['#eff6ff','#2563eb'],['#f0fdf4','#16a34a'],['#fefce8','#ca8a04'],['#faf5ff','#7c3aed']];
        $c = $colors[$i % count($colors)];
        @endphp
        <div class="recent-item">
            <div class="ri-icon" style="background:{{ $c[0] }};"><i class="bi bi-book-half" style="color:{{ $c[1] }};"></i></div>
            <div style="flex:1;min-width:0;">
                <div class="ri-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $book->titulli }}</div>
                <div class="ri-sub">{{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}</div>
            </div>
            <span style="font-weight:800;font-size:.8rem;color:var(--cherry);flex-shrink:0;">€{{ number_format($book->cmimi,0) }}</span>
        </div>
        @endforeach
        <div style="padding:.75rem 1.25rem;border-top:1px solid #f5f5f7;">
            <a href="{{ route('books.create') }}" style="display:flex;align-items:center;justify-content:center;gap:6px;background:var(--cherry);color:white;text-decoration:none;border-radius:8px;padding:.45rem;font-size:.78rem;font-weight:700;">
                <i class="bi bi-plus-lg"></i> Shto Libër të Ri
            </a>
        </div>
    </div>

</div>

@endsection
