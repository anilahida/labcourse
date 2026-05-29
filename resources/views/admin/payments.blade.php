@extends('layouts.admin')
@section('title','Pagesat')

@section('styles')
<style>
.adm-table-wrap{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;}
.adm-table-top{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid #f5f5f5;}
.adm-table-top h6{font-weight:800;font-size:.95rem;margin:0;}
table.at{width:100%;border-collapse:collapse;font-size:.83rem;}
table.at thead tr{background:#fafafa;}
table.at th{padding:10px 16px;color:#aaa;font-weight:700;font-size:.7rem;text-transform:uppercase;letter-spacing:.4px;text-align:left;border-bottom:1px solid #f5f5f5;}
table.at td{padding:11px 16px;border-bottom:1px solid #f5f5f5;color:#333;}
table.at tbody tr:last-child td{border-bottom:none;}
table.at tbody tr:hover td{background:#fdfbfb;}
.btn-del{background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.3rem .7rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:700;}
.sts-done{background:#dcfce7;color:#15803d;font-size:.7rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.sts-pend{background:#fef3c7;color:#92400e;font-size:.7rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.stat-row-top{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:18px;}
.stat-mini{background:white;border-radius:14px;border:1px solid #eef0f5;padding:1rem 1.25rem;box-shadow:0 1px 4px rgba(0,0,0,.05);}
.stat-mini-lbl{font-size:.7rem;text-transform:uppercase;letter-spacing:.5px;color:#aaa;font-weight:700;}
.stat-mini-val{font-size:1.4rem;font-weight:900;color:#16181D;margin-top:2px;}
.empty-adm{text-align:center;padding:3rem;color:#aaa;font-size:.9rem;}
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Pagesat</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Historia e të gjitha pagesave</p>
    </div>
</div>

<div class="stat-row-top">
    <div class="stat-mini">
        <div class="stat-mini-lbl">Totali</div>
        <div class="stat-mini-val">€ {{ number_format($payments->sum('shuma'),2) }}</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-lbl">Nr. Transaksioneve</div>
        <div class="stat-mini-val">{{ $payments->count() }}</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-lbl">Mesatarja</div>
        <div class="stat-mini-val">€ {{ $payments->count() ? number_format($payments->avg('shuma'),2) : '0.00' }}</div>
    </div>
</div>

<div class="adm-table-wrap">
    <div class="adm-table-top"><h6>Lista e Pagesave</h6></div>
    @if($payments->isEmpty())
    <div class="empty-adm"><i class="bi bi-credit-card" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Nuk ka pagesa.</div>
    @else
    <table class="at">
        <thead><tr><th>#</th><th>Libri</th><th>Shuma</th><th>Metoda</th><th>Statusi</th><th>Data</th><th></th></tr></thead>
        <tbody>
        @foreach($payments as $p)
        <tr>
            <td style="color:#aaa;font-size:.75rem;">{{ str_pad($p->id,5,'0',STR_PAD_LEFT) }}</td>
            <td style="font-weight:600;">{{ $p->book->titulli ?? '—' }}</td>
            <td style="font-weight:700;color:var(--cherry);">€ {{ number_format($p->shuma,2) }}</td>
            <td>{{ $p->metoda_pageses }}</td>
            <td><span class="{{ $p->statusi==='e perfunduar'?'sts-done':'sts-pend' }}">{{ $p->statusi }}</span></td>
            <td style="color:#aaa;font-size:.78rem;">{{ $p->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('admin.payments.destroy',$p->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn-del" onclick="return confirm('Fshi?')"><i class="bi bi-trash3"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
