<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistemi i Porosive</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100">
    <div id="app" class="container mx-auto mt-10 p-6 max-w-6xl">
        <main-layout></main-layout>
    </div>
</body>
</html>