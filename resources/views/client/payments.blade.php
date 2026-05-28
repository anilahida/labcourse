@extends('layouts.client')

@section('title', 'Pagesat')
@section('page-title', 'Pagesat')
@section('page-sub', 'Historia e blerjeve dhe pagesave')

@section('styles')
<style>
    .pay-table {
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;
    }
    .pay-table table { width: 100%; border-collapse: collapse; }
    .pay-table th {
        background: #fdf8f5; font-size: 0.72rem; font-weight: 700;
        color: #aaa; text-transform: uppercase; letter-spacing: 0.5px;
        padding: 0.75rem 1.25rem; text-align: left; border-bottom: 1px solid #f5f0ec;
    }
    .pay-table td { padding: 0.9rem 1.25rem; font-size: 0.85rem; border-bottom: 1px solid #f5f0ec; color: #333; }
    .pay-table tr:last-child td { border-bottom: none; }
    .pay-table tr:hover td { background: #fdf8f5; }
    .badge-done {
        background: #d1fae5; color: #065f46;
        font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem;
        border-radius: 20px;
    }
    .badge-pend {
        background: #fef3c7; color: #92400e;
        font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem;
        border-radius: 20px;
    }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-row {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 14px; margin-bottom: 1.5rem;
    }
    .stat-box {
        background: white; border-radius: 14px; padding: 1.1rem 1.25rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .stat-box-label { font-size: 0.72rem; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-box-val { font-size: 1.4rem; font-weight: 900; color: #1a0a0f; margin-top: 2px; }
</style>
@endsection

@section('content')

<div class="stat-row">
    <div class="stat-box">
        <div class="stat-box-label">Totali</div>
        <div class="stat-box-val">€ {{ number_format($payments->sum('shuma'), 2) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">Numri i blerjeve</div>
        <div class="stat-box-val">{{ $payments->count() }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">Blerja e fundit</div>
        <div class="stat-box-val" style="font-size:1rem;">
            {{ $payments->first() ? $payments->first()->created_at->format('d M Y') : '—' }}
        </div>
    </div>
</div>

<div class="sec-title">Historia e Pagesave</div>

@if($payments->isEmpty())
<div class="empty-state">
    <i class="bi bi-credit-card" style="font-size:2.5rem;color:#e0d0d4;"></i>
    <p style="color:#aaa;margin-top:0.75rem;font-size:0.9rem;">Nuk ke bërë asnjë blerje ende.</p>
    <a href="{{ route('books.index') }}" style="color:var(--cherry);font-weight:700;font-size:0.85rem;text-decoration:none;">Shfleto librat →</a>
</div>
@else
<div class="pay-table">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Libri</th>
                <th>Shuma</th>
                <th>Metoda</th>
                <th>Statusi</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
            <tr>
                <td style="color:#aaa;font-size:0.75rem;">{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td style="font-weight:600;">{{ $p->book->titulli ?? '—' }}</td>
                <td style="font-weight:700;color:var(--cherry);">€ {{ number_format($p->shuma, 2) }}</td>
                <td>{{ $p->metoda_pageses }}</td>
                <td>
                    <span class="{{ $p->statusi === 'e perfunduar' ? 'badge-done' : 'badge-pend' }}">
                        {{ $p->statusi }}
                    </span>
                </td>
                <td style="color:#aaa;font-size:0.78rem;">{{ $p->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
