@extends('layouts.client')

@section('title', 'Shfleto Librat')
@section('page-title', 'Shfleto Librat')
@section('page-sub', 'Zbulo koleksionin tonë të plotë')

@section('styles')
<style>
.filter-bar{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:20px;}
.srch-wrap-cli{position:relative;flex:1;min-width:200px;}
.srch-wrap-cli i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:.82rem;pointer-events:none;}
.srch-cli{width:100%;padding:.5rem 1rem .5rem 2.25rem;border:1.5px solid #eee;border-radius:10px;font-size:.85rem;font-family:'Nunito',sans-serif;outline:none;background:white;}
.srch-cli:focus{border-color:var(--cherry);box-shadow:0 0 0 3px rgba(196,30,58,.08);}
.cat-pills{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px;}
.cat-pill{padding:4px 13px;border-radius:20px;font-size:.73rem;font-weight:700;border:1.5px solid #e0dbd8;background:white;color:#666;cursor:pointer;transition:all .15s;text-decoration:none;}
.cat-pill:hover,.cat-pill.active{background:var(--cherry);color:white;border-color:var(--cherry);}
.books-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
.book-card{background:white;border-radius:14px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;display:flex;flex-direction:column;}
.book-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(0,0,0,.12);}
.book-cover{aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;font-size:3rem;position:relative;}
.book-stock{position:absolute;top:8px;right:8px;background:rgba(0,0,0,.55);color:white;font-size:.6rem;font-weight:700;padding:2px 7px;border-radius:20px;}
.book-body{padding:.75rem;flex:1;display:flex;flex-direction:column;}
.book-cat-tag{font-size:.62rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px;}
.book-title{font-weight:800;font-size:.85rem;color:#1a0a0f;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;margin-bottom:2px;}
.book-author{font-size:.72rem;color:#888;margin-bottom:8px;}
.book-bottom{display:flex;align-items:center;justify-content:space-between;margin-top:auto;}
.book-price{font-weight:900;font-size:.95rem;color:var(--cherry);}
.book-stars{font-size:.7rem;color:#f59e0b;display:flex;align-items:center;gap:2px;}
.book-actions{display:flex;gap:6px;margin-top:8px;}
.btn-view-book{flex:1;padding:.38rem .5rem;background:#1a0a0f;color:white;border:none;border-radius:8px;font-size:.76rem;font-weight:700;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.3rem;font-family:'Nunito',sans-serif;transition:background .2s;}
.btn-view-book:hover{background:#3d1020;color:white;}
.btn-wish-book{width:34px;height:34px;background:#fff0f2;color:var(--cherry);border:none;border-radius:8px;font-size:.88rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;flex-shrink:0;}
.btn-wish-book:hover{background:var(--cherry);color:white;}
.no-results{text-align:center;padding:3rem 1rem;grid-column:1/-1;color:#aaa;}
@media(max-width:1100px){.books-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:740px){.books-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:500px){.books-grid{grid-template-columns:1fr;}}
</style>
@endsection

@section('content')

@foreach(['success','error'] as $s)
    @if(session($s))
    <div style="background:{{ $s==='success'?'#d1fae5':'#fee2e2' }};border-radius:10px;padding:.7rem 1rem;margin-bottom:14px;font-size:.84rem;">{{ session($s) }}</div>
    @endif
@endforeach

{{-- Filter bar --}}
<div class="filter-bar">
    <div class="srch-wrap-cli">
        <i class="bi bi-search"></i>
        <input type="text" class="srch-cli" id="book-search" placeholder="Kërko titull ose autor..." autocomplete="off">
    </div>
    <span style="color:#aaa;font-size:.82rem;" id="book-count">{{ $books->count() }} libra</span>
</div>

{{-- Category pills --}}
<div class="cat-pills">
    <a href="#" class="cat-pill active" data-cat="">Të gjitha</a>
    @foreach($categories as $cat)
    <a href="#" class="cat-pill" data-cat="{{ $cat->id }}">{{ $cat->emri }}</a>
    @endforeach
</div>

{{-- Books grid --}}
@php
$covers = [
    ['#dbeafe','#1d4ed8'],['#dcfce7','#15803d'],['#fef3c7','#b45309'],
    ['#fce7f3','#9d174d'],['#ede9fe','#6d28d9'],['#fff0f2','#c41e3a'],
    ['#e0f2fe','#0369a1'],['#f0fdf4','#166534'],['#fdf4ff','#86198f'],
    ['#fff7ed','#c2410c'],
];
@endphp

<div class="books-grid" id="books-container">
    @forelse($books as $i => $book)
    @php $clr = $covers[$i % count($covers)]; @endphp
    <div class="book-card"
         data-title="{{ strtolower($book->titulli) }}"
         data-author="{{ strtolower(($book->author->emri ?? '').' '.($book->author->mbiemri ?? '')) }}"
         data-cat="{{ $book->category_id }}">

        <div class="book-cover" style="background:{{ $clr[0] }};">
            <i class="bi bi-book-half" style="color:{{ $clr[1] }};"></i>
            @if($book->sasia > 0)
                <span class="book-stock">{{ $book->sasia }} në stok</span>
            @else
                <span class="book-stock" style="background:rgba(196,30,58,.7);">Pa stok</span>
            @endif
        </div>

        <div class="book-body">
            <div class="book-cat-tag">{{ $book->category->emri ?? '—' }}</div>
            <div class="book-title">{{ $book->titulli }}</div>
            <div class="book-author">{{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}</div>
            <div class="book-bottom">
                <span class="book-price">€ {{ number_format($book->cmimi, 2) }}</span>
                @if($book->reviews_avg_nota)
                <span class="book-stars"><i class="bi bi-star-fill"></i> {{ number_format($book->reviews_avg_nota,1) }}</span>
                @endif
            </div>
            <div class="book-actions">
                <a href="{{ route('books.show', $book->id) }}" class="btn-view-book">
                    <i class="bi bi-eye"></i> Shiko
                </a>
                <form action="{{ route('wishlist.store') }}" method="POST" style="display:contents;">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="submit" class="btn-wish-book" title="Shto në dëshirave">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="no-results">
        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:.5rem;"></i>
        Nuk ka libra.
    </div>
    @endforelse
</div>

<div id="no-match" style="display:none;" class="no-results">
    <i class="bi bi-search" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
    Nuk u gjet asnjë libër.
</div>

@endsection

@section('scripts')
<script>
(function(){
    const cards   = document.querySelectorAll('#books-container .book-card');
    const noMatch = document.getElementById('no-match');
    const counter = document.getElementById('book-count');
    let activeCat = '';

    function filter() {
        const q = (document.getElementById('book-search').value || '').trim().toLowerCase();
        let visible = 0;
        cards.forEach(function(c) {
            const matchCat  = !activeCat || c.dataset.cat === activeCat;
            const matchText = !q || c.dataset.title.includes(q) || c.dataset.author.includes(q);
            const show = matchCat && matchText;
            c.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (noMatch) noMatch.style.display = visible === 0 ? 'block' : 'none';
        if (counter) counter.textContent = visible + ' libra';
    }

    document.getElementById('book-search').addEventListener('input', filter);

    document.querySelectorAll('.cat-pill').forEach(function(pill) {
        pill.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.cat-pill').forEach(function(p){ p.classList.remove('active'); });
            this.classList.add('active');
            activeCat = this.dataset.cat;
            filter();
        });
    });
})();
</script>
@endsection
