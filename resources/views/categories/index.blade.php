@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lista e Kategorive</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Shto Kategori të Re</a>
    </div>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Përshkrimi</th>
                <th>Kategoria Prind</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->kategori_id }}</td>
                <td>{{ $category->emri }}</td>
                <td>{{ $category->pershkrimi }}</td>
                <td>{{ $category->parent ? $category->parent->emri : 'Kryesore' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection