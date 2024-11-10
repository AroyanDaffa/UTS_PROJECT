<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|integer',
    //     ]);

    //     $user = User::where('id', $request['user_id'])->firstOrFail();
    //     $userId = $user->id;
    //     $userEmail = $user->email;
    //     $userName = $user->name;

    //     $allUserOrders = Order::where('user_id', $userId)->count(); //Consider to return all orders instead of just counting it
    //     $latestOrder = Order::where('user_id', $userId)->orderBy('date', 'desc')->first()->date;

    //     Customer::create([
    //         'user_id' => $userId,
    //         'customer_name' => $userName,
    //         'customer_email' => $userEmail,
    //         'orders' => $allUserOrders,
    //         'last_order' => $latestOrder
    //     ]);

    //     return redirect()->route('customers.index')->with('success', 'Customer successfully created.');
    // }

    // public function edit(Customer $customer)
    // {
    //     return view('dashboard.customers.create', compact('customer'));
    // }

    // public function update(Request $request, Customer $customer)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:customers,email,' . $customer->id,
    //         'orders' => 'required|integer',
    //         'last_order' => 'nullable|date',
    //     ]);

    //     $customer->update($request->all());

    //     return redirect()->route('customers.index')->with('success', 'Customer successfully updated.');
    // }

    // public function destroy(Customer $customer)
    // {
    //     $customer->delete();

    //     return redirect()->route('customers.index')->with('success', 'Customer successfully deleted.');
    // }
}
