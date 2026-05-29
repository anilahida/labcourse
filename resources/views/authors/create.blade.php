@extends('layouts.admin')
@section('title','Shto Autor')

@section('styles')
<style>
.form-card{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);padding:2rem;max-width:640px;}
.form-row{margin-bottom:1rem;}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-lbl{display:block;font-size:.78rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-inp,.form-ta{width:100%;padding:.55rem .9rem;border:1.5px solid #e8e4e1;border-radius:10px;font-size:.875rem;font-family:'Nunito',sans-serif;outline:none;transition:border-color .2s;background:white;color:#1a0a0f;}
.form-inp:focus,.form-ta:focus{border-color:var(--cherry);box-shadow:0 0 0 3px rgba(196,30,58,.1);}
.form-file{width:100%;padding:.45rem .9rem;border:1.5px dashed #e8e4e1;border-radius:10px;font-size:.83rem;font-family:'Nunito',sans-serif;outline:none;cursor:pointer;}
.btn-save{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.6rem 1.75rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;}
.btn-save:hover{background:#9B1530;}
.btn-cancel{background:var(--bg);color:#555;border:none;border-radius:10px;padding:.6rem 1.25rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;text-decoration:none;}
</style>
@endsection

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Shto Autor të Ri</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Plotëso të dhënat e autorit</p>
    </div>
    <a href="{{ route('authors.index') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;"><i class="bi bi-arrow-left"></i> Kthehu</a>
</div>

<div class="form-card">
    <form action="{{ url('authors') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Emri *</label>
                <input type="text" name="emri" class="form-inp" value="{{ old('emri') }}" placeholder="Emri..." required>
            </div>
            <div class="form-row">
                <label class="form-lbl">Mbiemri *</label>
                <input type="text" name="mbiemri" class="form-inp" value="{{ old('mbiemri') }}" placeholder="Mbiemri..." required>
            </div>
        </div>

        <div class="form-row">
            <label class="form-lbl">Biografia</label>
            <textarea name="biografia" class="form-ta" rows="4"
                      placeholder="Shkruaj diçka rreth autorit...">{{ old('biografia') }}</textarea>
        </div>

        <div class="form-row">
            <label class="form-lbl">Foto e Autorit</label>
            <input type="file" name="foto_autori" class="form-file" accept="image/*">
        </div>

        <div style="display:flex;gap:10px;margin-top:.5rem;">
            <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Ruaj Autorin</button>
            <a href="{{ route('authors.index') }}" class="btn-cancel">Anulo</a>
        </div>
    </form>
</div>
@endsection
