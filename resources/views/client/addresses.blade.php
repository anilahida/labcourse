@extends('layouts.client')

@section('title', 'Adresat')
@section('page-title', 'Adresat')
@section('page-sub', 'Menaxho adresat e dërgimit')

@section('styles')
<style>
.addr-grid { display: grid; grid-template-columns: repeat(3,1fr); gap:16px; margin-bottom:2rem; }
.addr-card {
    background:white; border-radius:16px; padding:1.25rem;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
    border:2px solid transparent; position:relative;
    transition:border-color .2s;
}
.addr-card.is-default { border-color:var(--cherry); }
.addr-badge {
    position:absolute; top:12px; right:12px;
    background:var(--cherry); color:white;
    font-size:.65rem; font-weight:700; padding:2px 8px; border-radius:20px;
}
.addr-name  { font-weight:800; font-size:.9rem; color:#1a0a0f; margin-bottom:4px; }
.addr-line  { font-size:.8rem; color:#666; line-height:1.6; }
.addr-phone { font-size:.75rem; color:#aaa; margin-top:6px; }
.addr-actions { display:flex; gap:6px; margin-top:12px; }
.btn-default {
    flex:1; padding:.38rem; background:#fff0f2; color:var(--cherry);
    border:1.5px solid #ffd0d8; border-radius:8px; font-size:.72rem;
    font-weight:700; cursor:pointer; font-family:'Nunito',sans-serif;
    transition:all .2s;
}
.btn-default:hover { background:var(--cherry); color:white; border-color:var(--cherry); }
.btn-del {
    width:34px; background:#f5f5f5; color:#aaa; border:none;
    border-radius:8px; cursor:pointer; display:flex; align-items:center;
    justify-content:center; transition:all .2s;
}
.btn-del:hover { background:#fee2e2; color:#dc2626; }

/* Form */
.form-card { background:white; border-radius:16px; padding:1.5rem; box-shadow:0 2px 10px rgba(0,0,0,.06); }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-row  { margin-bottom:0; }
.form-lbl  { display:block; font-size:.76rem; font-weight:700; color:#555; margin-bottom:.3rem; }
.form-inp  {
    width:100%; padding:.55rem .9rem; border:1.5px solid #e8e4e1;
    border-radius:10px; font-size:.86rem; font-family:'Nunito',sans-serif;
    outline:none; transition:border-color .2s; background:white;
}
.form-inp:focus { border-color:var(--cherry); box-shadow:0 0 0 3px rgba(196,30,58,.08); }
.form-inp.is-err { border-color:#dc3545; }
.err-msg { font-size:.72rem; color:#dc3545; margin-top:.2rem; }
.btn-save {
    background:var(--cherry); color:white; border:none; border-radius:10px;
    padding:.6rem 1.75rem; font-size:.88rem; font-weight:700;
    font-family:'Nunito',sans-serif; cursor:pointer; transition:background .2s;
}
.btn-save:hover { background:#9B1530; }

@media(max-width:900px) { .addr-grid{grid-template-columns:repeat(2,1fr);} }
@media(max-width:600px) { .addr-grid{grid-template-columns:1fr;} .form-grid{grid-template-columns:1fr;} }
</style>
@endsection

@section('content')

@foreach(['success','error'] as $s)
    @if(session($s))
    <div style="background:{{ $s==='success'?'#d1fae5':'#fee2e2' }};border-radius:10px;padding:.7rem 1rem;margin-bottom:14px;font-size:.84rem;">
        {{ session($s) }}
    </div>
    @endif
@endforeach

{{-- Adresat ekzistuese --}}
@if($addresses->count() > 0)
<div class="sec-title" style="margin-bottom:1rem;">
    Adresat e Mia
    <span style="color:#aaa;font-size:.78rem;font-weight:600;">{{ $addresses->count() }} adresa</span>
</div>

<div class="addr-grid">
    @foreach($addresses as $addr)
    <div class="addr-card {{ $addr->default ? 'is-default' : '' }}">
        @if($addr->default)
            <span class="addr-badge"><i class="bi bi-check2"></i> Kryesore</span>
        @endif
        <div class="addr-name">{{ $addr->emri }} {{ $addr->mbiemri }}</div>
        <div class="addr-line">
            {{ $addr->rruga }}<br>
            {{ $addr->qyteti }}, {{ $addr->shteti }}
            @if($addr->kodi_postar) — {{ $addr->kodi_postar }} @endif
        </div>
        @if($addr->telefoni)
        <div class="addr-phone"><i class="bi bi-telephone-fill" style="color:var(--cherry);"></i> {{ $addr->telefoni }}</div>
        @endif
        <div class="addr-actions">
            @if(!$addr->default)
            <form action="{{ route('addresses.default', $addr->id) }}" method="POST" style="flex:1;">
                @csrf
                <button type="submit" class="btn-default" style="width:100%;">
                    <i class="bi bi-star-fill"></i> Vendos si kryesore
                </button>
            </form>
            @else
            <div style="flex:1;display:flex;align-items:center;gap:4px;font-size:.75rem;color:var(--cherry);font-weight:700;">
                <i class="bi bi-check-circle-fill"></i> Adresa kryesore
            </div>
            @endif
            <form action="{{ route('addresses.destroy', $addr->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del" title="Fshi adresën">
                    <i class="bi bi-trash3"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Forma e re --}}
<div class="sec-title" style="margin-bottom:1rem;">
    <span>{{ $addresses->count() > 0 ? 'Shto Adresë të Re' : 'Shto Adresën Tënde të Parë' }}</span>
</div>

<div class="form-card">
    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-row">
                <label class="form-lbl">Emri *</label>
                <input type="text" name="emri" class="form-inp @error('emri') is-err @enderror"
                       value="{{ old('emri') }}" placeholder="Emri juaj" required>
                @error('emri')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <label class="form-lbl">Mbiemri *</label>
                <input type="text" name="mbiemri" class="form-inp @error('mbiemri') is-err @enderror"
                       value="{{ old('mbiemri') }}" placeholder="Mbiemri juaj" required>
                @error('mbiemri')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row" style="margin-top:12px;">
            <label class="form-lbl">Rruga / Adresa *</label>
            <input type="text" name="rruga" class="form-inp @error('rruga') is-err @enderror"
                   value="{{ old('rruga') }}" placeholder="p.sh. Rr. Nënë Tereza, nr. 15" required>
            @error('rruga')<div class="err-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-grid" style="margin-top:12px;">
            <div class="form-row">
                <label class="form-lbl">Qyteti *</label>
                <input type="text" name="qyteti" class="form-inp @error('qyteti') is-err @enderror"
                       value="{{ old('qyteti') }}" placeholder="Prishtinë" required>
                @error('qyteti')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <label class="form-lbl">Shteti</label>
                <input type="text" name="shteti" class="form-inp"
                       value="{{ old('shteti', 'Kosovë') }}" placeholder="Kosovë">
            </div>
        </div>

        <div class="form-grid" style="margin-top:12px;">
            <div class="form-row">
                <label class="form-lbl">Kodi Postar</label>
                <input type="text" name="kodi_postar" class="form-inp"
                       value="{{ old('kodi_postar') }}" placeholder="10000">
            </div>
            <div class="form-row">
                <label class="form-lbl">Telefoni</label>
                <input type="text" name="telefoni" class="form-inp"
                       value="{{ old('telefoni') }}" placeholder="+383 44 000 000">
            </div>
        </div>

        <div style="margin-top:14px;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="default" id="chk-default" value="1"
                   {{ old('default') ? 'checked' : ($addresses->count() === 0 ? 'checked' : '') }}
                   style="width:16px;height:16px;accent-color:var(--cherry);cursor:pointer;">
            <label for="chk-default" style="font-size:.82rem;font-weight:600;color:#555;cursor:pointer;">
                Vendos si adresë kryesore
            </label>
        </div>

        <div style="margin-top:1.25rem;">
            <button type="submit" class="btn-save">
                <i class="bi bi-geo-alt-fill"></i> Ruaj Adresën
            </button>
        </div>
    </form>
</div>

@endsection
