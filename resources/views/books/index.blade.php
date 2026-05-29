@extends('layouts.admin')
@section('title','Librat')

@section('styles')
<style>
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.page-head h4{font-weight:900;margin:0 0 2px;}
.page-head p{color:#aaa;margin:0;font-size:.83rem;}
.btn-add{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.5rem 1.25rem;font-size:.85rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;}
.btn-add:hover{background:#9B1530;color:white;}
.srch-wrap{background:white;border-radius:14px;border:1px solid #eef0f5;padding:1rem 1.25rem;margin-bottom:16px;display:flex;gap:10px;}
.srch-inp{flex:1;border:1.5px solid #eef0f5;border-radius:10px;padding:.5rem .9rem;font-size:.85rem;font-family:'Nunito',sans-serif;outline:none;}
.srch-inp:focus{border-color:var(--cherry);}
.btn-srch{background:var(--bg);border:none;border-radius:10px;padding:.5rem 1rem;font-size:.83rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;}
.adm-table-wrap{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);overflow:hidden;}
table.at{width:100%;border-collapse:collapse;font-size:.83rem;}
table.at thead tr{background:#fafafa;}
table.at th{padding:10px 16px;color:#aaa;font-weight:700;font-size:.7rem;text-transform:uppercase;letter-spacing:.4px;text-align:left;border-bottom:1px solid #f5f5f5;}
table.at td{padding:11px 16px;border-bottom:1px solid #f5f5f5;color:#333;vertical-align:middle;}
table.at tbody tr:last-child td{border-bottom:none;}
table.at tbody tr:hover td{background:#fdfbfb;}
.stk-ok{background:#dcfce7;color:#15803d;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px;}
.stk-lo{background:#fee2e2;color:#dc2626;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:20px;}
.stars{color:#f59e0b;font-size:.75rem;}
.act-btns{display:flex;gap:6px;align-items:center;}
.btn-view{background:#eff6ff;color:#1d4ed8;border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;text-decoration:none;font-weight:600;}
.btn-edit{background:#fef3c7;color:#b45309;border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;text-decoration:none;font-weight:600;}
.btn-del{background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;padding:.28rem .65rem;font-size:.75rem;cursor:pointer;font-family:'Nunito',sans-serif;font-weight:600;}
</style>
@endsection

@section('content')
<div class="page-head">
    <div>
        <h4>Menaxhimi i Librave</h4>
        <p>Shto, edito dhe fshi librat nga katalogu</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Shto Libër të Ri
    </a>
</div>

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
@endif

<form action="{{ route('books.index') }}" method="GET">
<div class="srch-wrap">
    <input type="text" name="search" class="srch-inp" placeholder="Kërko titullin ose autorin..." value="{{ request('search') }}">
    <button type="submit" class="btn-srch"><i class="bi bi-search"></i> Kërko</button>
    @if(request('search'))
        <a href="{{ route('books.index') }}" class="btn-srch" style="text-decoration:none;color:#aaa;">✕ Pastro</a>
    @endif
</div>
</form>

<div class="adm-table-wrap">
    <table class="at">
        <thead>
            <tr>
                <th>Titulli</th>
                <th>ISBN</th>
                <th>Autori</th>
                <th>Kategoria</th>
                <th>Çmimi</th>
                <th>Stoku</th>
                <th>Nota</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td style="font-weight:700;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $book->titulli }}</td>
                <td style="font-family:monospace;font-size:.78rem;color:#aaa;">{{ $book->isbn }}</td>
                <td>{{ $book->author->emri ?? '—' }} {{ $book->author->mbiemri ?? '' }}</td>
                <td style="color:#aaa;">{{ $book->category->emri ?? '—' }}</td>
                <td style="font-weight:700;">€ {{ number_format($book->cmimi,2) }}</td>
                <td><span class="{{ $book->sasia > 5 ? 'stk-ok' : 'stk-lo' }}">{{ $book->sasia }}</span></td>
                <td>
                    @if($book->reviews_avg_nota)
                        <span class="stars">{{ number_format($book->reviews_avg_nota,1) }} ★</span>
                    @else
                        <span style="color:#ddd;font-size:.72rem;">—</span>
                    @endif
                </td>
                <td>
                    <div class="act-btns">
                        <a href="{{ route('books.show', $book->id) }}" class="btn-view"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn-edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-del" onclick="return confirm('Fshi librin?')"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:2.5rem;color:#aaa;">Nuk u gjet asnjë libër.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
