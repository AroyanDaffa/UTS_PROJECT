<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('dashboard.supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required',
            'supplier_email' => 'required|email|unique:suppliers,email',
            'supplier_phone' => 'required',
        ]);
    
        Supplier::create([
            'name' => $request->supplier_name,
            'email' => $request->supplier_email,
            'phone' => $request->supplier_phone,
        ]);
    
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }
    
}
