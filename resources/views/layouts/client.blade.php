<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Biblioteka') — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --cherry: #C41E3A;
            --cherry-light: rgba(196,30,58,0.1);
            --pearl: #FDF8F5;
            --pearl-2: #F5F0EC;
            --sidebar-w: 210px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { background: var(--pearl); font-family: 'Nunito', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .cli-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: white; border-right: 1px solid #f0ebe8;
            display: flex; flex-direction: column;
            padding: 1.5rem 1rem;
            z-index: 1000;
        }
        .cli-brand {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0 0.25rem 1.25rem;
            border-bottom: 1px solid #f0ebe8;
            margin-bottom: 1.5rem;
            text-decoration: none; color: #1a0a0f;
        }
        .cli-brand-icon {
            width: 34px; height: 34px; background: var(--cherry);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.95rem;
        }
        .cli-brand span { font-weight: 800; font-size: 1rem; }

        .cli-avatar-wrap {
            display: flex; flex-direction: column; align-items: center;
            padding: 1rem 0 1.5rem;
            border-bottom: 1px solid #f0ebe8;
            margin-bottom: 1.25rem;
        }
        .cli-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--cherry);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.35rem; font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .cli-avatar-name { font-weight: 700; font-size: 0.9rem; color: #1a0a0f; }
        .cli-avatar-role { font-size: 0.72rem; color: #999; }

        .cli-nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.6rem 0.75rem; border-radius: 10px;
            color: #777; text-decoration: none; font-size: 0.875rem;
            transition: all 0.2s; margin-bottom: 0.1rem;
            background: none; border: none; width: 100%; cursor: pointer;
        }
        .cli-nav-link:hover { background: var(--cherry-light); color: var(--cherry); }
        .cli-nav-link.active { background: var(--cherry); color: white; }
        .cli-nav-link i { font-size: 0.95rem; width: 18px; text-align: center; }

        .cli-section-label {
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px;
            color: #bbb; padding: 0.75rem 0.75rem 0.25rem; font-weight: 700;
        }

        /* ── Main ── */
        .cli-main { margin-left: var(--sidebar-w); min-height: 100vh; }
        .cli-topbar {
            padding: 1rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            background: var(--pearl);
        }
        .cli-content { padding: 0 2rem 2rem; }

        /* ── Banner ── */
        .continue-banner {
            background: linear-gradient(135deg, #1C0A0E 0%, #3d1020 60%, #6b1530 100%);
            border-radius: 20px; padding: 2rem 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            color: white; margin-bottom: 2rem; overflow: hidden; position: relative;
        }
        .continue-banner::before {
            content: ''; position: absolute; right: -50px; top: -50px;
            width: 200px; height: 200px;
            background: rgba(196,30,58,0.25); border-radius: 50%;
        }
        .continue-banner::after {
            content: ''; position: absolute; right: 80px; bottom: -60px;
            width: 140px; height: 140px;
            background: rgba(255,255,255,0.05); border-radius: 50%;
        }
        .c-btn {
            background: white; color: var(--cherry); border: none;
            border-radius: 30px; padding: 0.45rem 1.25rem;
            font-size: 0.82rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 0.5rem;
            text-decoration: none; transition: transform 0.2s;
        }
        .c-btn:hover { transform: scale(1.04); color: var(--cherry); }
        .book-float {
            width: 80px; height: 110px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            box-shadow: 8px 8px 24px rgba(0,0,0,0.3);
        }

        /* ── Shared ── */
        .sec-title {
            font-weight: 700; font-size: 1rem; margin-bottom: 1rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .see-all { color: var(--cherry); font-size: 0.78rem; text-decoration: none; font-weight: 700; }
    </style>
    @yield('styles')
</head>
<body>
<div id="app" class="d-flex">
    <aside class="cli-sidebar">
        <a href="{{ url('/') }}" class="cli-brand">
            <div class="cli-brand-icon"><i class="bi bi-book-half"></i></div>
            <span>{{ config('app.name') }}</span>
        </a>

        <div class="cli-avatar-wrap">
            <div class="cli-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="cli-avatar-name">{{ Auth::user()->name }}</div>
            <div class="cli-avatar-role">Lexues</div>
        </div>

        <div class="cli-section-label">Biblioteka</div>
        <nav>
            <a href="{{ route('home') }}"
               class="cli-nav-link {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-book-half"></i> Biblioteka Ime
            </a>
            <a href="{{ route('wishlist.index') }}"
               class="cli-nav-link {{ request()->is('wishlist*') ? 'active' : '' }}">
                <i class="bi bi-heart-fill"></i> Lista Dëshirave
            </a>
            <a href="{{ route('reviews.index') }}"
               class="cli-nav-link {{ request()->is('reviews*') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i> Vlerësimet
            </a>
        </nav>
        <div class="cli-section-label">Porositë</div>
        <nav>
            <a href="{{ route('shipments.index') }}"
               class="cli-nav-link {{ request()->is('shipments*') ? 'active' : '' }}">
                <i class="bi bi-truck-front-fill"></i> Dërgesat
            </a>
            <a href="{{ route('payments.index') }}"
               class="cli-nav-link {{ request()->is('payments*') ? 'active' : '' }}">
                <i class="bi bi-credit-card-2-front-fill"></i> Pagesat
            </a>
            <a href="{{ route('coupons.index') }}"
               class="cli-nav-link {{ request()->is('coupons*') ? 'active' : '' }}">
                <i class="bi bi-tag-fill"></i> Kuponat
            </a>
            <a href="{{ route('addresses.index') }}"
               class="cli-nav-link {{ request()->is('addresses*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i> Adresat
            </a>
        </nav>

        <div class="mt-auto pt-2 border-top">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="cli-nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Dil
                </button>
            </form>
        </div>
    </aside>

    <div class="cli-main">
        <div class="cli-topbar">
            <div>
                <h5 class="fw-bold mb-0">@yield('page-title', 'Biblioteka Ime')</h5>
                <p class="text-muted mb-0" style="font-size:0.8rem;">@yield('page-sub', '')</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm border-0" style="background:#fff;border-radius:10px;width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-bell text-muted"></i>
                </button>
                <button class="btn btn-sm border-0" style="background:#fff;border-radius:10px;width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-gear text-muted"></i>
                </button>
            </div>
        </div>
        <main class="cli-content">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
