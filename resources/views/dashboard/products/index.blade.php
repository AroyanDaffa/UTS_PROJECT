<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product - E-commerce Logistics</title>
    <link href="{{ asset('css/style3.css') }}" rel="stylesheet" type="text/css">>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
            <li><i class='bx bxs-bar-chart-alt-2'></i><a href="reports.html">Reports</a></li>
        </div>
    </section>

    <section id="main-content">
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

        <h1>Product Management</h1>
        <form action="{{ route('products.store') }}" method="POST" class="mb-4">
    @csrf
    <div class="mb-3">
        <label for="productName" class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" id="productName" placeholder="Enter Product Name" required>
    </div>
    <div class="mb-3">
        <label for="productPrice" class="form-label">Product Price</label>
        <input type="number" name="price" class="form-control" id="productPrice" placeholder="Enter Product Price" required>
    </div>
    <div class="mb-3">
        <label for="productCategory" class="form-label">Category</label>
        <input type="text" name="category" class="form-control" id="productCategory" placeholder="Enter Product Category" required>
    </div>
    <div class="mb-3">
        <label for="productStock" class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" id="productStock" placeholder="Enter Stock Quantity" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>


        <!-- Table to display products -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

        </table>
    </section>
</body>
</html>
