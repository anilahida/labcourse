<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LibraryApp') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --cherry: #C41E3A; --cherry-dark: #9B1530; --pearl: #FDF8F5; }
        * { box-sizing: border-box; }
        body { font-family: 'Nunito', sans-serif; margin: 0; background: var(--pearl); }

        /* NAV */
        .top-nav { background: white; border-bottom: 1px solid #eee; padding: 0.9rem 0; position: sticky; top: 0; z-index: 999; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .brand { font-weight: 900; font-size: 1.25rem; color: var(--cherry); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .brand:hover { color: var(--cherry-dark); }
        .nav-a { color: #444; text-decoration: none; font-weight: 600; font-size: 0.9rem; padding: 0 12px; }
        .nav-a:hover { color: var(--cherry); }
        .btn-r { background: var(--cherry); color: white !important; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 700; font-size: 0.875rem; text-decoration: none; cursor: pointer; display: inline-block; }
        .btn-r:hover { background: var(--cherry-dark); }
        .btn-o { background: transparent; color: #555; border: 1.5px solid #ddd; border-radius: 8px; padding: 7px 18px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; }
        .btn-o:hover { border-color: var(--cherry); color: var(--cherry); }

        /* HERO */
        .hero { background: linear-gradient(135deg, #1C0A0E 0%, #3d1020 50%, #6b1530 100%); padding: 80px 0 60px; overflow: hidden; }
        .hero h1 { font-size: 3rem; font-weight: 900; color: white; line-height: 1.1; margin-bottom: 1.25rem; }
        .hero h1 span { color: #f87096; }
        .hero p { color: rgba(255,255,255,0.65); font-size: 1rem; line-height: 1.7; margin-bottom: 2rem; }

        /* CSS Book Cards */
        .book-stack { display: flex; align-items: flex-end; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .bk {
            border-radius: 6px 14px 14px 6px;
            display: flex; flex-direction: column; align-items: center; justify-content: flex-end;
            padding: 14px 10px; color: white; font-weight: 800; text-align: center;
            cursor: pointer; transition: transform 0.3s; position: relative; overflow: hidden;
            box-shadow: -4px 8px 24px rgba(0,0,0,0.45);
        }
        .bk::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 8px; background: rgba(0,0,0,0.2); border-radius: 6px 0 0 6px; }
        .bk:hover { transform: translateY(-12px) rotate(-2deg); }
        .bk-1 { width: 110px; height: 165px; background: linear-gradient(160deg, #e63946, #c1121f); }
        .bk-2 { width: 120px; height: 185px; background: linear-gradient(160deg, #023e8a, #0096c7); transform: rotate(3deg); }
        .bk-3 { width: 108px; height: 158px; background: linear-gradient(160deg, #2d6a4f, #52b788); transform: rotate(-3deg); }
        .bk-4 { width: 115px; height: 172px; background: linear-gradient(160deg, #7b2d8b, #c77dff); }
        .bk i { font-size: 2.2rem; margin-bottom: 8px; opacity: 0.9; display: block; }
        .bk-t { font-size: 0.65rem; line-height: 1.4; }

        /* STATS */
        .stats-bar { background: white; padding: 2.5rem 0; border-bottom: 1px solid #f0ebe8; }
        .stat-n { font-size: 2rem; font-weight: 900; color: #1a0a0f; }
        .stat-l { color: #888; font-size: 0.85rem; font-weight: 600; }

        /* BOOK GRID */
        .sec-tag { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; color: var(--cherry); font-weight: 800; }
        .sec-h { font-size: 1.6rem; font-weight: 900; color: #1a0a0f; }
        .book-card { background: white; border-radius: 16px; overflow: hidden; transition: transform 0.25s, box-shadow 0.25s; box-shadow: 0 2px 10px rgba(0,0,0,0.07); cursor: pointer; }
        .book-card:hover { transform: translateY(-6px); box-shadow: 0 16px 32px rgba(0,0,0,0.14); }
        .book-cover { height: 175px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; font-weight: 800; text-align: center; padding: 16px; }
        .book-cover i { font-size: 2.5rem; margin-bottom: 8px; opacity: 0.95; }
        .book-cover-t { font-size: 0.72rem; line-height: 1.4; }
        .book-info { padding: 14px; }
        .b-title { font-weight: 700; font-size: 0.83rem; color: #1a0a0f; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .b-author { font-size: 0.72rem; color: #999; margin-bottom: 8px; }
        .b-stars { color: #f59e0b; font-size: 0.72rem; }
        .b-price { color: var(--cherry); font-weight: 800; font-size: 0.88rem; }
        .add-btn { background: #fff0f2; color: var(--cherry); border: none; border-radius: 8px; padding: 6px 0; font-size: 0.72rem; font-weight: 700; cursor: pointer; transition: all 0.2s; width: 100%; margin-top: 8px; font-family: 'Nunito', sans-serif; }
        .add-btn:hover { background: var(--cherry); color: white; }

        /* CATEGORIES */
        .cat-card { background: var(--pearl); border-radius: 16px; padding: 28px 16px; text-align: center; transition: all 0.25s; cursor: pointer; text-decoration: none; border: 2px solid transparent; display: block; }
        .cat-card:hover { border-color: var(--cherry); background: white; transform: translateY(-4px); box-shadow: 0 12px 28px rgba(196,30,58,0.12); }

        /* CTA */
        .cta-sec { background: linear-gradient(135deg, #1C0A0E 0%, #3d1020 60%, #6b1530 100%); padding: 80px 0; text-align: center; }

        footer { background: white; border-top: 1px solid #f0ebe8; padding: 20px 0; text-align: center; }
    </style>
</head>
<body>
<div id="app">

{{-- NAVBAR --}}
<nav class="top-nav">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="brand">
                <i class="bi bi-book-half"></i>
                {{ config('app.name', 'LibraryApp') }}
            </a>
            <div class="d-none d-md-flex align-items-center">
                <a href="{{ url('/') }}" class="nav-a">Kryefaqja</a>
                <a href="#books" class="nav-a">Librat</a>
                <a href="#categories" class="nav-a">Kategoritë</a>
                <a href="#" class="nav-a">Wishlist</a>
            </div>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ url('/home') }}" class="btn-r">
                        <i class="bi bi-speedometer2 me-1"></i>Paneli im
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-o">Hyr</a>
                    @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-r">Regjistrohu</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <p style="color:rgba(255,255,255,0.45);font-size:0.72rem;text-transform:uppercase;letter-spacing:2px;font-weight:700;margin-bottom:14px;">Biblioteka Digjitale</p>
                <h1>Gjej Librin<br>Tënd <span>të Ardhshëm</span></h1>
                <p>Zbulo botën e librave — nga letërsia klasike deri tek teknologjia moderne. Çdo faqe sjell një aventurë të re.</p>
                <div class="d-flex gap-3 flex-wrap">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-light btn-lg fw-bold px-4" style="border-radius:10px;color:var(--cherry);">
                            Hyr te Paneli <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold px-4" style="border-radius:10px;color:var(--cherry);">
                            Fillo Tani <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4" style="border-radius:10px;">Hyr</a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-7 d-flex justify-content-center">
                <div class="book-stack">
                    <div class="bk bk-1">
                        <i class="bi bi-journal-richtext"></i>
                        <div class="bk-t">Letërsia<br>Shqipe</div>
                    </div>
                    <div class="bk bk-2">
                        <i class="bi bi-globe2"></i>
                        <div class="bk-t">Historia<br>Botërore</div>
                    </div>
                    <div class="bk bk-3">
                        <i class="bi bi-lightbulb-fill"></i>
                        <div class="bk-t">Filozofia</div>
                    </div>
                    <div class="bk bk-4">
                        <i class="bi bi-cpu-fill"></i>
                        <div class="bk-t">Teknologjia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="stats-bar">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3"><div class="stat-n">10,000+</div><div class="stat-l">Tituj Librash</div></div>
            <div class="col-6 col-md-3"><div class="stat-n">5,200+</div><div class="stat-l">Anëtarë Aktivë</div></div>
            <div class="col-6 col-md-3"><div class="stat-n">98%</div><div class="stat-l">Klientë të Kënaqur</div></div>
            <div class="col-6 col-md-3"><div class="stat-n">24/7</div><div class="stat-l">Akses Online</div></div>
        </div>
    </div>
</section>

{{-- BOOKS GRID --}}
<section id="books" style="padding:60px 0;">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-4">
            <div>
                <p class="sec-tag mb-1">Koleksioni</p>
                <h2 class="sec-h mb-0">Rekomanduar për Ju</h2>
            </div>
            <a href="#" style="color:var(--cherry);font-weight:700;font-size:0.875rem;text-decoration:none;">Shiko të gjitha <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-3">
            @foreach([
                ['linear-gradient(160deg,#e63946,#c1121f)','bi-journal-richtext','Inteligjenca Emocionale','Daniel Goleman','4.9','18'],
                ['linear-gradient(160deg,#023e8a,#0096c7)','bi-cpu-fill','Atomic Habits','James Clear','5.0','22'],
                ['linear-gradient(160deg,#2d6a4f,#52b788)','bi-globe2','Sapiens','Yuval N. Harari','4.8','20'],
                ['linear-gradient(160deg,#7b2d8b,#c77dff)','bi-lightbulb-fill','Psikologjia e Parasë','Morgan Housel','4.9','16'],
                ['linear-gradient(160deg,#b45309,#f59e0b)','bi-star-fill','Gjenerali i Ushtrisë','Ismail Kadare','4.7','14'],
                ['linear-gradient(160deg,#c1121f,#e63946)','bi-heart-fill','The Alchemist','Paulo Coelho','4.8','12'],
            ] as $b)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="book-card">
                    <div class="book-cover" style="background:{{ $b[0] }};">
                        <i class="bi {{ $b[1] }}"></i>
                        <div class="book-cover-t">{{ $b[2] }}</div>
                    </div>
                    <div class="book-info">
                        <div class="b-title">{{ $b[2] }}</div>
                        <div class="b-author">{{ $b[3] }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="b-stars">★ {{ $b[4] }}</span>
                            <span class="b-price">€{{ $b[5] }}</span>
                        </div>
                        <button class="add-btn">Shto në shportë</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section id="categories" style="padding:60px 0;background:white;">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-4">
            <div>
                <p class="sec-tag mb-1">Shfleto</p>
                <h2 class="sec-h mb-0">Kategoritë</h2>
            </div>
        </div>
        <div class="row g-3">
            @foreach([
                ['bi-journal-richtext','Letërsi','1,240 libra'],
                ['bi-globe2','Histori','890 libra'],
                ['bi-flask','Shkencë','650 libra'],
                ['bi-cpu-fill','Teknologji','480 libra'],
                ['bi-palette-fill','Arte','320 libra'],
                ['bi-lightbulb-fill','Filozofi','410 libra'],
                ['bi-heart-pulse-fill','Psikologji','560 libra'],
                ['bi-music-note-beamed','Poezi','280 libra'],
            ] as $c)
            <div class="col-6 col-md-3">
                <a href="#" class="cat-card">
                    <i class="bi {{ $c[0] }}" style="font-size:2rem;color:var(--cherry);display:block;margin-bottom:10px;"></i>
                    <div style="font-weight:700;font-size:0.9rem;color:#1a0a0f;">{{ $c[1] }}</div>
                    <div style="font-size:0.75rem;color:#aaa;margin-top:2px;">{{ $c[2] }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-sec">
    <div class="container">
        <h2 class="fw-bold text-white mb-3" style="font-size:2rem;">Gati për të Eksploruar?</h2>
        <p style="color:rgba(255,255,255,0.6);font-size:1rem;" class="mb-4">Bashkohu me mijëra lexues dhe zbulo botën e librave.</p>
        @guest
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-bold" style="border-radius:10px;color:var(--cherry);">
            Regjistrohu Falas
        </a>
        @endguest
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <p class="text-muted mb-0" style="font-size:0.82rem;">&copy; {{ date('Y') }} {{ config('app.name','LibraryApp') }}. Të gjitha të drejtat e rezervuara.</p>
</footer>

</div>
</body>
</html>
