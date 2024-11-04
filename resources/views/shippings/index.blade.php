@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shipping Management</h2>
    <a href="{{ route('shippings.create') }}" class="btn btn-primary mb-3">Add New Shipping</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Shipping Status</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippings as $shipping)
            <tr>
                <td>{{ $shipping->id }}</td>
                <td>{{ $shipping->customer_name }}</td>
                <td>{{ $shipping->shipping_status }}</td>
                <td>{{ $shipping->address }}</td>
                <td>
                    <a href="{{ route('shippings.show', $shipping->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('shipping.edit', $shipping->id) }}">Edit</a>
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
