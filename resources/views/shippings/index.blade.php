@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shipping Management</h2>
    <a href="{{ route('shippings.create') }}" class="btn btn-primary mb-3">Add New Shipping</a>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
            <tr>
                <th>No Resi</th>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Product Name</th>
                <th>Shipping Method</th>
                <th>Address</th>
                <th>Tanggal</th>
                <th>Tanggal Selesai</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippings as $shipping)
            <tr>
                <td>{{ $shipping->no_resi }}</td>
                <td>{{ $shipping->order_id }}</td>
                <td>{{ $shipping->customer_id }}</td>
                <td>{{ $shipping->product_name }}</td>
                <td>{{ $shipping->shipping_method }}</td>
                <td>{{ $shipping->address }}</td>
                <td>{{ $shipping->tanggal }}</td>
                <td>{{ $shipping->tanggal_selesai }}</td>
                <td>
                    <a href="{{ route('shippings.show', $shipping->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('shippings.edit', $shipping->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('shippings.destroy', $shipping->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection