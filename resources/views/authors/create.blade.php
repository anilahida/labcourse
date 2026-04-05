<!DOCTYPE html>
<html lang="sq">
<head>
    <title>Sistemi 90 - Shto Autor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-primary">Shto Autor të Ri</h2>
        <hr>
        
        <form action="{{ url('authors') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Emri:</label>
                <input type="text" name="emri" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mbiemri:</label>
                <input type="text" name="mbiemri" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Biografia:</label>
                <textarea name="biografia" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Foto e Autorit:</label>
                <input type="file" name="foto_autori" class="form-control">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Ruaj në Databazë</button>
                <a href="{{ url('authors') }}" class="btn btn-secondary">Anulo</a>
            </div>
        </form>
    </div>
</body>
</html>