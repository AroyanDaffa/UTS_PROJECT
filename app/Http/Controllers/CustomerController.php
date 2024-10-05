<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('dashboard.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('dashboard.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'orders' => 'nullable|integer', 
            'last_order' => 'nullable|date',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer successfully created.');
    }

    public function edit(Customer $customer)
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'orders' => 'required|integer',
            'last_order' => 'nullable|date',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer successfully updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer successfully deleted.');
    }
}
