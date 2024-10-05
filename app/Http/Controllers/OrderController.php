<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('dashboard.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'total' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'total' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}