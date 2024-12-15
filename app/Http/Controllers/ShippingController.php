<?php

namespace App\Http\Controllers;

use App\Helpers\ResiHelper;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index()
    {
        //TODO: integrate oltp with olap
        // $shippings = Shipping::all();
        $shippings = DB::connection('olap')->table('fix_shipping_updated')->get();
        return view('shippings.index', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'shipping_status' => 'required|string',
            'shipping_current_location' => 'required|string',
            'address' => 'required|string',
        ]);

        $order = Order::where('id', $request['order_id'])->firstOrFail();

        $noResi = ResiHelper::generateResiNumber();
        while (Shipping::where('no_resi', $noResi)->exists()) {
            $noResi = ResiHelper::generateResiNumber();
        }

        Shipping::create([
            'order_id' => $order->id,
            'no_resi' => $noResi,
            'shipping_status' => $request['shipping_status'],
            'shippping_current_location' => $request['shippping_current_location'],
            'address' => $request['address']
        ]);

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
            'shipping_status' => 'required|string',
            'shipping_current_location' => 'required|string'
        ]);

        $shipping->update([
            'shipping_status' => $request->shipping_status,
            'shipping_current_location' => $request->shipping_current_location
        ]);

        return redirect()->route('shippings.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return redirect()->route('shippings.index')->with('success', 'Pengiriman berhasil dihapus.');
    }
}
