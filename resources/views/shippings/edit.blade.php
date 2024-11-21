@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Shipping</h2>
    <form action="{{ route('shippings.update', $shipping->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Shipping Status</label>
            <input type="text" name="shipping_status" class="form-control" value="{{ $shipping->shipping_status }}" required>
        </div>

        <div class="form-group">
            <label>Current Location</label>
            <input type="text" name="shipping_current_location" class="form-control" value="{{ $shipping->shipping_current_location }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Shipping</button>
    </form>
</div>
@endsection