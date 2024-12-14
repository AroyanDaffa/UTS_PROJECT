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
                <th>Order ID</th>
                <th>No. Resi</th>
                <th>Shipping Status</th>
                <th>Current Location</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippings as $shipping)
            <tr>
                <td>{{ $shipping->order_id }}</td>
                <td>{{ $shipping->no_resi }}</td>
                <td>{{ $shipping->shipping_status }}</td>
                <td>{{ $shipping->shipping_current_location }}</td>
                <td>{{ $shipping->address }}</td>
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