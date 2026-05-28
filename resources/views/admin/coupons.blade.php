@extends('layouts.admin')
@section('title','Kuponat')

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
.ptype{font-size:.7rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.ptype-pct{background:#fef3c7;color:#92400e;}
.ptype-fix{background:#dcfce7;color:#15803d;}
.empty-adm{text-align:center;padding:3rem;color:#aaa;font-size:.9rem;}
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Kuponat</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">{{ $coupons->count() }} kupona gjithsej</p>
    </div>
</div>

<div class="adm-table-wrap">
    <div class="adm-table-top">
        <h6>Lista e Kuponave</h6>
    </div>
    @if($coupons->isEmpty())
    <div class="empty-adm"><i class="bi bi-tag" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Nuk ka kupona.</div>
    @else
    <table class="at">
        <thead><tr><th>#</th><th>Kodi</th><th>Tipi</th><th>Vlera</th><th>Krijuar</th><th></th></tr></thead>
        <tbody>
        @foreach($coupons as $c)
        <tr>
            <td style="color:#aaa;font-size:.75rem;">{{ str_pad($c->id,4,'0',STR_PAD_LEFT) }}</td>
            <td><strong style="font-family:monospace;letter-spacing:1px;">{{ strtoupper($c->code) }}</strong></td>
            <td><span class="ptype {{ $c->type==='percent'?'ptype-pct':'ptype-fix' }}">{{ $c->type==='percent'?'Përqindje':'Fikse' }}</span></td>
            <td style="font-weight:700;">{{ $c->type==='percent' ? $c->value.'%' : '€ '.number_format($c->value,2) }}</td>
            <td style="color:#aaa;font-size:.78rem;">{{ $c->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('admin.coupons.destroy',$c->id) }}" method="POST" style="display:inline;">
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
