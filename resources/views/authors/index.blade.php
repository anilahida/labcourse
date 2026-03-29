<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxhimi i Autoreve</title>
</head>
<body>
    <h1>Menaxhimi i Autoreve</h1>
    <table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>ID</th>
            <th>Foto</th> <th>Emri</th>
            <th>Mbiemri</th>
            <th>Biografia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authors as $author)
        <tr>
            <td>{{ $author->author_id }}</td>
            
            <td>
    @if($author->foto_autori)
        <img src="/labcourse/public/images/{{ $author->foto_autori }}" width="80" style="border-radius: 5px;">
    @else
        <span>Pa foto</span>
    @endif
</td>

            <td>{{ $author->emri }}</td>
            <td>{{ $author->mbiemri }}</td>
            <td>{{ $author->biografia }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>