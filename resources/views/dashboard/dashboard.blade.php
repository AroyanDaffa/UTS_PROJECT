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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        <div class="row">
            <!-- Monthly Revenue Trend Section -->
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h2>Monthly Revenue Trend</h2>
                    <canvas id="revenue-chart"></canvas>
                </div>
            </div>

            <!-- Top Products Section -->
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h2>Top 5 Products</h2>
                    <canvas id="top-products-chart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script>
        console.log(@JSON($salesRevenue));
        console.log(@JSON($topProducts));
        console.log(@JSON($years));
        console.log(@JSON($salesRevenueSecondary));

        // Predefined data from the backend
        const salesRevenue = @json($salesRevenue);
        const topProducts = @json($topProducts);
        const years = @json($years);
        const salesRevenueSecondary = @json($salesRevenueSecondary);

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
            createTopProductsChart(productsForYear);

            createRevenueChart(year);
        }

        // Function to create Top Products Bar Chart
        function createTopProductsChart(products) {
            const productNames = products.map(product => product.nama_produk);
            const orderFrequencies = products.map(product => product.order_frequencies);

            const chartData = {
                labels: productNames,
                datasets: [{
                    label: 'Order Frequency',
                    data: orderFrequencies,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            // Destroy existing chart if it exists
            if (window.topProductsChart instanceof Chart) {
                window.topProductsChart.destroy();
            }

            // Create new bar chart
            const ctx = document.getElementById('top-products-chart').getContext('2d');
            window.topProductsChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 5 Products by Order Frequency'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' orders';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Function to create revenue chart
        function createRevenueChart(year) {
            const monthNames = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];

            // Prepare chart data
            const monthlyData = salesRevenueSecondary[year];
            const chartData = {
                labels: monthNames,
                datasets: [{
                    label: `Revenue ${year}`,
                    data: monthNames.map((_, index) => {
                        const monthKey = String(index + 1).padStart(2, '0');
                        return parseFloat(monthlyData[monthKey] || 0);
                    }),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: false
                }]
            };

            // Destroy existing chart if it exists
            if (window.revenueChart instanceof Chart) {
                window.revenueChart.destroy();
            }

            // Create new chart
            const ctx = document.getElementById('revenue-chart').getContext('2d');
            window.revenueChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Monthly Revenue - ${year}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Rp. ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
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
    <style>
        .chart-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .recent-orders {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-orders th,
        .recent-orders td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .recent-orders th {
            background-color: #f8f9fa;
        }
    </style>
</body>

</html>