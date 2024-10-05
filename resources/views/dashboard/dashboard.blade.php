<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-commerce Logistics</title>
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
            <li><i class='bx bxs-dashboard'></i><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li><i class='bx bxs-category-alt'></i><a href="{{ url('/category') }}">Category</a></li>
            <li><i class='bx bxl-product-hunt'></i><a href="{{ url('/products') }}">Product</a></li>
            <li><i class='bx bxs-user-rectangle'></i><a href="{{ url('/customers') }}">Customers</a></li>
            <li><i class='bx bxs-cart'></i><a href="{{ url('/supplier') }}">Supplier</a></li>
            <li><i class='bx bxs-package'></i><a href="{{ url('/orders') }}">Orders</a></li>
            <li><i class='bx bxs-truck'></i><a href="{{ url('/shipping') }}">Shipping</a></li>
            <li><i class='bx bxs-bar-chart-alt-2'></i><a href="{{ url('/reports') }}">Reports</a></li>
        </div>
    </section>

    <!-- Main Content Section -->
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

        <!-- Dashboard Overview Section -->
        <h1>Welcome, Admin</h1>
        <div class="dashboard-overview">
            <div class="overview-card">
                <h3>Total Products</h3>
                <p>1,234</p>
            </div>
            <div class="overview-card">
                <h3>Total Orders</h3>
                <p>3,456</p>
            </div>
            <div class="overview-card">
                <h3>Pending Orders</h3>
                <p>123</p>
            </div>
            <div class="overview-card">
                <h3>Shipped Orders</h3>
                <p>3,333</p>
            </div>
            <div class="overview-card">
                <h3>Categories</h3>
                <p>12</p>
            </div>
            <div class="overview-card">
                <h3>Customers</h3>
                <p>456</p>
            </div>
            <div class="overview-card">
                <h3>Suppliers</h3>
                <p>34</p>
            </div>
            <div class="overview-card">
                <h3>Total Revenue</h3>
                <p>Rp. 1.234.567</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <h2>Recent Orders</h2>
        <table class="recent-orders">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1001</td>
                    <td>John Doe</td>
                    <td>Pending</td>
                    <td>Rp. 500,000</td>
                    <td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                    <td>#1002</td>
                    <td>Jane Smith</td>
                    <td>Shipped</td>
                    <td>Rp. 750,000</td>
                    <td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                    <td>#1003</td>
                    <td>Michael Johnson</td>
                    <td>Delivered</td>
                    <td>Rp. 1,200,000</td>
                    <td><button class="btn btn-primary">View</button></td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>


