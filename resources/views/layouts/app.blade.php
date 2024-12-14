<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>PT.BERANDA</h1>
        </header>
        
        <!-- Konten Halaman -->
        <main>
            @yield('content')
        </main>
        
        <footer>
            <p>&copy; PT.BERANDA 2024</p>
        </footer>
    </div>
</body>
</html>
