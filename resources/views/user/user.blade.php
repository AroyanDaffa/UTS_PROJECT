<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - E-commerce Logistics</title>
    <link href="{{ asset('css/style3.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Sidebar Menu Section -->
    <section id="menu">
        <div class="logo">
            <h2>PT.BERANDA</h2>
        </div>
        <div class="items">
            <li><i class='bx bx-store-alt'></i></i><a href="{{ url('/dashboard-user') }}">Our Product</a></li>
            <li><i class='bx bxs-truck'></i></i><a href="{{ url('/tracking') }}">Tracking</a></li>
            <li><i class='bx bxs-package'></i></i><a href="{{ url('/mylist') }}">My Order</a></li>
        </div>
    </section>

    <section id="main-content">
        <!-- Header Section -->
        <header>
    <div class="search">
        <i class='bx bx-search-alt-2'></i>
        <input type="text" placeholder="Search">
    </div>
    <div class="user-profile">
        <i class='bx bxs-bell'></i>
        <img src="{{ asset('images/admin.png') }}" alt="User Profile">
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
    </header>
    <div class="container mt-5">
            <h2 class="text-center">Shop Our Products</h2>
            <div class="row mt-4">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                {{ $product->description }}<br>
                                Price: ${{ number_format($product->price, 2) }}<br>
                                Stock: {{ $product->stock }}
                            </p>
                            <a href="#" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
