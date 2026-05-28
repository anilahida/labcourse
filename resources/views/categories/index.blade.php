@extends('layouts.admin')
@section('title','Kategoritë')

@section('styles')
<style>
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.page-head h4{font-weight:900;margin:0 0 2px;}
.page-head p{color:#aaa;margin:0;font-size:.83rem;}
.btn-add{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.5rem 1.25rem;font-size:.85rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;font-family:'Nunito',sans-serif;transition:background .2s;}
.btn-add:hover{background:#9B1530;color:white;}
.adm-table-wrap{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;}
table.at{width:100%;border-collapse:collapse;font-size:.83rem;}
table.at thead tr{background:#fafafa;}
table.at th{padding:10px 16px;color:#aaa;font-weight:700;font-size:.7rem;text-transform:uppercase;letter-spacing:.4px;text-align:left;border-bottom:1px solid #f5f5f5;}
table.at td{padding:11px 16px;border-bottom:1px solid #f5f5f5;color:#333;vertical-align:middle;}
table.at tbody tr:last-child td{border-bottom:none;}
table.at tbody tr:hover td{background:#fdfbfb;}
.badge-parent{background:#eff6ff;color:#1d4ed8;font-size:.68rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.badge-child{background:#f5f0ec;color:#888;font-size:.68rem;font-weight:700;padding:2px 9px;border-radius:20px;}
.act-btns{display:flex;gap:6px;}
.btn-del{background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
</style>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h4>Menaxhimi i Kategorive</h4>
        <p>{{ $categories->count() }} kategori gjithsej</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Shto Kategori të Re
    </a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div class="adm-table-wrap">
    <table class="at">
        <thead>
            <tr><th>#</th><th>Emri</th><th>Përshkrimi</th><th>Tipi</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="color:#aaa;font-size:.75rem;width:50px;">{{ $cat->id }}</td>
                <td style="font-weight:700;">{{ $cat->emri }}</td>
                <td style="color:#aaa;max-width:260px;font-size:.78rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $cat->pershkrimi ?: '—' }}
                </td>
                <td>
                    @if($cat->parent)
                        <span class="badge-child">Nënkategori → {{ $cat->parent->emri }}</span>
                    @else
                        <span class="badge-parent">Kryesore</span>
                    @endif
                </td>
                <td>
                    <div class="act-btns">
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-del" onclick="return confirm('Fshi kategorinë?')"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:2.5rem;color:#aaa;">Nuk ka kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
