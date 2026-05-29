@extends('layouts.admin')
@section('title','Vlerësimet')

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
.stars{color:#f59e0b;font-size:.85rem;letter-spacing:1px;}
.empty-adm{text-align:center;padding:3rem;color:#aaa;font-size:.9rem;}
</style>
@endsection

@section('content')
@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div style="margin-bottom:18px;">
    <h4 style="font-weight:900;margin:0 0 2px;">Vlerësimet</h4>
    <p style="color:#aaa;margin:0;font-size:.83rem;">{{ $reviews->count() }} vlerësime gjithsej</p>
</div>

<div class="adm-table-wrap">
    <div class="adm-table-top"><h6>Lista e Vlerësimeve</h6></div>
    @if($reviews->isEmpty())
    <div class="empty-adm"><i class="bi bi-star" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Nuk ka vlerësime.</div>
    @else
    <table class="at">
        <thead><tr><th>#</th><th>Libri</th><th>Përdoruesi</th><th>Nota</th><th>Komenti</th><th>Data</th><th></th></tr></thead>
        <tbody>
        @foreach($reviews as $r)
        <tr>
            <td style="color:#aaa;font-size:.75rem;">{{ str_pad($r->id,4,'0',STR_PAD_LEFT) }}</td>
            <td style="font-weight:600;">{{ $r->book->titulli ?? '—' }}</td>
            <td>{{ $r->user->name ?? '—' }}</td>
            <td>
                <span class="stars">
                    @for($i=1;$i<=5;$i++){{ $i<=$r->nota?'★':'☆' }}@endfor
                </span>
                <span style="color:#aaa;font-size:.72rem;"> {{ $r->nota }}/5</span>
            </td>
            <td style="color:#666;font-style:italic;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $r->komenti ?: '—' }}
            </td>
            <td style="color:#aaa;font-size:.78rem;">{{ $r->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('admin.reviews.destroy',$r->id) }}" method="POST" style="display:inline;">
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
