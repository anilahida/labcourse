@extends('layouts.admin')
@section('title','Porositë')

@section('styles')
<style>
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.page-head h4{font-weight:900;margin:0 0 2px;}
.page-head p{color:#aaa;margin:0;font-size:.83rem;}
.adm-table-wrap{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;}
table.at{width:100%;border-collapse:collapse;font-size:.83rem;}
table.at thead tr{background:#fafafa;}
table.at th{padding:10px 16px;color:#aaa;font-weight:700;font-size:.7rem;text-transform:uppercase;letter-spacing:.4px;text-align:left;border-bottom:1px solid #f5f5f5;}
table.at td{padding:11px 16px;border-bottom:1px solid #f5f5f5;color:#333;vertical-align:middle;}
table.at tbody tr:last-child td{border-bottom:none;}
table.at tbody tr:hover td{background:#fdfbfb;}
.act-btns{display:flex;gap:6px;align-items:center;}
.btn-del{background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
/* Status badges */
.sts{font-size:.68rem;font-weight:700;padding:3px 10px;border-radius:20px;white-space:nowrap;}
.sts-delivered{background:#dcfce7;color:#15803d;}
.sts-shipped  {background:#dbeafe;color:#1e40af;}
.sts-pending  {background:#fef3c7;color:#92400e;}
.sts-new      {background:#fff0f2;color:var(--cherry);}
/* Summary chips */
.summary-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;}
.chip{font-size:.72rem;font-weight:700;padding:5px 13px;border-radius:20px;}
.chip-new     {background:#fff0f2;color:var(--cherry);}
.chip-pending {background:#fef3c7;color:#92400e;}
.chip-shipped {background:#dbeafe;color:#1e40af;}
.chip-done    {background:#dcfce7;color:#15803d;}
</style>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h4>Menaxhimi i Porosive</h4>
        <p>{{ $orders->count() }} porosi gjithsej</p>
    </div>
</div>

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
@endif

{{-- Summary chips --}}
@php
    $counts = [
        'new'       => $orders->where('status','new')->count(),
        'pending'   => $orders->where('status','pending')->count(),
        'shipped'   => $orders->where('status','shipped')->count(),
        'delivered' => $orders->where('status','delivered')->count(),
    ];
@endphp
<div class="summary-bar">
    <span class="chip chip-new">{{ $counts['new'] }} E re</span>
    <span class="chip chip-pending">{{ $counts['pending'] }} Pritje</span>
    <span class="chip chip-shipped">{{ $counts['shipped'] }} Dërguar</span>
    <span class="chip chip-done">{{ $counts['delivered'] }} Dorëzuar</span>
</div>

<div class="adm-table-wrap">
    <table class="at">
        <thead>
            <tr>
                <th>#Porosia</th>
                <th>Klienti</th>
                <th>Email</th>
                <th>Totali</th>
                <th>Data</th>
                <th>Statusi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            @php
                $stsMap = [
                    'delivered' => ['sts-delivered', 'Dorëzuar'],
                    'shipped'   => ['sts-shipped',   'Dërguar'],
                    'pending'   => ['sts-pending',   'Pritje'],
                    'new'       => ['sts-new',       'E re'],
                ];
                $sts = $stsMap[$order->status] ?? ['sts-new', ucfirst($order->status)];
            @endphp
            <tr>
                <td style="font-weight:700;color:#aaa;font-size:.78rem;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td style="font-weight:600;">{{ $order->client->name ?? '—' }}</td>
                <td style="color:#aaa;font-size:.78rem;">{{ $order->client->email ?? '—' }}</td>
                <td style="font-weight:700;">€ {{ number_format($order->total_amount, 2) }}</td>
                <td style="color:#aaa;font-size:.78rem;">{{ $order->created_at->format('d.m.Y') }}</td>
                <td><span class="sts {{ $sts[0] }}">{{ $sts[1] }}</span></td>
                <td>
                    <div class="act-btns">
                        <form action="{{ url('orders/'.$order->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-del" onclick="return confirm('Fshi porosinë?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:3rem;color:#aaa;">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                    Nuk ka porosi ende.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
