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
        </div>
    </section>

    <!-- Main Content Section -->
    <section id="main-content">
        <!-- Header Section -->
        <header class="sticky-header">
            <div class="search">
                <i class='bx bx-search-alt-2'></i>
                <input type="text" placeholder="Search">
            </div>
            
            <div class="user-profile">
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
                <i class='bx bxs-bell'></i>
                <img src="{{ asset('images/admin.png') }}" alt="User Profile">
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </header>

        <!-- Dashboard Overview Section -->
        <div class="dashboard-overview">
            <h1>Welcome, Admin</h1>
            <!-- Overview Cards Section -->
            <div class="overview-cards">
                <div class="overview-card">
                    <i class='bx bx-money-withdraw'></i>
                    <h3>Total Revenue</h3>
                    <p id="revenue-value">0</p>
                    <p id="growth-value" style="font-size: 0.9rem; color: #555;">Growth: 0%</p>
                </div>
                <div class="overview-card">
                    <i class='bx bxs-box'></i>
                    <h3>Total Stocks</h3>
                    <p id="stock-value">0</p>
                </div>
                <div class="overview-card">
                    <i class='bx bxs-truck' ></i>
                    <h3>Total Shippings</h3>
                    <p id="shipping-value">0</p>
                </div>
            </div>
        </div>



        <!-- Dashboard box -->
        <!-- Remove the Bootstrap classes -->
         <!-- Dashboard Box -->
          <div class="chart-box">
            <div class="chart-container">
                <h2>Monthly Revenue Trend</h2>
                <canvas id="revenue-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Top 5 Products</h2>
                <canvas id="top-products-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Quarterly Revenue</h2>
                <canvas id="quarterly-sales-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Low Stock Products</h2>
                <canvas id="low-stock-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Category Stock Distribution</h2>
                <canvas id="category-stock-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Category Stock Distribution</h2>
                <canvas id="inventory-stock-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Shipping Duration Comparison</h2>
                <canvas id="shipping-duration-chart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Top Shipping Locations</h2>
                <canvas id="top-locations-chart"></canvas>
            </div>
          </div>


        
        
    </section>

    <script>
        console.log(@JSON($years));
        console.log(@JSON($salesRevenue));
        console.log(@JSON($topProducts));
        console.log(@JSON($salesRevenueSecondary));
        console.log(@JSON($salesRevenueQ));
        console.log(@JSON($inventoryStock));
        console.log(@JSON($topLowStockProducts));
        console.log(@JSON($categoryStock));
        console.log(@JSON($totalShipping));
        console.log(@JSON($avgExpressStandard));
        console.log(@JSON($topShippingLocations));

        // Predefined data from the backend
        const years = @json($years);
        const salesRevenue = @json($salesRevenue);
        const topProducts = @json($topProducts);
        const salesRevenueSecondary = @json($salesRevenueSecondary);
        const salesRevenueQuarterly = @json($salesRevenueQ);
        const inventoryStock = @json($inventoryStock);
        const topLowStockProducts = @json($topLowStockProducts);
        const categoryStock = @json($categoryStock);
        const totalShipping = @json($totalShipping);
        const avgExpressStandard = @json($avgExpressStandard);
        const topShippingLocations = @json($topShippingLocations);

        // Get references to DOM elements
        const yearSelect = document.getElementById('year-select');
        const revenueValue = document.getElementById('revenue-value');
        const stockValue = document.getElementById('stock-value');
        const shippingValue = document.getElementById('shipping-value');

        // Function to update dashboard based on selected year
        function updateDashboard(year) {
            // Update Revenue
            const revenueData = salesRevenue[year] || {
                revenue: '0',
                growth: 0
            };
            const formattedRevenue = 'Rp. ' + new Intl.NumberFormat('id-ID').format(revenueData.revenue);
            const growthPercentage = revenueData.growth.toFixed(2) + '%';

            revenueValue.textContent = formattedRevenue;

            // Update Growth Percentage
            const growthValue = document.getElementById('growth-value');
            growthValue.textContent = `${growthPercentage}`;
            growthValue.style.color = revenueData.growth >= 0 ? 'green' : 'red';

            // Update Top Products
            const productsForYear = topProducts[year];
            createTopProductsChart(productsForYear);

            // Update Monthly Revenue Chart
            createRevenueChartMonthly(year);

            // Update Total Stock
            const stockData = inventoryStock[year] || 0;
            stockValue.textContent = new Intl.NumberFormat('id-ID').format(stockData);

            // Update Total Shipping
            const shippingData = totalShipping[year] || 0;
            shippingValue.textContent = new Intl.NumberFormat('id-ID').format(shippingData);

            createQuarterlySalesChart(salesRevenueQuarterly, year);

            createInventoryStockChart(inventoryStock, year);

            createLowStockChart(topLowStockProducts, year);

            createCategoryStockChart(categoryStock, year);

            createShippingDurationChart(avgExpressStandard, year);

            createTopLocationsChart(topShippingLocations, year);
    

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
                    backgroundColor: ' #3b82f6',
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
        function createRevenueChartMonthly(year) {
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
                    borderColor: ' #3b82f6',
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

        // Quarterly Chart
        function createQuarterlySalesChart(salesRevenueQ, year){
            const quarters = [1, 2, 3, 4];    // Define the quarters
            const revenueDataQuarter = salesRevenueQ[year]?.map(item => parseFloat(item.total_revenue)) || [0, 0, 0, 0];
            
            const chartData = {
                labels: quarters.map(q => `Q${q}`),
                datasets: [{
                    label: `Year ${year}`,
                    data: revenueDataQuarter,
                    backgroundColor: '#3b82f6',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            if (window.quarterlySalesChart instanceof Chart) {
                window.quarterlySalesChart.destroy();
            }

            const ctx = document.getElementById('quarterly-sales-chart').getContext('2d');
            window.quarterlySalesChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Quarterly Sales Revenue ${year}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'IDR ' + context.parsed.y.toLocaleString('id-ID') + ' Revenue';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'IDR ' + value.toLocaleString('id-ID');
                                },
                                stepSize: 1000000
                            },
                            title: {
                                display: true,
                                text: 'Revenue (IDR)'
                            }
                        }
                    }
                }
            });
        }


        function createInventoryStockChart(inventoryStock, year) {
            const stockValue = inventoryStock[year] || 0;

            const chartData = {
                labels: [`${year}`],
                datasets: [{
                    label: 'Total Stock',
                    data: [stockValue],
                    backgroundColor: '#3b82f6', // Using your existing blue theme
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            if (window.inventoryStockChart instanceof Chart) {
                window.inventoryStockChart.destroy();
            }

            const ctx = document.getElementById('inventory-stock-chart').getContext('2d');
            window.inventoryStockChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Total Inventory Stock by Year'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toLocaleString('id-ID') + ' units';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            },
                            title: {
                                display: true,
                                 text: 'Stock Units'
                            }
                        }
                    }
                }
            });
        }


        function createLowStockChart(topLowStockProducts, year) {
            // Get data for selected year
            const products = topLowStockProducts[year] || [];

            // Extract product names and stock values
            const productNames = products.map(product => product.nama_produk);
            const stockValues = products.map(product => product.total_stock);
            const chartData = {
                labels: productNames,
                datasets: [{
                    label: 'Stock Level',
                    data: stockValues,
                    backgroundColor: '#ef4444',  // Red color for warning indication
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }]
            };
            if (window.lowStockChart instanceof Chart) {
                window.lowStockChart.destroy();
            }
            const ctx = document.getElementById('low-stock-chart').getContext('2d');
            window.lowStockChart = new Chart(ctx, {
                type: 'bar',
                
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Top 5 Low Stock Products ${year}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Stock: ${context.parsed.y.toLocaleString('id-ID')} units`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,

                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Stock Units'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            bottom: 25  // Add padding for rotated labels
                            }
                        }
                    }
            });
        }


        // Function to generate random RGBA colors
        function generateRandomColors(count, alpha = 1) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);  // Semi-transparent
                }
                return colors;
            }

        function createCategoryStockChart(categoryStock, year) {
            // Get data for selected year
            const categories = categoryStock[year] || [];
            // Extract category names and stock values
            const categoryNames = categories.map(category => category.nama_kategori);
            const stockValues = categories.map(category => category.total_stock);

            // Generate dynamic colors based on the number of categories
            const backgroundColors = generateRandomColors(categories.length, 0.7);
            const borderColors = backgroundColors.map(color => color.replace('0.7', '1'));

            const chartData = {
                labels: categoryNames,
                datasets: [{
                    data: stockValues,
                    backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                };
                if (window.categoryStockChart instanceof Chart) {
                    window.categoryStockChart.destroy();
                }
                const ctx = document.getElementById('category-stock-chart').getContext('2d');
                window.categoryStockChart = new Chart(ctx, {
                    type: 'pie',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: `Stock Distribution by Category ${year}`
                            },
                            legend: {
                                position: 'right',
                                labels: {
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.raw;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${context.label}: ${value.toLocaleString('id-ID')} units (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }


        
        // Function to create shipping

        function createShippingDurationChart(avgExpressStandard, year) {
            const months = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            // Prepare data for each shipping method
            const expressData = [];
            const standardData = [];
            for (let i = 1; i <= 12; i++) {
                const monthStr = String(i).padStart(2, '0');
                const monthData = avgExpressStandard[year][monthStr];expressData.push(monthData.express);
                standardData.push(monthData.standard);
            }
            const chartData = {
                labels: months,
                datasets: [{
                    label: 'Express Shipping',
                    data: expressData,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                },
                {
                    label: 'Standard Shipping',
                    data: standardData,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            };
            // Destroy existing chart if it exists
            if (window.shippingDurationChart instanceof Chart) {
                window.shippingDurationChart.destroy();
            }
            const ctx = document.getElementById('shipping-duration-chart').getContext('2d');
            window.shippingDurationChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Average Shipping Duration ${year}`
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y.toFixed(1)} days`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Days'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(1) + ' days';
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }
       
        // top shipping location\
        function createTopLocationsChart(topShippingLocations, year) {
            // Get data for selected year
            const locations = topShippingLocations[year] || [];
            // Extract location names and shipping counts
            const locationNames = locations.map(item => item.nama_lokasi);const shippingCounts = locations.map(item => item.shipping_count);const chartData = {
                labels: locationNames,
                datasets: [{
                    label: 'Number of Shipments',
                    data: shippingCounts,
                    backgroundColor: '#3b82f6',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };
            if (window.topLocationsChart instanceof Chart) {
                window.topLocationsChart.destroy();
            }
            const ctx = document.getElementById('top-locations-chart').getContext('2d');
            window.topLocationsChart = new Chart(ctx, {
                type: 'bar',
                indexAxis: 'y',  // Makes the bars horizontal
                data: chartData,
                options: {
                    responsive: true,
               
                    plugins: {
                        title: {
                            display: true,
                            text: `Top Shipping Locations ${year}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const locationName = context.label; // Location name
                                    const shipmentCount = context.parsed.y; // Shipment count
                                    return `${locationName}: ${shipmentCount.toLocaleString('id-ID')} shipments`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Location' // X-axis title
                            },
                            ticks: {
                                autoSkip: false, // Prevent skipping location names
                                maxRotation: 45, // Rotate labels for readability
                                minRotation: 45
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Shipments' // Y-axis title
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
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
    </style>
</body>

</html>