<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --cherry: #C41E3A;
            --cherry-hover: rgba(196,30,58,0.15);
            --pearl: #FDF8F5;
            --sidebar-w: 72px;
            --sidebar-bg: #16181D;
            --bg: #F2F4F8;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { background: var(--bg); font-family: 'Nunito', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .adm-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            align-items: center;
            padding: 1.25rem 0.6rem;
            z-index: 1000;
        }
        .adm-logo {
            width: 42px; height: 42px;
            background: var(--cherry); border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.2rem;
            text-decoration: none; flex-shrink: 0;
            margin-bottom: 2rem;
        }
        .adm-nav {
            display: flex; flex-direction: column;
            gap: 0.25rem; flex: 1; width: 100%;
        }
        .adm-nav-item {
            width: 100%; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4); font-size: 1.15rem;
            text-decoration: none; transition: background 0.2s, color 0.2s;
            position: relative; border: none; background: none; cursor: pointer;
        }
        .adm-nav-item:hover { background: var(--cherry-hover); color: var(--cherry); }
        .adm-nav-item.active { background: var(--cherry); color: white; }
        .adm-nav-item::after {
            content: attr(data-tip);
            position: absolute; left: calc(100% + 14px); top: 50%;
            transform: translateY(-50%);
            background: #222; color: #fff; font-size: 0.72rem;
            font-family: 'Nunito', sans-serif;
            padding: 5px 10px; border-radius: 8px;
            white-space: nowrap; opacity: 0; pointer-events: none;
            transition: opacity 0.15s; z-index: 9999;
        }
        .adm-nav-item:hover::after { opacity: 1; }
        .adm-logout {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4); font-size: 1.15rem;
            background: none; border: none; cursor: pointer;
            transition: background 0.2s, color 0.2s; position: relative;
        }
        .adm-logout:hover { background: rgba(239,68,68,0.15); color: #ef4444; }
        .adm-logout::after {
            content: 'Dil'; position: absolute; left: calc(100% + 14px); top: 50%;
            transform: translateY(-50%); background: #222; color: #fff;
            font-size: 0.72rem; padding: 5px 10px; border-radius: 8px;
            white-space: nowrap; opacity: 0; pointer-events: none;
            transition: opacity 0.15s; z-index: 9999;
        }
        .adm-logout:hover::after { opacity: 1; }

        /* ── Main ── */
        .adm-main { margin-left: var(--sidebar-w); }
        .adm-topbar {
            height: 64px; background: white;
            border-bottom: 1px solid #e8eaef;
            display: flex; align-items: center;
            padding: 0 1.75rem; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .srch {
            background: var(--bg); border: none; border-radius: 10px;
            padding: 0.45rem 1rem 0.45rem 2.25rem;
            font-size: 0.85rem; font-family: 'Nunito', sans-serif;
            width: 240px; outline: none;
        }
        .srch:focus { box-shadow: 0 0 0 2px rgba(196,30,58,0.25); }
        .adm-content { padding: 1.75rem 2rem; }

        /* ── Cards ── */
        .s-card {
            background: white; border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            border: 1px solid #eef0f5;
        }
        .bdg-up { background:#dcfce7; color:#16a34a; padding:3px 9px; border-radius:20px; font-size:0.7rem; font-weight:700; }
        .bdg-dn { background:#fee2e2; color:#dc2626; padding:3px 9px; border-radius:20px; font-size:0.7rem; font-weight:700; }
    </style>
    @yield('styles')
</head>
<body>
<div id="app">
    <aside class="adm-sidebar">
        <a href="{{ url('/home') }}" class="adm-logo" data-tip="{{ config('app.name') }}">
            <i class="bi bi-book-half"></i>
        </a>
        <nav class="adm-nav">
            <a href="{{ route('home') }}"
               class="adm-nav-item {{ request()->is('home') ? 'active' : '' }}"
               data-tip="Dashboard">
                <i class="bi bi-grid-1x2-fill"></i>
            </a>
            <a href="{{ route('admin.coupons') }}"
               class="adm-nav-item {{ request()->is('admin/coupons*') ? 'active' : '' }}"
               data-tip="Kuponat">
                <i class="bi bi-tag-fill"></i>
            </a>
            <a href="{{ route('admin.payments') }}"
               class="adm-nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}"
               data-tip="Pagesat">
                <i class="bi bi-credit-card-2-front-fill"></i>
            </a>
            <a href="{{ route('admin.reviews') }}"
               class="adm-nav-item {{ request()->is('admin/reviews*') ? 'active' : '' }}"
               data-tip="Vlerësimet">
                <i class="bi bi-star-fill"></i>
            </a>
            <a href="{{ route('admin.shipments') }}"
               class="adm-nav-item {{ request()->is('admin/shipments*') ? 'active' : '' }}"
               data-tip="Dërgesat">
                <i class="bi bi-truck-front-fill"></i>
            </a>
            <a href="{{ route('books.index') }}"
               class="adm-nav-item {{ request()->is('books*') ? 'active' : '' }}"
               data-tip="Librat">
                <i class="bi bi-book-fill"></i>
            </a>
            <a href="{{ route('authors.index') }}"
               class="adm-nav-item {{ request()->is('authors*') ? 'active' : '' }}"
               data-tip="Autorët">
                <i class="bi bi-person-lines-fill"></i>
            </a>
            <a href="{{ route('categories.index') }}"
               class="adm-nav-item {{ request()->is('categories*') ? 'active' : '' }}"
               data-tip="Kategoritë">
                <i class="bi bi-grid-fill"></i>
            </a>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="adm-logout" data-tip="Dil">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </aside>

    <div class="adm-main">
        <header class="adm-topbar">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted"
                   style="left:10px;top:50%;transform:translateY(-50%);font-size:0.82rem;"></i>
                <input type="text" class="srch" placeholder="Kërko...">
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="font-size:0.78rem;color:#aaa;">{{ now()->format('d M Y') }}</span>
                <button style="background:var(--bg);border:none;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                    <i class="bi bi-bell" style="font-size:0.9rem;color:#888;"></i>
                </button>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:36px;height:36px;border-radius:50%;background:var(--cherry);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:0.85rem;flex-shrink:0;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:0.83rem;line-height:1.2;color:#16181D;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.7rem;color:#aaa;">Administrator</div>
                    </div>
                </div>
            </div>
        </header>
        <main class="adm-content">
            @yield('content')
        </main>
    </div>
</div>
@yield('scripts')
</body>
</html>
