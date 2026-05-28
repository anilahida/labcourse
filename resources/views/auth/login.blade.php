<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hyr — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --cherry:#C41E3A; --cherry-dark:#9B1530; --pearl:#FDF8F5; }
        *, *::before, *::after { box-sizing:border-box; }
        html, body { height:100%; margin:0; font-family:'Nunito',sans-serif; }

        .auth-wrap {
            display:flex; min-height:100vh;
        }

        /* Left dark panel */
        .auth-left {
            flex:0 0 42%;
            background:linear-gradient(160deg,#1C0A0E 0%,#3d1020 55%,#6b1530 100%);
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:3rem 3rem;
            position:relative; overflow:hidden;
        }
        .auth-left::before {
            content:''; position:absolute; right:-80px; top:-80px;
            width:280px; height:280px;
            border:60px solid rgba(196,30,58,0.18); border-radius:50%;
        }
        .auth-left::after {
            content:''; position:absolute; left:-60px; bottom:-60px;
            width:220px; height:220px;
            border:50px solid rgba(255,255,255,0.04); border-radius:50%;
        }
        .auth-left-inner { position:relative; z-index:1; text-align:center; max-width:320px; }
        .auth-logo-box {
            width:56px; height:56px; background:var(--cherry); border-radius:18px;
            display:flex; align-items:center; justify-content:center;
            color:white; font-size:1.6rem; margin:0 auto 1.5rem;
        }
        .auth-app-name { color:white; font-weight:900; font-size:1.5rem; margin-bottom:0.5rem; }
        .auth-tagline { color:rgba(255,255,255,0.55); font-size:0.9rem; line-height:1.6; }

        .book-deco {
            display:flex; gap:1rem; justify-content:center; margin-top:2.5rem;
        }
        .book-deco span {
            font-size:2.8rem; display:block;
            animation:float 3s ease-in-out infinite;
        }
        .book-deco span:nth-child(2) { animation-delay:1s; }
        .book-deco span:nth-child(3) { animation-delay:2s; }
        @keyframes float {
            0%,100% { transform:translateY(0); }
            50% { transform:translateY(-8px); }
        }

        /* Right pearl panel */
        .auth-right {
            flex:1;
            background:var(--pearl);
            display:flex; align-items:center; justify-content:center;
            padding:2rem;
        }
        .auth-box { width:100%; max-width:400px; }
        .auth-title { font-weight:900; font-size:1.7rem; color:#1a0a0f; margin-bottom:0.4rem; }
        .auth-sub { color:#888; font-size:0.875rem; margin-bottom:2rem; }

        .form-lbl { font-size:0.8rem; font-weight:700; color:#555; margin-bottom:0.35rem; }
        .form-inp {
            width:100%; padding:0.65rem 1rem;
            border:1.5px solid #e8e4e1; border-radius:10px;
            font-size:0.9rem; font-family:'Nunito',sans-serif;
            outline:none; transition:border-color .2s, box-shadow .2s;
            background:white; color:#1a0a0f;
        }
        .form-inp:focus { border-color:var(--cherry); box-shadow:0 0 0 3px rgba(196,30,58,0.12); }
        .form-inp.is-invalid { border-color:#dc3545; }
        .invalid-feedback { font-size:0.75rem; color:#dc3545; margin-top:0.25rem; }

        .btn-auth {
            width:100%; padding:0.7rem; background:var(--cherry); color:white;
            border:none; border-radius:10px; font-size:0.95rem; font-weight:700;
            font-family:'Nunito',sans-serif; cursor:pointer; transition:background .2s;
        }
        .btn-auth:hover { background:var(--cherry-dark); }

        .divider { display:flex; align-items:center; gap:1rem; margin:1.5rem 0; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:#e8e4e1; }
        .divider span { color:#aaa; font-size:0.75rem; white-space:nowrap; }

        @media(max-width:767px) {
            .auth-left { display:none; }
        }
    </style>
</head>
<body>
<div id="app" class="auth-wrap">

    {{-- Left panel --}}
    <div class="auth-left">
        <div class="auth-left-inner">
            <div class="auth-logo-box"><i class="bi bi-book-half"></i></div>
            <h2 class="auth-app-name">{{ config('app.name','LibraryApp') }}</h2>
            <p class="auth-tagline">Zbulo botën e librave.<br>Lexo, eksplo, mëso çdo ditë.</p>
            <div class="book-deco">
                <span>📖</span><span>📚</span><span>📕</span>
            </div>
        </div>
    </div>

    {{-- Right panel --}}
    <div class="auth-right">
        <div class="auth-box">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none mb-4" style="color:#888;font-size:0.8rem;">
                <i class="bi bi-arrow-left"></i> Kthehu
            </a>

            <h2 class="auth-title">Mirë se vini!</h2>
            <p class="auth-sub">Hyr në llogarinë tënde për të vazhduar</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-lbl" for="email">Adresa Email</label>
                    <input id="email" type="email" name="email"
                           class="form-inp @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autocomplete="email" autofocus
                           placeholder="emri@shembull.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1">
                    <label class="form-lbl" for="password">Fjalëkalimi</label>
                    <input id="password" type="password" name="password"
                           class="form-inp @error('password') is-invalid @enderror"
                           required autocomplete="current-password"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                    <label class="d-flex align-items-center gap-2" style="cursor:pointer;font-size:0.82rem;color:#666;">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Mbaj mend
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:var(--cherry);font-size:0.82rem;font-weight:600;text-decoration:none;">
                        Harrove fjalëkalimin?
                    </a>
                    @endif
                </div>

                <button type="submit" class="btn-auth mb-3">Hyr</button>

                <div class="divider"><span>ose</span></div>

                <p class="text-center mb-0" style="font-size:0.85rem;color:#888;">
                    Nuk ke llogari?
                    <a href="{{ route('register') }}" style="color:var(--cherry);font-weight:700;text-decoration:none;">
                        Regjistrohu falas
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
