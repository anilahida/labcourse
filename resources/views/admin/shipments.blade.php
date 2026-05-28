@extends('layouts.admin')
@section('title','Dërgesat')

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
.track-code{font-family:monospace;font-size:.82rem;background:#f5f0ec;padding:.2rem .5rem;border-radius:6px;letter-spacing:1px;}
.sts{font-size:.7rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.sts-done{background:#dcfce7;color:#15803d;}
.sts-tr{background:#dbeafe;color:#1e40af;}
.sts-pend{background:#fef3c7;color:#92400e;}
.empty-adm{text-align:center;padding:3rem;color:#aaa;font-size:.9rem;}
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div style="margin-bottom:18px;">
    <h4 style="font-weight:900;margin:0 0 2px;">Dërgesat</h4>
    <p style="color:#aaa;margin:0;font-size:.83rem;">{{ $shipments->count() }} dërgesa gjithsej</p>
</div>

<div class="adm-table-wrap">
    <div class="adm-table-top"><h6>Lista e Dërgesave</h6></div>
    @if($shipments->isEmpty())
    <div class="empty-adm"><i class="bi bi-truck-front" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Nuk ka dërgesa.</div>
    @else
    <table class="at">
        <thead><tr><th>#Porosia</th><th>Nr. Gjurmimit</th><th>Statusi</th><th>Data</th><th></th></tr></thead>
        <tbody>
        @foreach($shipments as $s)
        @php
            $cls = match(strtolower($s->status)){
                'delivered','dorëzuar'=>'sts-done',
                'in transit','në tranzit'=>'sts-tr',
                default=>'sts-pend'
            };
        @endphp
        <tr>
            <td style="font-weight:700;color:#aaa;font-size:.78rem;">#{{ str_pad($s->order_id,5,'0',STR_PAD_LEFT) }}</td>
            <td><span class="track-code">{{ $s->tracking_number }}</span></td>
            <td><span class="sts {{ $cls }}">{{ $s->status }}</span></td>
            <td style="color:#aaa;font-size:.78rem;">{{ $s->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('admin.shipments.destroy',$s->id) }}" method="POST" style="display:inline;">
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
