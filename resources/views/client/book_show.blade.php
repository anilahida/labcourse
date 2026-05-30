@extends('layouts.client')

@section('title', $book->titulli)
@section('page-title', $book->titulli)
@section('page-sub', ($book->author->emri ?? '') . ' ' . ($book->author->mbiemri ?? ''))

@section('styles')
<style>
.book-layout{display:grid;grid-template-columns:260px 1fr;gap:24px;align-items:start;}
.book-cover-panel{background:white;border-radius:18px;padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,.07);display:flex;flex-direction:column;align-items:center;gap:.75rem;}
.book-cover-img{width:100%;aspect-ratio:3/4;border-radius:12px;background:linear-gradient(135deg,#fdf0f3,#ffe4ec);display:flex;align-items:center;justify-content:center;font-size:4.5rem;margin-bottom:.5rem;}
.book-price-big{font-size:1.5rem;font-weight:900;color:var(--cherry);}
.btn-buy{width:100%;padding:.6rem;background:var(--cherry);color:white;border:none;border-radius:10px;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;}
.btn-buy:hover{background:#9B1530;color:white;}
.btn-wish-lg{width:100%;padding:.55rem;background:#fff0f2;color:var(--cherry);border:1.5px solid #ffd0d8;border-radius:10px;font-size:.85rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:.4rem;}
.btn-wish-lg:hover{background:var(--cherry);color:white;border-color:var(--cherry);}
.book-info-panel{display:flex;flex-direction:column;gap:16px;}
.info-card{background:white;border-radius:16px;padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,.06);}
.info-row{display:flex;justify-content:space-between;font-size:.83rem;padding:6px 0;border-bottom:1px solid #f5f0ec;}
.info-row:last-child{border-bottom:none;}
.info-lbl{color:#aaa;font-weight:600;}
.info-val{font-weight:700;color:#1a0a0f;}
.rev-card{background:white;border-radius:12px;padding:1rem 1.25rem;box-shadow:0 1px 6px rgba(0,0,0,.05);margin-bottom:10px;}
.rev-stars{color:#f59e0b;font-size:.85rem;margin-bottom:4px;}
.rev-text{font-size:.83rem;color:#555;font-style:italic;margin:4px 0;}
.rev-by{font-size:.7rem;color:#bbb;}
.form-lbl{display:block;font-size:.76rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-sel,.form-ta{width:100%;padding:.5rem .85rem;border:1.5px solid #e8e4e1;border-radius:10px;font-size:.85rem;font-family:'Nunito',sans-serif;outline:none;margin-bottom:.75rem;background:white;}
.form-sel:focus,.form-ta:focus{border-color:var(--cherry);}
.btn-rev{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.5rem 1.25rem;font-size:.84rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;}
@media(max-width:800px){.book-layout{grid-template-columns:1fr;}}
</style>
@endsection

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('books.browse') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;">
        <i class="bi bi-arrow-left"></i> Kthehu te librat
    </a>
</div>

@foreach(['success','error'] as $s)
    @if(session($s))
    <div style="background:{{ $s==='success'?'#d1fae5':'#fee2e2' }};border-radius:10px;padding:.7rem 1rem;margin-bottom:14px;font-size:.84rem;">
        {{ session($s) }}
    </div>
    @endif
@endforeach

<div class="book-layout">

    {{-- Cover + actions --}}
    <div class="book-cover-panel">
        <div class="book-cover-img">
            <i class="bi bi-book-half" style="color:var(--cherry);"></i>
        </div>
        <div class="book-price-big">€ {{ number_format($book->cmimi, 2) }}</div>

        <a href="{{ route('payments.checkout', $book->id) }}" class="btn-buy">
            <i class="bi bi-bag-fill"></i> Bli Tani
        </a>

        <form action="{{ route('wishlist.store') }}" method="POST" style="width:100%;">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <button type="submit" class="btn-wish-lg">
                <i class="bi bi-heart-fill"></i> Shto në Dëshirave
            </button>
        </form>

        <div style="font-size:.72rem;color:#aaa;text-align:center;">
            @if($book->sasia > 0)
                <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i> {{ $book->sasia }} ekzemplarë në stok
            @else
                <i class="bi bi-x-circle-fill" style="color:var(--cherry);"></i> Pa stok momentalisht
            @endif
        </div>
    </div>

    {{-- Info + reviews --}}
    <div class="book-info-panel">

        <div class="info-card">
            <h4 style="font-weight:900;margin:0 0 4px;">{{ $book->titulli }}</h4>
            <p style="color:#aaa;font-size:.83rem;margin:0 0 14px;">
                {{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}
                @if($book->category) · {{ $book->category->emri }} @endif
            </p>

            @if($book->pershkrimi)
            <p style="font-size:.86rem;color:#444;line-height:1.7;margin-bottom:14px;">{{ $book->pershkrimi }}</p>
            @endif

            <div>
                <div class="info-row"><span class="info-lbl">ISBN</span><span class="info-val">{{ $book->isbn }}</span></div>
                <div class="info-row"><span class="info-lbl">Kategoria</span><span class="info-val">{{ $book->category->emri ?? '—' }}</span></div>
                <div class="info-row"><span class="info-lbl">Autori</span><span class="info-val">{{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}</span></div>
                <div class="info-row"><span class="info-lbl">Çmimi</span><span class="info-val" style="color:var(--cherry);">€ {{ number_format($book->cmimi, 2) }}</span></div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="info-card">
            <div style="font-weight:800;font-size:.95rem;margin-bottom:14px;">
                Vlerësimet
                @php $avgRating = $book->reviews->avg('nota'); @endphp
                @if($avgRating)
                <span style="color:#f59e0b;font-size:.85rem;margin-left:8px;">
                    <i class="bi bi-star-fill"></i> {{ number_format($avgRating,1) }}
                </span>
                @endif
                <span style="color:#aaa;font-size:.75rem;font-weight:600;">({{ $book->reviews->count() }})</span>
            </div>

            @forelse($book->reviews as $rev)
            <div class="rev-card">
                <div class="rev-stars">
                    @for($s=1;$s<=5;$s++)
                        <i class="bi bi-star{{ $s<=$rev->nota?'-fill':'' }}"></i>
                    @endfor
                </div>
                @if($rev->komenti)
                    <div class="rev-text">"{{ $rev->komenti }}"</div>
                @endif
                <div class="rev-by">{{ $rev->user->name ?? 'Anonim' }} · {{ $rev->created_at->format('d M Y') }}</div>

                @if(Auth::check() && (int)Auth::id() === (int)$rev->user_id)
                <div style="margin-top:8px;">
                    <form action="{{ route('reviews.destroy', $rev->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button style="background:#fff0f2;color:var(--cherry);border:none;border-radius:6px;padding:3px 10px;font-size:.72rem;font-weight:700;cursor:pointer;font-family:'Nunito',sans-serif;">
                            <i class="bi bi-trash3"></i> Fshi
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <p style="color:#aaa;font-size:.83rem;text-align:center;padding:1rem 0;">Nuk ka vlerësime ende. Ji i pari!</p>
            @endforelse

            {{-- Review form --}}
            @auth
            @php $myReview = $book->reviews->first(fn($r) => (int)$r->user_id === (int)Auth::id()); @endphp
            @if(!$myReview)
            <div style="border-top:1px solid #f5f0ec;margin-top:14px;padding-top:14px;">
                <div style="font-weight:700;font-size:.85rem;margin-bottom:12px;">Lër Vlerësimin Tënd</div>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <label class="form-lbl">Nota</label>
                    <select name="nota" class="form-sel" required>
                        @for($n=5;$n>=1;$n--)
                        <option value="{{ $n }}">{{ $n }} {{ $n==5?'★★★★★':($n==4?'★★★★☆':($n==3?'★★★☆☆':($n==2?'★★☆☆☆':'★☆☆☆☆'))) }}</option>
                        @endfor
                    </select>
                    <label class="form-lbl">Komenti (opsional)</label>
                    <textarea name="komenti" class="form-ta" rows="3" placeholder="Çfarë mendon për këtë libër?"></textarea>
                    <button type="submit" class="btn-rev"><i class="bi bi-send-fill"></i> Dërgo Vlerësimin</button>
                </form>
            </div>
            @endif
            @endauth
        </div>

    </div>
</div>
@endsection
