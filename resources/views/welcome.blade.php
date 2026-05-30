<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Libraria Ime') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --cherry: #C41E3A; --cherry-d: #9B1530; --pearl: #FDF8F5; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Nunito', sans-serif; background: var(--pearl); color: #1a0a0f; }
        a { text-decoration: none; }

        /* ── NAVBAR ── */
        .nav-wrap {
            background: #fff;
            border-bottom: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            position: sticky; top: 0; z-index: 999;
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px;
        }
        .nav-brand {
            font-weight: 900; font-size: 1.2rem; color: var(--cherry);
            display: flex; align-items: center; gap: 8px;
            white-space: nowrap;
        }
        .nav-brand:hover { color: var(--cherry-d); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a {
            color: #555; font-weight: 600; font-size: .88rem;
            padding: 6px 14px; border-radius: 8px;
            transition: color .2s, background .2s;
        }
        .nav-links a:hover { color: var(--cherry); background: #fff0f2; }
        .nav-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .btn-outline {
            border: 1.5px solid #ddd; background: none; color: #555;
            border-radius: 8px; padding: 7px 18px; font-weight: 700;
            font-size: .85rem; transition: all .2s;
        }
        .btn-outline:hover { border-color: var(--cherry); color: var(--cherry); }
        .btn-solid {
            background: var(--cherry); color: #fff !important; border: none;
            border-radius: 8px; padding: 8px 20px; font-weight: 700;
            font-size: .85rem; transition: background .2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-solid:hover { background: var(--cherry-d); }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(130deg,#1C0A0E 0%,#3d1020 50%,#6b1530 100%);
            padding: 80px 0 70px;
        }
        .hero-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 40px;
        }
        .hero-text { flex: 0 0 45%; }
        .hero-label {
            color: rgba(255,255,255,.45); font-size: .7rem;
            text-transform: uppercase; letter-spacing: 3px;
            font-weight: 700; margin-bottom: 16px;
        }
        .hero-title { font-size: 3.2rem; font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 20px; }
        .hero-title span { color: #f87096; }
        .hero-desc { color: rgba(255,255,255,.65); font-size: 1rem; line-height: 1.75; margin-bottom: 32px; }
        .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }
        .btn-hero-main {
            background: #fff; color: var(--cherry) !important; border: none;
            border-radius: 10px; padding: 12px 28px; font-weight: 800;
            font-size: .95rem; transition: transform .2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-hero-main:hover { transform: translateY(-2px); }
        .btn-hero-sec {
            background: transparent; color: rgba(255,255,255,.85) !important;
            border: 1.5px solid rgba(255,255,255,.4); border-radius: 10px;
            padding: 12px 28px; font-weight: 700; font-size: .95rem;
            transition: all .2s;
        }
        .btn-hero-sec:hover { border-color: #fff; color: #fff !important; }

        /* Book spine cards */
        .book-shelf { display: flex; align-items: flex-end; gap: 18px; justify-content: center; flex: 1; }
        .spine {
            border-radius: 4px 14px 14px 4px;
            display: flex; flex-direction: column; align-items: center; justify-content: flex-end;
            padding: 16px 12px; color: #fff; font-weight: 700; text-align: center;
            box-shadow: -4px 8px 28px rgba(0,0,0,.5);
            transition: transform .35s ease; position: relative; overflow: hidden;
        }
        .spine::before { content:''; position:absolute; left:0; top:0; bottom:0; width:7px; background:rgba(0,0,0,.25); }
        .spine:hover { transform: translateY(-14px) rotate(-2deg); }
        .spine i { font-size: 2rem; margin-bottom: 10px; display: block; }
        .spine-t { font-size: .62rem; line-height: 1.5; }
        .s1 { width:110px; height:168px; background:linear-gradient(160deg,#e63946,#c1121f); }
        .s2 { width:122px; height:190px; background:linear-gradient(160deg,#023e8a,#0096c7); transform:rotate(4deg); }
        .s3 { width:106px; height:160px; background:linear-gradient(160deg,#1b6b3a,#52b788); transform:rotate(-4deg); }
        .s4 { width:116px; height:175px; background:linear-gradient(160deg,#6d28d9,#a78bfa); }

        /* ── STATS ── */
        .stats-wrap { background:#fff; border-bottom:1px solid #f0ebe8; padding:40px 0; }
        .stats-inner {
            max-width:1200px; margin:0 auto; padding:0 24px;
            display:grid; grid-template-columns:repeat(4,1fr);
            text-align:center;
        }
        .stats-inner > div { border-right:1px solid #f0ebe8; padding:0 20px; }
        .stats-inner > div:last-child { border-right:none; }
        .sn { font-size:2.2rem; font-weight:900; color:var(--cherry); line-height:1; }
        .sl { font-size:.85rem; color:#888; font-weight:600; margin-top:4px; }

        /* ── BOOKS ── */
        .section { padding:60px 0; }
        .section-white { padding:60px 0; background:#fff; }
        .sec-head {
            max-width:1200px; margin:0 auto 28px; padding:0 24px;
            display:flex; align-items:flex-end; justify-content:space-between;
        }
        .sec-tag { font-size:.68rem; text-transform:uppercase; letter-spacing:2px; color:var(--cherry); font-weight:800; display:block; margin-bottom:4px; }
        .sec-h { font-size:1.5rem; font-weight:900; }
        .see-all { color:var(--cherry); font-size:.85rem; font-weight:700; }
        .see-all:hover { color:var(--cherry-d); }

        .books-grid {
            max-width:1200px; margin:0 auto; padding:0 24px;
            display:grid; grid-template-columns:repeat(6,1fr); gap:16px;
        }
        .bc { background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.07); transition:transform .25s,box-shadow .25s; display:flex; flex-direction:column; }
        .bc:hover { transform:translateY(-6px); box-shadow:0 14px 30px rgba(0,0,0,.13); }
        .bc-cover { height:160px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; text-align:center; padding:12px; }
        .bc-cover i { font-size:2.2rem; margin-bottom:6px; display:block; }
        .bc-cover-t { font-size:.65rem; font-weight:700; line-height:1.4; }
        .bc-body { padding:12px; flex:1; display:flex; flex-direction:column; }
        .bc-title { font-weight:700; font-size:.78rem; color:#1a0a0f; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .bc-auth { font-size:.68rem; color:#aaa; margin-bottom:6px; }
        .bc-foot { display:flex; justify-content:space-between; align-items:center; }
        .bc-stars { color:#f59e0b; font-size:.7rem; }
        .bc-price { color:var(--cherry); font-weight:800; font-size:.85rem; }
        .bc-actions { display:flex; gap:6px; margin-top:8px; }
        .bc-btn {
            flex:1; background:#fff0f2; color:var(--cherry); border:none;
            border-radius:7px; padding:7px 0; font-size:.72rem; font-weight:700;
            cursor:pointer; font-family:'Nunito',sans-serif; transition:all .2s;
            text-align:center; text-decoration:none;
            display:flex; align-items:center; justify-content:center; gap:4px;
        }
        .bc-btn:hover { background:var(--cherry); color:#fff; }
        .bc-btn-wish {
            width:32px; flex-shrink:0; background:#f5f0ec; color:#aaa;
            border:none; border-radius:7px; font-size:.8rem; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; text-decoration:none;
        }
        .bc-btn-wish:hover { background:#fff0f2; color:var(--cherry); }

        /* ── CATEGORIES ── */
        .cats-grid {
            max-width:1200px; margin:0 auto; padding:0 24px;
            display:grid; grid-template-columns:repeat(4,1fr); gap:14px;
        }
        .cat {
            background:var(--pearl); border:2px solid transparent;
            border-radius:14px; padding:28px 16px; text-align:center;
            transition:all .25s; display:flex; flex-direction:column;
            align-items:center; aspect-ratio:1/.8; justify-content:center;
            text-decoration:none; color:inherit;
        }
        .cat:hover { border-color:var(--cherry); background:#fff; transform:translateY(-4px); box-shadow:0 10px 24px rgba(196,30,58,.12); }
        .cat i { font-size:1.8rem; color:var(--cherry); margin-bottom:10px; }
        .cat-name { font-weight:700; font-size:.88rem; color:#1a0a0f; }
        .cat-n { font-size:.72rem; color:#aaa; margin-top:3px; }

        /* ── CTA ── */
        .cta { background:linear-gradient(130deg,#1C0A0E 0%,#3d1020 60%,#6b1530 100%); padding:80px 24px; text-align:center; }
        .cta h2 { font-size:2.2rem; font-weight:900; color:#fff; margin-bottom:12px; }
        .cta p { color:rgba(255,255,255,.6); font-size:1rem; margin-bottom:32px; }

        footer { background:#fff; border-top:1px solid #f0ebe8; padding:20px 24px; text-align:center; }

        /* ── RESPONSIVE ── */
        @media(max-width:900px) {
            .books-grid { grid-template-columns:repeat(3,1fr); }
            .cats-grid { grid-template-columns:repeat(2,1fr); }
            .stats-inner { grid-template-columns:repeat(2,1fr); gap:20px 0; }
        }
        @media(max-width:768px) {
            .hero-inner { flex-direction:column; }
            .hero-title { font-size:2.2rem; }
            .book-shelf { display:none; }
            .nav-links { display:none; }
            .books-grid { grid-template-columns:repeat(2,1fr); }
        }
    </style>
</head>
<body>
<div id="app">

{{-- NAVBAR --}}
<nav class="nav-wrap">
    <div class="nav-inner">
        <a href="{{ url('/') }}" class="nav-brand">
            <i class="bi bi-book-half"></i>
            {{ config('app.name', 'Libraria Ime') }}
        </a>

        <div class="nav-links">
            <a href="{{ url('/') }}">Kryefaqja</a>
            <a href="#books">Librat</a>
            <a href="#categories">Kategoritë</a>
            @auth
                <a href="{{ route('wishlist.index') }}">Wishlist</a>
            @else
                <a href="{{ route('login') }}">Wishlist</a>
            @endauth
        </div>

        <div class="nav-actions">
            @auth
                <a href="{{ url('/home') }}" class="btn-solid">
                    <i class="bi bi-speedometer2"></i> Paneli im
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Hyr</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-solid">Regjistrohu</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-text">
            <p class="hero-label">Biblioteka Digjitale</p>
            <h1 class="hero-title">Gjej Librin<br>Tënd <span>të Ardhshëm</span></h1>
            <p class="hero-desc">Zbulo botën e librave — nga letërsia klasike deri tek teknologjia moderne. Çdo faqe sjell një aventurë të re.</p>
            <div class="hero-btns">
                @auth
                    <a href="{{ route('books.browse') }}" class="btn-hero-main">Shfleto Librat <i class="bi bi-arrow-right"></i></a>
                    <a href="{{ url('/home') }}" class="btn-hero-sec">Paneli im</a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero-main">Fillo Tani <i class="bi bi-arrow-right"></i></a>
                    <a href="{{ route('login') }}" class="btn-hero-sec">Hyr</a>
                @endauth
            </div>
        </div>
        <div class="book-shelf">
            <div class="spine s1"><i class="bi bi-journal-richtext"></i><div class="spine-t">Letërsia<br>Shqipe</div></div>
            <div class="spine s2"><i class="bi bi-globe2"></i><div class="spine-t">Historia<br>Botërore</div></div>
            <div class="spine s3"><i class="bi bi-lightbulb-fill"></i><div class="spine-t">Filozofia</div></div>
            <div class="spine s4"><i class="bi bi-cpu-fill"></i><div class="spine-t">Teknologjia</div></div>
        </div>
    </div>
</section>

{{-- STATS --}}
<div class="stats-wrap">
    <div class="stats-inner">
        <div><div class="sn">{{ \App\Models\Book::count() }}+</div><div class="sl">Tituj Librash</div></div>
        <div><div class="sn">{{ \App\Models\User::count() }}+</div><div class="sl">Anëtarë Aktivë</div></div>
        <div><div class="sn">{{ \App\Models\Review::count() }}+</div><div class="sl">Vlerësime</div></div>
        <div><div class="sn">24/7</div><div class="sl">Akses Online</div></div>
    </div>
</div>

{{-- BOOKS --}}
@php
$coverColors = [
    ['linear-gradient(160deg,#e63946,#c1121f)','bi-journal-richtext'],
    ['linear-gradient(160deg,#023e8a,#0096c7)','bi-cpu-fill'],
    ['linear-gradient(160deg,#1b6b3a,#52b788)','bi-globe2'],
    ['linear-gradient(160deg,#6d28d9,#a78bfa)','bi-lightbulb-fill'],
    ['linear-gradient(160deg,#b45309,#f59e0b)','bi-star-fill'],
    ['linear-gradient(160deg,#c1121f,#e63946)','bi-heart-fill'],
];
@endphp

<section class="section" id="books">
    <div class="sec-head">
        <div>
            <span class="sec-tag">Koleksioni</span>
            <h2 class="sec-h">Rekomanduar për Ju</h2>
        </div>
        @auth
            <a href="{{ route('books.browse') }}" class="see-all">Shiko të gjitha <i class="bi bi-arrow-right"></i></a>
        @else
            <a href="{{ route('login') }}" class="see-all">Shiko të gjitha <i class="bi bi-arrow-right"></i></a>
        @endauth
    </div>

    <div class="books-grid">
        @forelse($featuredBooks as $i => $book)
        @php $clr = $coverColors[$i % count($coverColors)]; @endphp
        <div class="bc">
            <a href="{{ route('books.show', $book->id) }}" style="text-decoration:none;">
                <div class="bc-cover" style="background:{{ $clr[0] }};">
                    <i class="bi {{ $clr[1] }}"></i>
                    <div class="bc-cover-t">{{ $book->titulli }}</div>
                </div>
            </a>
            <div class="bc-body">
                <div class="bc-title">{{ $book->titulli }}</div>
                <div class="bc-auth">{{ $book->author->emri ?? '' }} {{ $book->author->mbiemri ?? '' }}</div>
                <div class="bc-foot">
                    @if($book->reviews_avg_nota)
                        <span class="bc-stars">★ {{ number_format($book->reviews_avg_nota,1) }}</span>
                    @else
                        <span class="bc-stars" style="color:#ccc;">★ —</span>
                    @endif
                    <span class="bc-price">€{{ number_format($book->cmimi,0) }}</span>
                </div>
                <div class="bc-actions">
                    @auth
                        @if(!Auth::user()->is_admin)
                            <a href="{{ route('books.show', $book->id) }}" class="bc-btn">
                                <i class="bi bi-bag-fill"></i> Shto në shportë
                            </a>
                            <form action="{{ route('wishlist.store') }}" method="POST" style="display:contents;">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="bc-btn-wish" title="Shto në wishlist">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('books.index') }}" class="bc-btn">
                                <i class="bi bi-pencil-fill"></i> Menaxho
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bc-btn">
                            <i class="bi bi-bag-fill"></i> Shto në shportë
                        </a>
                        <a href="{{ route('login') }}" class="bc-btn-wish" title="Hyr për wishlist">
                            <i class="bi bi-heart"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#aaa;">
            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
            Nuk ka libra aktualisht.
        </div>
        @endforelse
    </div>
</section>

{{-- CATEGORIES --}}
@php
$catIcons = ['Letërsi'=>'bi-journal-richtext','Histori'=>'bi-globe2','Shkencë'=>'bi-flask','Teknologji'=>'bi-cpu-fill','Arte'=>'bi-palette-fill','Filozofi'=>'bi-lightbulb-fill','Psikologji'=>'bi-heart-pulse-fill','Poezi'=>'bi-music-note-beamed','Biznes'=>'bi-briefcase-fill','Tregim'=>'bi-book-fill','Roman'=>'bi-book-half','Fëmijë & Rini'=>'bi-balloon-heart-fill'];
@endphp

<section class="section-white" id="categories">
    <div class="sec-head">
        <div>
            <span class="sec-tag">Shfleto</span>
            <h2 class="sec-h">Kategoritë</h2>
        </div>
    </div>
    <div class="cats-grid">
        @forelse($categories as $cat)
        @php $icon = $catIcons[$cat->emri] ?? 'bi-book-half'; @endphp
        <a href="{{ auth()->check() ? route('books.browse') : route('login') }}" class="cat">
            <i class="bi {{ $icon }}"></i>
            <div class="cat-name">{{ $cat->emri }}</div>
            <div class="cat-n">{{ $cat->books_count }} libra</div>
        </a>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#aaa;">Nuk ka kategori.</div>
        @endforelse
    </div>
</section>

{{-- CTA --}}
<div class="cta">
    <h2>Gati për të Eksploruar?</h2>
    <p>Bashkohu me lexuesit dhe zbulo botën e librave.</p>
    @guest
        <a href="{{ route('register') }}" class="btn-hero-main" style="display:inline-flex;">
            Regjistrohu Falas <i class="bi bi-arrow-right"></i>
        </a>
    @else
        <a href="{{ route('books.browse') }}" class="btn-hero-main" style="display:inline-flex;">
            Shfleto Librat <i class="bi bi-arrow-right"></i>
        </a>
    @endguest
</div>

{{-- FOOTER --}}
<footer>
    <span style="color:#aaa;font-size:.8rem;">&copy; {{ date('Y') }} {{ config('app.name','Libraria Ime') }}. Të gjitha të drejtat e rezervuara.</span>
</footer>

</div>
</body>
</html>
