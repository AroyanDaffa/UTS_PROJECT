<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::all();
        return view('shippings.index', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'shipping_status' => 'required',
            'address' => 'required',
        ]);

        Shipping::create($request->all());

        return redirect()->route('shippings.index')->with('success', 'Pengiriman berhasil ditambahkan.');
    }
    public function show(Shipping $shipping)
    {
        return view('shippings.show', compact('shipping'));
    }
    
    public function edit(Shipping $shipping)
{
    // Jika Anda ingin mendapatkan semua data Shipping, bisa dilakukan seperti ini
    $shippings = Shipping::all();
    
    return view('shippings.edit', compact('shipping', 'shippings'));
}

    public function update(Request $request, Shipping $shipping)
    {
        $request->validate([
            'customer_name' => 'required',
            'shipping_status' => 'required',
            'address' => 'required',
        ]);

        $shipping->update($request->all());

        return redirect()->route('shippings.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return redirect()->route('shippings.index')->with('success', 'Pengiriman berhasil dihapus.');
    }
}
