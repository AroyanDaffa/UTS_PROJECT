<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-commerce Logistics</title>
    <link href="{{ asset('css/style3.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .year-filter {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .year-filter select {
            margin-left: 10px;
            padding: 5px;
        }
    </style>
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
            <li><i class='bx bxs-package'></i><a href="{{ url('/orders') }}">Orders</a></li>
            <li><i class='bx bxs-truck'></i><a href="{{ url('/shippings') }}">Shippings</a></li>
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

        <!-- Year Filter Section -->
        <div class="year-filter">
            <label for="year-select">Select Year:</label>
            <select id="year-select">
                @foreach($years as $year)
                <option value="{{ $year }}">
                    {{ $year }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Dashboard Overview Section -->
        <h1>Welcome, Admin</h1>
        <div class="dashboard-overview">
            <div class="overview-card">
                <h3>Total Revenue</h3>
                <p id="revenue-value">0</p>
            </div>
        </div>

        <!-- Top Products Section -->
        <h2>Top 5 Products</h2>
        <table class="recent-orders" id="top-products-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Order Frequency</th>
                </tr>
            </thead>
            <tbody>
                <!-- Top products will be dynamically populated -->
            </tbody>
        </table>
    </section>

    <script>
        // Predefined data from the backend
        const salesRevenue = @json($salesRevenue);
        const topProducts = @json($topProducts);
        const years = @json($years);

        // Get references to DOM elements
        const yearSelect = document.getElementById('year-select');
        const revenueValue = document.getElementById('revenue-value');
        const topProductsTableBody = document.querySelector('#top-products-table tbody');

        // Function to update dashboard based on selected year
        function updateDashboard(year) {
            // Update Revenue
            const formattedRevenue = 'Rp. ' + new Intl.NumberFormat('id-ID').format(salesRevenue[year] || 0);
            revenueValue.textContent = formattedRevenue;

            // Update Top Products
            const productsForYear = topProducts[year];
            topProductsTableBody.innerHTML = productsForYear.length > 0 ?
                productsForYear.map(product => `
                    <tr>
                        <td>${product.sk_produk}</td>
                        <td>${product.nama_produk}</td>
                        <td>${product.nama_kategori}</td>
                        <td>${product.order_frequencies}</td>
                    </tr>
                `).join('') :
                `<tr><td colspan="4" class="text-center">No product data found</td></tr>`;
        }

        // Initial setup with the first year
        const initialYear = years[0];
        yearSelect.value = initialYear;
        updateDashboard(initialYear);

        // Add event listener for year selection
        yearSelect.addEventListener('change', (e) => {
            updateDashboard(e.target.value);
        });
    </script>
</body>

</html>