@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Product Price:</label>
            <input type="number" class="form-control" name="price" value="{{ $product->price }}" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" name="category_id" value="{{ $product->category_id }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection