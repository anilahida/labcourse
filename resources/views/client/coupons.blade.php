@extends('layouts.client')

@section('title', 'Kuponat')
@section('page-title', 'Kuponat')
@section('page-sub', 'Kuponat e disponueshme për zbritje')

@section('styles')
<style>
    .coupon-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .coupon-card {
        background: white; border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden; position: relative;
    }
    .coupon-top {
        background: linear-gradient(135deg, #1C0A0E, #3d1020);
        padding: 1.25rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .coupon-code {
        font-size: 1.2rem; font-weight: 900; color: white;
        letter-spacing: 2px; font-family: monospace;
    }
    .coupon-val {
        background: var(--cherry); color: white;
        border-radius: 8px; padding: 0.35rem 0.75rem;
        font-size: 0.88rem; font-weight: 700;
    }
    .coupon-bottom {
        padding: 1rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .coupon-type { font-size: 0.78rem; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .coupon-dashes {
        position: absolute; left: 0; right: 0;
        top: 50%; transform: translateY(-50%);
        border-top: 2px dashed #f5f0ec;
    }
    .btn-copy {
        background: var(--cherry); color: white;
        border: none; border-radius: 8px; padding: 0.35rem 0.85rem;
        font-size: 0.78rem; font-weight: 700; cursor: pointer;
        font-family: 'Nunito', sans-serif;
    }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        grid-column: 1 / -1;
    }
    @media(max-width:860px) { .coupon-grid { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width:560px) { .coupon-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

<div class="sec-title">
    Kuponat e Disponueshme
    <span style="font-size:0.78rem;color:#aaa;font-weight:400;">{{ $coupons->count() }} gjithsej</span>
</div>

<div class="coupon-grid">
    @forelse($coupons as $coupon)
    <div class="coupon-card">
        <div class="coupon-top">
            <div class="coupon-code">{{ strtoupper($coupon->code) }}</div>
            <div class="coupon-val">
                @if($coupon->type === 'percent')
                    {{ $coupon->value }}%
                @else
                    € {{ number_format($coupon->value, 2) }}
                @endif
            </div>
        </div>
        <div class="coupon-bottom">
            <div class="coupon-type">
                {{ $coupon->type === 'percent' ? 'Zbritje në %' : 'Zbritje fikse' }}
            </div>
            <button class="btn-copy" onclick="navigator.clipboard.writeText('{{ $coupon->code }}');this.textContent='Kopjuar!';">
                <i class="bi bi-clipboard"></i> Kopjo
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-tag" style="font-size:2.5rem;color:#e0d0d4;"></i>
        <p style="color:#aaa;margin-top:0.75rem;font-size:0.9rem;">Nuk ka kupona të disponueshme momentalisht.</p>
    </div>
    @endforelse
</div>

@endsection
