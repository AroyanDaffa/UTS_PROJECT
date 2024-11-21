@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Shipping</h2>
    <form action="{{ route('shippings.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Order ID</label>
            <input type="number" name="order_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Shipping Status</label>
            <input type="text" name="shipping_status" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Current Location</label>
            <input type="text" name="shipping_current_location" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Shipping</button>
    </form>
</div>
@endsection