@extends('layouts.client')

@section('title', 'Adresat')
@section('page-title', 'Adresat')
@section('page-sub', 'Menaxho adresat e dërgesës')

@section('styles')
<style>
    .addr-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .addr-card {
        background: white; border-radius: 14px; padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .addr-card h6 { font-weight: 700; font-size: 0.95rem; margin-bottom: 1.25rem; color: #1a0a0f; }
    .form-row { margin-bottom: 1rem; }
    .form-lbl { font-size: 0.75rem; font-weight: 700; color: #555; margin-bottom: 0.3rem; display: block; }
    .form-inp {
        width: 100%; padding: 0.55rem 0.9rem;
        border: 1.5px solid #e8e4e1; border-radius: 10px;
        font-size: 0.875rem; font-family: 'Nunito', sans-serif;
        outline: none; transition: border-color .2s;
        background: white; color: #1a0a0f;
    }
    .form-inp:focus { border-color: var(--cherry); box-shadow: 0 0 0 3px rgba(196,30,58,0.10); }
    .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .btn-save {
        background: var(--cherry); color: white; border: none;
        border-radius: 10px; padding: 0.6rem 1.5rem;
        font-size: 0.88rem; font-weight: 700; cursor: pointer;
        font-family: 'Nunito', sans-serif; margin-top: 0.5rem;
        transition: background .2s;
    }
    .btn-save:hover { background: var(--cherry-dark, #9B1530); }
    .addr-empty {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 2rem 1rem; text-align: center;
    }
    @media(max-width:700px) { .addr-wrap { grid-template-columns: 1fr; } .form-row-2 { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

@if(session('success'))
<div style="background:#d1fae5;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;">{{ session('success') }}</div>
@endif

<div class="addr-wrap">
    {{-- Forma e adresës --}}
    <div class="addr-card">
        <h6><i class="bi bi-plus-circle-fill" style="color:var(--cherry);margin-right:6px;"></i>Shto Adresë të Re</h6>
        <form method="POST" action="{{ route('addresses.index') }}">
            @csrf
            <div class="form-row">
                <label class="form-lbl">Emri i plotë</label>
                <input type="text" class="form-inp" name="emri" placeholder="Emri Mbiemri" required>
            </div>
            <div class="form-row">
                <label class="form-lbl">Adresa</label>
                <input type="text" class="form-inp" name="adresa" placeholder="Rruga, Nr..." required>
            </div>
            <div class="form-row-2">
                <div class="form-row" style="margin-bottom:0;">
                    <label class="form-lbl">Qyteti</label>
                    <input type="text" class="form-inp" name="qyteti" placeholder="Tiranë" required>
                </div>
                <div class="form-row" style="margin-bottom:0;">
                    <label class="form-lbl">Kodi Postar</label>
                    <input type="text" class="form-inp" name="kodi_postar" placeholder="1001">
                </div>
            </div>
            <div class="form-row" style="margin-top:1rem;">
                <label class="form-lbl">Telefoni</label>
                <input type="tel" class="form-inp" name="telefoni" placeholder="+355 6X XXX XXXX">
            </div>
            <button type="submit" class="btn-save">
                <i class="bi bi-check2"></i> Ruaj Adresën
            </button>
        </form>
    </div>

    {{-- Lista e adresave --}}
    <div class="addr-card">
        <h6><i class="bi bi-geo-alt-fill" style="color:var(--cherry);margin-right:6px;"></i>Adresat e Ruajtura</h6>
        <div class="addr-empty">
            <i class="bi bi-geo-alt" style="font-size:2.5rem;color:#e0d0d4;"></i>
            <p style="color:#aaa;margin-top:0.75rem;font-size:0.88rem;">Nuk ke adresa të ruajtura ende.<br>Shto adresën e parë.</p>
        </div>
    </div>
</div>

@endsection
