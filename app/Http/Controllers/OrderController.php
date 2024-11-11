<?php

namespace App\Http\Controllers;

use App\Helpers\ResiHelper;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

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
            'customer_id' => 'required|integer',
            'total' => 'required|numeric',
            'product_id' => 'required|integer',
            'destination_address' => 'required|string',
        ]);

        $customer = Customer::where('id', $request['customer_id'])->firstOrFail();
        $userId = $customer->user_id;
        $product = Product::where('id', $request['product_id'])->firstOrFail();


        $order = Order::create([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'total' => $request->total,
            'date' => Date::now(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'destination_address' => $request->destination_address
        ]);

        $noResi = ResiHelper::generateResiNumber();
        while (Shipping::where('no_resi', $noResi)->exists()) {
            $noResi = ResiHelper::generateResiNumber();
        }
        Shipping::create([
            'order_id' => $order->id,
            'shipping_status' => 'In-Process',
            'shipping_current_location' => 'Surabaya',
            'address' => $order->destination_address,
            'no_resi' => $noResi
        ]);


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
            'customer_id' => 'required|integer',
            'total' => 'required|numeric',
            'product_id' => 'required|integer',
            'destination_address' => 'required|string', // Added to match store validation
        ]);

        $customer = Customer::where('id', $request['customer_id'])->firstOrFail();
        $userId = $customer->user_id;
        $product = Product::where('id', $request['product_id'])->firstOrFail();

        $order->update([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'total' => $request->total,
            'date' => Date::now(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'destination_address' => $request->destination_address // Added to match store fields
        ]);

        // Update the associated shipping address if it exists
        if ($order->shipping) {
            $order->shipping->update([
                'address' => $request->destination_address
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function newOrderByCustomer(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'product_id' => 'required|integer',
            'destination_address' => 'required|string',
        ]);

        $userId = Auth::id();
        Log::info($userId);
        $customer = Customer::where('user_id', $userId)->firstOrFail();
        $userId = $customer->user_id;
        $product = Product::where('id', $request['product_id'])->firstOrFail();

        $order = Order::create([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'total' => $request->total,
            'date' => Date::now(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'destination_address' => $request->destination_address
        ]);

        $noResi = ResiHelper::generateResiNumber();
        while (Shipping::where('no_resi', $noResi)->exists()) {
            $noResi = ResiHelper::generateResiNumber();
        }

        Shipping::create([
            'order_id' => $order->id,
            'shipping_status' => 'In-Process',
            'shipping_current_location' => 'Surabaya',
            'address' => $order->destination_address,
            'no_resi' => $noResi
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function getMyOrders()
    {
        $userId = Auth::id();

        $myOrders = Order::where('user_id', $userId)->get();

        foreach ($myOrders as $order) {
            $shipping = Shipping::where('order_id', $order->id)->first();
            $order->no_resi = $shipping;
        }

        return response()->json([
            'message' => 'Success fetching',
            'orders' => $myOrders
        ]);
        // Ganti redirect()->route(//customer.order.index page)->with(//messagenya apa)
    }
}
