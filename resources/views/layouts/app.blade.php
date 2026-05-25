<!DOCTYPE html>
<html lang="sq">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <div style="width: 250px; background-color: #8B0000; color: white; min-height: 100vh;">
            <h4 class="p-3 text-center">Libraria Ime</h4>
            <nav class="nav flex-column p-2">
                <a class="nav-link text-white" href="/orders">Porositë</a>
                <a class="nav-link text-white" href="/authors">Autorët</a>
                <a class="nav-link text-white" href="/categories">Kategoritë</a>
            </nav>
        </div>
        <div id="app" class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
</body>
</html>