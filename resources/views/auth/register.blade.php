<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Regjistrohu — {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root { --cherry:#C41E3A; --cherry-dark:#9B1530; --pearl:#FDF8F5; }
        *, *::before, *::after { box-sizing:border-box; }
        html, body { height:100%; margin:0; font-family:'Nunito',sans-serif; }

        .auth-wrap { display:flex; min-height:100vh; }

        .auth-left {
            flex:0 0 40%;
            background:linear-gradient(160deg,#1C0A0E 0%,#3d1020 55%,#6b1530 100%);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:3rem; position:relative; overflow:hidden;
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
        .auth-left-inner { position:relative; z-index:1; text-align:center; max-width:300px; }
        .auth-logo-box {
            width:56px; height:56px; background:var(--cherry); border-radius:18px;
            display:flex; align-items:center; justify-content:center;
            color:white; font-size:1.6rem; margin:0 auto 1.5rem;
        }
        .auth-app-name { color:white; font-weight:900; font-size:1.5rem; margin-bottom:0.5rem; }
        .auth-tagline { color:rgba(255,255,255,0.55); font-size:0.9rem; line-height:1.6; }

        .feature-list { list-style:none; padding:0; margin-top:2rem; text-align:left; }
        .feature-list li {
            display:flex; align-items:center; gap:0.65rem;
            color:rgba(255,255,255,0.75); font-size:0.85rem; margin-bottom:0.75rem;
        }
        .feature-list li i { color:var(--cherry); font-size:1rem; flex-shrink:0; }

        .auth-right {
            flex:1; background:var(--pearl);
            display:flex; align-items:center; justify-content:center; padding:2rem;
        }
        .auth-box { width:100%; max-width:400px; }
        .auth-title { font-weight:900; font-size:1.7rem; color:#1a0a0f; margin-bottom:0.4rem; }
        .auth-sub { color:#888; font-size:0.875rem; margin-bottom:1.75rem; }

        .form-lbl { font-size:0.8rem; font-weight:700; color:#555; margin-bottom:0.3rem; }
        .form-inp {
            width:100%; padding:0.6rem 1rem;
            border:1.5px solid #e8e4e1; border-radius:10px;
            font-size:0.875rem; font-family:'Nunito',sans-serif;
            outline:none; transition:border-color .2s, box-shadow .2s;
            background:white; color:#1a0a0f;
        }
        .form-inp:focus { border-color:var(--cherry); box-shadow:0 0 0 3px rgba(196,30,58,0.12); }
        .form-inp.is-invalid { border-color:#dc3545; }
        .invalid-feedback { font-size:0.73rem; color:#dc3545; margin-top:0.2rem; }

        .btn-auth {
            width:100%; padding:0.7rem; background:var(--cherry); color:white;
            border:none; border-radius:10px; font-size:0.95rem; font-weight:700;
            font-family:'Nunito',sans-serif; cursor:pointer; transition:background .2s;
        }
        .btn-auth:hover { background:var(--cherry-dark); }

        @media(max-width:767px) { .auth-left { display:none; } }
    </style>
</head>
<body>
<div id="app" class="auth-wrap">

    {{-- Left panel --}}
    <div class="auth-left">
        <div class="auth-left-inner">
            <div class="auth-logo-box"><i class="bi bi-book-half"></i></div>
            <h2 class="auth-app-name">{{ config('app.name','LibraryApp') }}</h2>
            <p class="auth-tagline">Filloni udhëtimin tuaj me libra sot</p>
            <ul class="feature-list">
                <li><i class="bi bi-check-circle-fill"></i> Akses në mijëra tituj librash</li>
                <li><i class="bi bi-check-circle-fill"></i> Menaxho listën e dëshirave</li>
                <li><i class="bi bi-check-circle-fill"></i> Vlerëso dhe komento librat</li>
                <li><i class="bi bi-check-circle-fill"></i> Dërgim i shpejtë deri te dera</li>
                <li><i class="bi bi-check-circle-fill"></i> Kupona ekskluzivë për anëtarët</li>
            </ul>
        </div>
    </div>

    {{-- Right panel --}}
    <div class="auth-right">
        <div class="auth-box">
            <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none mb-4" style="color:#888;font-size:0.8rem;">
                <i class="bi bi-arrow-left"></i> Kthehu
            </a>

            <h2 class="auth-title">Krijo Llogarinë</h2>
            <p class="auth-sub">Regjistrohu falas dhe fillo të eksplorosh</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-lbl" for="name">Emri i Plotë</label>
                    <input id="name" type="text" name="name"
                           class="form-inp @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autocomplete="name" autofocus
                           placeholder="Emri Mbiemri">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-lbl" for="email">Adresa Email</label>
                    <input id="email" type="email" name="email"
                           class="form-inp @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autocomplete="email"
                           placeholder="emri@shembull.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-lbl" for="password">Fjalëkalimi</label>
                    <input id="password" type="password" name="password"
                           class="form-inp @error('password') is-invalid @enderror"
                           required autocomplete="new-password"
                           placeholder="Min. 8 karaktere">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-lbl" for="password-confirm">Konfirmo Fjalëkalimin</label>
                    <input id="password-confirm" type="password" name="password_confirmation"
                           class="form-inp" required autocomplete="new-password"
                           placeholder="Përsërit fjalëkalimin">
                </div>

                <button type="submit" class="btn-auth mb-3">Regjistrohu</button>

                <p class="text-center mb-0" style="font-size:0.85rem;color:#888;">
                    Ke llogari?
                    <a href="{{ route('login') }}" style="color:var(--cherry);font-weight:700;text-decoration:none;">
                        Hyr këtu
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
