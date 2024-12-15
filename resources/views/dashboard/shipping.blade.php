<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping - E-commerce Logistics</title>
    <link href="{{ asset('css/style3.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <section id="menu">
        <div class="logo">
            <h2>PT.BERANDA</h2>
        </div>
        <div class="items">
            <li><i class='bx bxs-dashboard'></i><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li><i class='bx bxs-category-alt'></i><a href="{{ url('/category') }}">Category</a></li>
            <li><i class='bx bxl-product-hunt'></i><a href="{{ url('/products') }}">Product</a></li>
            <li><i class='bx bxs-user-rectangle'></i><a href="{{ url('/customers') }}">Customers</a></li>
            <li><i class='bx bxs-package'></i><a href="{{ url('/orders') }}">Orders</a></li>
            <li><i class='bx bxs-truck'></i><a href="{{ url('/shippings') }}">Shippings</a></li>
            <li><i class='bx bxs-bar-chart-alt-2'></i><a href="{{ url('/reports') }}">Reports</a></li>
        </div>
    </section>

    <section id="main-content">
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

        <h1>Shipping Management</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No Resi</th>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Product Name</th>
                    <th>Shipping Method</th>
                    <th>Address</th>
                    <th>Tanggal</th>
                    <th>Tanggal Selesai</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shippings as $shipping)
                <tr>
                    <td>{{ $shipping->no_resi }}</td>
                    <td>{{ $shipping->order_id }}</td>
                    <td>{{ $shipping->customer_id }}</td>
                    <td>{{ $shipping->product_name }}</td>
                    <td>{{ $shipping->shipping_method }}</td>
                    <td>{{ $shipping->address }}</td>
                    <td>{{ $shipping->tanggal }}</td>
                    <td>{{ $shipping->tanggal_selesai }}</td>
                    <td>
                        <a href="{{ route('shipping.view', $shipping->id) }}" class="btn btn-primary">View</a>
                        <a href="{{ route('shipping.edit', $shipping->id) }}" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>

</html>