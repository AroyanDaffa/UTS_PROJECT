<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countAllOnDashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalOrdersPending = Shipping::where('shipping_status', 'Pending')->count();
        $totalOrdersShipped = Shipping::where('shipping_status', 'Shipped')->count();
        $totalCustomers = Customer::count();

        $totalRevenue = Order::join('products', 'orders.product_id', '=', 'products.id')
            ->selectRaw('SUM(orders.total * products.price) as total_revenue')
            ->value('total_revenue');

        return view('dashboard.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalCustomers',
            'totalOrdersPending',
            'totalOrdersShipped',
            'totalRevenue'
        ));
    }
}
