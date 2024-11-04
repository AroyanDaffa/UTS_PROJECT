<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking - E-commerce Logistics</title>
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
            <li><i class='bx bx-store-alt'></i></i><a href="{{ url('/user') }}">Our Product</a></li>
            <li><i class='bx bxs-truck'></i></i><a href="{{ url('/tracking') }}">Tracking</a></li>
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
                <i class='bx bxs-bell'></i>&nbsp; &nbsp;
                <img src="{{ asset('images/admin.png') }}" alt="User Profile">
            </div>
        </header>
        <div class="container mt-5">
        <h2 class="text-center">Track Your Order</h2>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form action="/" method="GET" class="tracking-form">
                    <div class="mb-3">
                        <label for="trackingID" class="form-label">Enter Tracking Number</label>
                        <input type="text" id="trackingID" name="trackingID" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Track Order</button>
                </form>
            </div>
        </div>
        
        <div class="tracking-result mt-5">
            <!-- Order tracking information will be displayed here after form submission -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Status</h5>
                    <p><strong>Tracking ID:</strong> 123456789</p>
                    <p><strong>Status:</strong> In Transit</p>
                    <p><strong>Estimated Delivery:</strong> 2024-10-10</p>
                    <p><strong>Location:</strong> Jakarta, Indonesia</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
