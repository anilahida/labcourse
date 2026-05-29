@extends('layouts.admin')
@section('title','Autorët')

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
.author-avatar{width:40px;height:40px;border-radius:50%;object-fit:cover;}
.author-initials{width:40px;height:40px;border-radius:50%;background:var(--cherry);color:white;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;}
.act-btns{display:flex;gap:6px;align-items:center;}
.btn-edit{background:#fef3c7;color:#b45309;border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;text-decoration:none;font-weight:600;}
.btn-del{background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
</style>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h4>Menaxhimi i Autorëve</h4>
        <p>{{ $authors->count() }} autorë gjithsej</p>
    </div>
    <a href="{{ route('authors.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Shto Autor të Ri
    </a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
@endif

<div class="adm-table-wrap">
    <table class="at">
        <thead>
            <tr><th></th><th>Emri</th><th>Mbiemri</th><th>Biografia</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($authors as $author)
            <tr>
                <td style="width:56px;">
                    @if($author->foto_autori)
                        <img src="/labcourse/public/images/{{ $author->foto_autori }}" class="author-avatar">
                    @else
                        <div class="author-initials">{{ strtoupper(substr($author->emri,0,1)) }}</div>
                    @endif
                </td>
                <td style="font-weight:700;">{{ $author->emri }}</td>
                <td>{{ $author->mbiemri }}</td>
                <td style="color:#aaa;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:.78rem;">
                    {{ $author->biografia ? Str::limit($author->biografia, 80) : '—' }}
                </td>
                <td>
                    <div class="act-btns">
                        <a href="{{ url('authors/'.$author->id.'/edit') }}" class="btn-edit"><i class="bi bi-pencil"></i> Edito</a>
                        <form action="{{ url('authors/'.$author->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-del" onclick="return confirm('Fshi autorin?')"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:2.5rem;color:#aaa;">Nuk ka autorë.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
