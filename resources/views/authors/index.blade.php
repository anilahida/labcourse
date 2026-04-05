<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxhimi i Autorëve</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Menaxhimi i Autorëve</h1>
        <a href="{{ url('authors/create') }}" class="btn btn-primary">Shto Autor të Ri</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Biografia</th>
                <th style="width: 150px;">Aksionet</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->author_id }}</td>
                <td class="text-center">
                    @if($author->foto_autori)
                        <img src="/labcourse/public/images/{{ $author->foto_autori }}" width="70" class="rounded shadow-sm">
                    @else
                        <span class="badge bg-secondary">Pa foto</span>
                    @endif
                </td>
                <td>{{ $author->emri }}</td>
                <td>{{ $author->mbiemri }}</td>
                <td><small>{{ Str::limit($author->biografia, 100) }}</small></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ url('authors/'.$author->author_id.'/edit') }}" class="btn btn-warning btn-sm">Edito</a>

                        <form action="{{ url('authors/'.$author->author_id) }}" method="POST" onsubmit="return confirm('A jeni të sigurt?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Fshi</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>