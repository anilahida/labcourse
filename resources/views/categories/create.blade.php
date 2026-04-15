@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Shto Kategori të Re</h1>
    <hr>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Emri i Kategorisë</label>
            <input type="text" name="emri" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Përshkrimi</label>
            <textarea name="pershkrimi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategoria Prind (Opsionale)</label>
            <select name="kategoria_prind_id" class="form-control">
                <option value="">Asnjë (Kategori Kryesore)</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->kategori_id }}">{{ $parent->emri }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ruaj Kategorinë</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Anulo</a>
    </form>
</div>
@endsection