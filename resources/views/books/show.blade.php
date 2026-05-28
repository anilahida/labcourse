@extends('layouts.admin')
@section('title', $book->titulli)

@section('styles')
<style>
.show-wrap{display:grid;grid-template-columns:300px 1fr;gap:20px;}
.book-panel{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);padding:1.5rem;align-self:start;}
.book-cover{width:100%;aspect-ratio:3/4;background:linear-gradient(135deg,#fdf0f3,#fff0f5);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:4rem;margin-bottom:1.25rem;}
.book-title{font-weight:900;font-size:1.1rem;color:#1a0a0f;margin-bottom:4px;}
.book-meta{font-size:.78rem;color:#aaa;margin-bottom:12px;}
.book-info-row{display:flex;justify-content:space-between;font-size:.82rem;padding:6px 0;border-bottom:1px solid #f5f0ec;}
.book-info-row:last-child{border-bottom:none;}
.book-info-lbl{color:#aaa;font-weight:600;}
.book-info-val{font-weight:700;color:#1a0a0f;}
.btn-cherry{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.5rem 1.1rem;font-size:.82rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;font-family:'Nunito',sans-serif;width:100%;justify-content:center;margin-top:.5rem;cursor:pointer;transition:background .2s;}
.btn-cherry:hover{background:#9B1530;color:white;}
.btn-outline{background:white;color:var(--cherry);border:1.5px solid var(--cherry);border-radius:10px;padding:.45rem 1.1rem;font-size:.82rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;font-family:'Nunito',sans-serif;width:100%;justify-content:center;margin-top:.5rem;cursor:pointer;transition:all .2s;}
.btn-outline:hover{background:#fff0f2;}
.reviews-panel{display:flex;flex-direction:column;gap:12px;}
.rev-card{background:white;border-radius:14px;border:1px solid #eef0f5;padding:1rem 1.25rem;}
.stars{color:#f59e0b;font-size:.85rem;}
.rev-comment{font-size:.83rem;color:#555;margin-top:4px;font-style:italic;}
.rev-meta{font-size:.7rem;color:#bbb;margin-top:4px;}
.form-card{background:white;border-radius:14px;border:1px solid #eef0f5;padding:1.25rem;}
.form-lbl{display:block;font-size:.75rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-sel,.form-ta{width:100%;padding:.5rem .85rem;border:1.5px solid #e8e4e1;border-radius:10px;font-size:.85rem;font-family:'Nunito',sans-serif;outline:none;transition:border-color .2s;background:white;margin-bottom:.75rem;}
.form-sel:focus,.form-ta:focus{border-color:var(--cherry);}
.sec-h{font-weight:800;font-size:.95rem;margin:0 0 14px;}
@media(max-width:800px){.show-wrap{grid-template-columns:1fr;}}
</style>
@endsection

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">{{ $book->titulli }}</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Detajet e librit</p>
    </div>
    <a href="{{ route('books.index') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;"><i class="bi bi-arrow-left"></i> Kthehu</a>
</div>

<div class="show-wrap">
    {{-- Left panel --}}
    <div class="book-panel">
        <div class="book-cover"><i class="bi bi-book-half" style="color:var(--cherry);"></i></div>
        <div class="book-title">{{ $book->titulli }}</div>
        <div class="book-meta">ISBN: {{ $book->isbn }}</div>
        <div class="book-info-row"><span class="book-info-lbl">Autori</span><span class="book-info-val">{{ $book->author->emri ?? '—' }} {{ $book->author->mbiemri ?? '' }}</span></div>
        <div class="book-info-row"><span class="book-info-lbl">Kategoria</span><span class="book-info-val">{{ $book->category->emri ?? '—' }}</span></div>
        <div class="book-info-row"><span class="book-info-lbl">Çmimi</span><span class="book-info-val" style="color:var(--cherry);">€ {{ number_format($book->cmimi,2) }}</span></div>
        <div class="book-info-row"><span class="book-info-lbl">Stoku</span><span class="book-info-val">{{ $book->sasia }} copë</span></div>
        @if($book->pershkrimi)
        <p style="font-size:.78rem;color:#888;margin-top:12px;line-height:1.6;">{{ $book->pershkrimi }}</p>
        @endif

        @auth
            <form action="{{ route('wishlist.store') }}" method="POST" style="margin-top:.75rem;">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button type="submit" class="btn-outline"><i class="bi bi-heart-fill"></i> Shto në Listë</button>
            </form>
            @if(auth()->user()->is_admin)
            <a href="{{ route('books.edit', $book->id) }}" class="btn-cherry"><i class="bi bi-pencil"></i> Edito</a>
            @endif
        @endauth
    </div>

    {{-- Right panel --}}
    <div>
        @if(session('success'))
        <div style="background:#d1fae5;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.85rem;">{{ session('success') }}</div>
        @endif

        <div class="sec-h">Vlerësimet ({{ $book->reviews->count() }})</div>
        <div class="reviews-panel" style="margin-bottom:20px;">
            @forelse($book->reviews as $review)
            <div class="rev-card">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <strong style="font-size:.85rem;">{{ $review->user->name ?? '—' }}</strong>
                        <span class="stars" style="margin-left:8px;">
                            @for($i=1;$i<=5;$i++){{ $i<=$review->nota?'★':'☆' }}@endfor
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:.7rem;color:#bbb;">{{ $review->created_at->format('d M Y') }}</span>
                        @if(auth()->id()==$review->user_id || (auth()->check() && auth()->user()->is_admin))
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button style="background:none;border:none;color:#aaa;cursor:pointer;font-size:.8rem;" onclick="return confirm('Fshi?')"><i class="bi bi-trash3"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
                @if($review->komenti)
                <div class="rev-comment">"{{ $review->komenti }}"</div>
                @endif
            </div>
            @empty
            <div style="text-align:center;padding:2rem;background:white;border-radius:14px;border:1px solid #eef0f5;color:#aaa;font-size:.85rem;">
                Nuk ka ende vlerësime.
            </div>
            @endforelse
        </div>

        @auth
        <div class="sec-h">Lër një vlerësim</div>
        <div class="form-card">
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <label class="form-lbl">Nota</label>
                <select name="nota" class="form-sel" required>
                    <option value="5">5 ★★★★★ — Shkëlqyeshëm</option>
                    <option value="4">4 ★★★★☆ — Shumë mirë</option>
                    <option value="3">3 ★★★☆☆ — Mirë</option>
                    <option value="2">2 ★★☆☆☆ — Mjaftueshëm</option>
                    <option value="1">1 ★☆☆☆☆ — Dobët</option>
                </select>
                <label class="form-lbl">Komenti <span style="color:#aaa;font-weight:400;">(opsionale)</span></label>
                <textarea name="komenti" class="form-ta" rows="3" placeholder="Shkruani mendimin tuaj..."></textarea>
                <button type="submit" class="btn-cherry" style="width:auto;padding:.5rem 1.5rem;"><i class="bi bi-send-fill"></i> Dërgo</button>
            </form>
        </div>
        @endauth
    </div>
</div>
@endsection
