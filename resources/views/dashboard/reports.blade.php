<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - E-commerce Logistics</title>
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
            <li><i class='bx bxs-cart'></i><a href="{{ url('/supplier') }}">Supplier</a></li>
            <li><i class='bx bxs-package'></i><a href="{{ url('/orders') }}">Orders</a></li>
            <li><i class='bx bxs-truck'></i><a href="{{ url('/shipping') }}">Shipping</a></li>
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
                <i class='bx bxs-bell'></i></i>&nbsp; &nbsp;
                <img src="{{ asset('images/admin.png') }}" alt="User Profile">
            </div>
    </header>

    <h1>Reports Management</h1>
    <div class="report-charts mb-4">
        <h3>Sales Performance</h3>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="report-charts mb-4">
        <h3>Revenue Breakdown</h3>
        <canvas id="revenueChart"></canvas>
    </div>

    <!-- Option to filter reports -->
    <form action="#" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="fromDate" class="form-label">From Date</label>
                <input type="date" class="form-control" id="fromDate">
            </div>
            <div class="col-md-4">
                <label for="toDate" class="form-label">To Date</label>
                <input type="date" class="form-control" id="toDate">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter Reports</button>
            </div>
        </div>
    </form>

    <!-- Table to display detailed reports -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Orders</th>
                <th>Revenue</th>
                <th>Average Order Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01/10/2024</td>
                <td>50</td>
                <td>Rp. 2,500,000</td>
                <td>Rp. 50,000</td>
            </tr>
            <tr>
                <td>29/09/2024</td>
                <td>75</td>
                <td>Rp. 3,750,000</td>
                <td>Rp. 50,000</td>
            </tr>
        </tbody>
    </table>
</section>

<!-- Adding chart.js for graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Performance Chart
    var salesCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Sales',
                data: [1000, 1200, 1500, 1700, 1300, 1600],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Breakdown Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Revenue',
                data: [5000, 7000, 8000, 6000, 9000, 8500],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>