<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menaxhimi i Klientëve</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100">
    <div id="app" class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Sistemi i Klientëve</h1>
        <clients-index></clients-index>
    </div>
</body>
</html>