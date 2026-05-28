@extends('layouts.admin')
@section('title','Edito Librin')

@section('styles')
<style>
.form-card{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);padding:2rem;}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
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
        <h4 style="font-weight:900;margin:0 0 2px;">Edito: {{ $book->titulli }}</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Ndrysho të dhënat e librit</p>
    </div>
    <a href="{{ route('books.index') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;"><i class="bi bi-arrow-left"></i> Kthehu</a>
</div>

<div class="form-card">
    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Titulli *</label>
                <input type="text" name="titulli" class="form-inp" value="{{ old('titulli', $book->titulli) }}" required>
            </div>
            <div class="form-row">
                <label class="form-lbl">ISBN *</label>
                <input type="text" name="isbn" class="form-inp" value="{{ old('isbn', $book->isbn) }}" required>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Autori *</label>
                <select name="author_id" class="form-sel" required>
                    @foreach($authors as $a)
                        <option value="{{ $a->id }}" {{ $book->author_id==$a->id?'selected':'' }}>
                            {{ $a->emri }} {{ $a->mbiemri }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <label class="form-lbl">Kategoria *</label>
                <select name="category_id" class="form-sel" required>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $book->category_id==$c->id?'selected':'' }}>
                            {{ $c->emri }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Çmimi (€) *</label>
                <input type="number" step="0.01" min="0" name="cmimi" class="form-inp" value="{{ old('cmimi', $book->cmimi) }}" required>
            </div>
            <div class="form-row">
                <label class="form-lbl">Sasia në Stok *</label>
                <input type="number" min="0" name="sasia" class="form-inp" value="{{ old('sasia', $book->sasia) }}" required>
            </div>
        </div>

        <div class="form-row">
            <label class="form-lbl">Përshkrimi</label>
            <textarea name="pershkrimi" class="form-ta" rows="4">{{ old('pershkrimi', $book->pershkrimi) }}</textarea>
        </div>

        <div style="display:flex;gap:10px;margin-top:.5rem;">
            <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Përditëso</button>
            <a href="{{ route('books.index') }}" class="btn-cancel">Anulo</a>
        </div>
    </form>
</div>
@endsection
