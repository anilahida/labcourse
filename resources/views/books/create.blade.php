@extends('layouts.admin')
@section('title','Shto Libër')

@section('styles')
<style>
.form-card{background:white;border-radius:16px;border:1px solid #eef0f5;box-shadow:0 1px 4px rgba(0,0,0,.05);padding:2rem;}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-row{margin-bottom:1rem;}
.form-lbl{display:block;font-size:.78rem;font-weight:700;color:#555;margin-bottom:.3rem;}
.form-inp,.form-sel,.form-ta{
    width:100%;padding:.55rem .9rem;
    border:1.5px solid #e8e4e1;border-radius:10px;
    font-size:.875rem;font-family:'Nunito',sans-serif;
    outline:none;transition:border-color .2s;
    background:white;color:#1a0a0f;
}
.form-inp:focus,.form-sel:focus,.form-ta:focus{border-color:var(--cherry);box-shadow:0 0 0 3px rgba(196,30,58,.1);}
.form-inp.is-err,.form-sel.is-err{border-color:#dc3545;}
.err-msg{font-size:.72rem;color:#dc3545;margin-top:.2rem;}
.btn-save{background:var(--cherry);color:white;border:none;border-radius:10px;padding:.6rem 1.75rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;transition:background .2s;}
.btn-save:hover{background:#9B1530;}
.btn-cancel{background:var(--bg);color:#555;border:none;border-radius:10px;padding:.6rem 1.25rem;font-size:.88rem;font-weight:700;font-family:'Nunito',sans-serif;cursor:pointer;text-decoration:none;}
</style>
@endsection

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div>
        <h4 style="font-weight:900;margin:0 0 2px;">Shto Libër të Ri</h4>
        <p style="color:#aaa;margin:0;font-size:.83rem;">Plotëso të dhënat e librit të ri</p>
    </div>
    <a href="{{ route('books.index') }}" style="color:#aaa;font-size:.83rem;text-decoration:none;"><i class="bi bi-arrow-left"></i> Kthehu</a>
</div>

@if($errors->any())
<div style="background:#fee2e2;border-radius:10px;padding:.75rem 1rem;margin-bottom:14px;font-size:.83rem;color:#dc2626;">
    <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="form-card">
    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Titulli i Librit *</label>
                <input type="text" name="titulli" class="form-inp @error('titulli') is-err @enderror"
                       value="{{ old('titulli') }}" placeholder="Titulli..." required>
                @error('titulli')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <label class="form-lbl">ISBN *</label>
                <input type="text" name="isbn" class="form-inp @error('isbn') is-err @enderror"
                       value="{{ old('isbn') }}" placeholder="978-3-16-148410-0" required>
                @error('isbn')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Autori *</label>
                <select name="author_id" class="form-sel @error('author_id') is-err @enderror" required>
                    <option value="">— Zgjidh autorin —</option>
                    @foreach($authors as $a)
                        <option value="{{ $a->id }}" {{ old('author_id')==$a->id?'selected':'' }}>
                            {{ $a->emri }} {{ $a->mbiemri }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <label class="form-lbl">Kategoria *</label>
                <select name="category_id" class="form-sel @error('category_id') is-err @enderror" required>
                    <option value="">— Zgjidh kategorinë —</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>
                            {{ $c->emri }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-row">
                <label class="form-lbl">Çmimi (€) *</label>
                <input type="number" step="0.01" min="0" name="cmimi"
                       class="form-inp @error('cmimi') is-err @enderror"
                       value="{{ old('cmimi') }}" placeholder="0.00" required>
                @error('cmimi')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-row">
                <label class="form-lbl">Sasia në Stok *</label>
                <input type="number" min="0" name="sasia"
                       class="form-inp @error('sasia') is-err @enderror"
                       value="{{ old('sasia') }}" placeholder="0" required>
                @error('sasia')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row">
            <label class="form-lbl">Përshkrimi</label>
            <textarea name="pershkrimi" class="form-ta" rows="4"
                      placeholder="Përshkruaj librin shkurtimisht...">{{ old('pershkrimi') }}</textarea>
        </div>

        <div style="display:flex;gap:10px;margin-top:.5rem;">
            <button type="submit" class="btn-save"><i class="bi bi-check2"></i> Ruaj Librin</button>
            <a href="{{ route('books.index') }}" class="btn-cancel">Anulo</a>
        </div>
    </form>
</div>
@endsection
