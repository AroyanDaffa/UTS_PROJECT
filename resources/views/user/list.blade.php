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
            <li><i class='bx bxs-truck'></i></i><a href="{{ url('/mylist') }}">My List</a></li>
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
            <h2 class="text-center">My Order List</h2>
            <div class="row mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>No. Resi</th>
                            <th>Total Price</th>
                            <th>Order Status</th>
                            <th>Shipping Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->no_resi ? $order->no_resi->no_resi : 'No Resi' }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->no_resi ? $order->no_resi->shipping_status : 'Not Shipped' }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">View Details</a>
                                @if($order->status == 'pending')
                                <a href="{{ route('orders.cancel', $order->id) }}" class="btn btn-danger">Cancel Order</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>