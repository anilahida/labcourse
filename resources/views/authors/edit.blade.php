<!DOCTYPE html>
<html lang="sq">
<head>
    <title>Edito Autorin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-warning">Edito Autorin: {{ $author->emri }}</h2>
        <hr>
        
        <form action="{{ url('authors/'.$author->author_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label>Emri:</label>
                <input type="text" name="emri" class="form-control" value="{{ $author->emri }}" required>
            </div>

            <div class="mb-3">
                <label>Mbiemri:</label>
                <input type="text" name="mbiemri" class="form-control" value="{{ $author->mbiemri }}" required>
            </div>

            <div class="mb-3">
                <label>Biografia:</label>
                <textarea name="biografia" class="form-control" rows="3">{{ $author->biografia }}</textarea>
            </div>

            <div class="mb-3">
                <label>Foto aktuale:</label><br>
                <img src="/labcourse/public/images/{{ $author->foto_autori }}" width="100" class="mb-2"><br>
                <label>Ndrysho foton (opsionale):</label>
                <input type="file" name="foto_autori" class="form-control">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-warning">Përditëso të dhënat</button>
                <a href="{{ url('authors') }}" class="btn btn-secondary">Anulo</a>
            </div>
        </form>
    </div>
</body>
</html>