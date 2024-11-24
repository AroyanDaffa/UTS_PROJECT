@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Product</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form to add a new product -->
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" name="category_id" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
@endsection