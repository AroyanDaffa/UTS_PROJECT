@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text"><strong>Price:</strong> {{ $product->price }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $product->category_id }}</p>
            <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Product List</a>
        </div>
    </div>
</div>
@endsection