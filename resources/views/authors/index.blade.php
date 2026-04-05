<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxhimi i Autoreve</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Menaxhimi i Autoreve</h1>
    
    <a href="{{ url('authors/create') }}" class="btn btn-primary mb-3">Shto Autor të Ri</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Biografia</th>
                <th>Aksionet</th> </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->author_id }}</td>
                <td>
                    @if($author->foto_autori)
                        <img src="/labcourse/public/images/{{ $author->foto_autori }}" width="80" style="border-radius: 5px;">
                    @else
                        <span class="text-muted">Pa foto</span>
                    @endif
                </td>
                <td>{{ $author->emri }}</td>
                <td>{{ $author->mbiemri }}</td>
                <td>{{ $author->biografia }}</td>
                <td>
                    <form action="{{ url('authors/'.$author->author_id) }}" method="POST" onsubmit="return confirm('A jeni të sigurt që dëshironi ta fshini këtë autor?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Fshi</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>