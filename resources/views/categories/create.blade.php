@extends('layouts.admin')
@section('title','Shto Kategori')

@section('styles')
<style>
.form-card{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);padding:2rem;max-width:520px;}
.form-row{margin-bottom:1rem;}
.form-lbl{display:block;font-size:.78rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-inp,.form-sel,.form-ta{width:100%;padding:.55rem .9rem;border:1.5px solid #e8e4e1;border-radius:10px;font-size:.875rem;font-family:'Nunito',sans-serif;outline:none;transition:border-color .2s;background:white;color:#1a0a0f;}
.form-inp:focus,.form-sel:focus,.form-ta:focus{border-color:var(--cherry);box-shadow:0 0 0 3px rgba(196,30,58,.1);}
.btn-save{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.6rem 1.75rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;}
.btn-save:hover{background:#9B1530;}
.btn-cancel{background:var(--bg);color:#555;border:none;border-radius:10px;padding:.6rem 1.25rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;text-decoration:none;}
</style>
@endsection

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Shto Kategori të Re</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Krijo kategori të re librash</p>
    </div>
    <a href="{{ route('categories.index') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;"><i class="bi bi-arrow-left"></i> Kthehu</a>
</div>

@if($errors->any())
<div style="background:#fee2e2;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.83rem;color:#dc2626;max-width:520px;">
    <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="form-card">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <label class="form-lbl">Emri i Kategorisë *</label>
            <input type="text" name="emri" class="form-inp" value="{{ old('emri') }}"
                   placeholder="p.sh. Roman, Shkencë, Historia..." required>
        </div>

        <div class="form-row">
            <label class="form-lbl">Përshkrimi</label>
            <textarea name="pershkrimi" class="form-ta" rows="3"
                      placeholder="Përshkruaj kategorinë...">{{ old('pershkrimi') }}</textarea>
        </div>

        <div class="form-row">
            <label class="form-lbl">Kategoria Prind <span style="color:#aaa;font-weight:400;">(opsionale)</span></label>
            <select name="kategoria_prind_id" class="form-sel">
                <option value="">— Kategori Kryesore (pa prind) —</option>
                @foreach($parentCategories as $p)
                    <option value="{{ $p->id }}" {{ old('kategoria_prind_id')==$p->id?'selected':'' }}>
                        {{ $p->emri }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:flex;gap:10px;margin-top:.5rem;">
            <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Ruaj Kategorinë</button>
            <a href="{{ route('categories.index') }}" class="btn-cancel">Anulo</a>
        </div>
    </form>
</div>
@endsection
