@extends('layouts.client')

@section('title', 'Dërgesat')
@section('page-title', 'Dërgesat')
@section('page-sub', 'Gjurmo dërgesat e porosive tua')

@section('styles')
<style>
    .ship-table {
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;
    }
    .ship-table table { width: 100%; border-collapse: collapse; }
    .ship-table th {
        background: #fdf8f5; font-size: 0.72rem; font-weight: 700;
        color: #aaa; text-transform: uppercase; letter-spacing: 0.5px;
        padding: 0.75rem 1.25rem; text-align: left; border-bottom: 1px solid #f5f0ec;
    }
    .ship-table td { padding: 0.9rem 1.25rem; font-size: 0.85rem; border-bottom: 1px solid #f5f0ec; color: #333; }
    .ship-table tr:last-child td { border-bottom: none; }
    .ship-table tr:hover td { background: #fdf8f5; }
    .track-code {
        font-family: monospace; font-size: 0.82rem;
        background: #f5f0ec; padding: 0.2rem 0.5rem;
        border-radius: 6px; letter-spacing: 1px;
    }
    .status-badge {
        font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.65rem; border-radius: 20px;
    }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-transit   { background: #dbeafe; color: #1e40af; }
    .status-pending   { background: #fef3c7; color: #92400e; }
    .empty-state {
        text-align: center; padding: 3rem 1rem;
        background: white; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')

<div class="sec-title">Të gjitha dërgesat</div>

@if($shipments->isEmpty())
<div class="empty-state">
    <i class="bi bi-truck-front" style="font-size:2.5rem;color:#e0d0d4;"></i>
    <p style="color:#aaa;margin-top:0.75rem;font-size:0.9rem;">Nuk ke asnjë dërgesë aktive.</p>
</div>
@else
<div class="ship-table">
    <table>
        <thead>
            <tr>
                <th>#Porosia</th>
                <th>Numri i gjurmimit</th>
                <th>Statusi</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipments as $s)
            <tr>
                <td style="font-weight:600;color:#aaa;font-size:0.78rem;">#{{ str_pad($s->order_id, 5, '0', STR_PAD_LEFT) }}</td>
                <td><span class="track-code">{{ $s->tracking_number }}</span></td>
                <td>
                    @php
                        $cls = match(strtolower($s->status)) {
                            'delivered','dorëzuar' => 'status-delivered',
                            'in transit','në tranzit' => 'status-transit',
                            default => 'status-pending'
                        };
                    @endphp
                    <span class="status-badge {{ $cls }}">{{ $s->status }}</span>
                </td>
                <td style="color:#aaa;font-size:0.78rem;">{{ $s->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
