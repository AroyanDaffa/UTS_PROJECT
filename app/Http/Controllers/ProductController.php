<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Display a listing of the products.
    public function index()
    {
        $products = Product::all();
        return view('dashboard.products.index', compact('products'));
    }

    // Show the form for creating a new product.
    public function create()
    {
        return view('products.create');
    }

    // Store a newly created product in storage.
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer', //changed, we are using category_id now
            'stock' => 'required|integer',
        ]);

        $allowedCategory = Category::where('id', $request['category_id'])->firstOrFail();
        // Log::info($allowedCategory);
        $categoryName = $allowedCategory->name;

        // Create a new product
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'category_name' => $categoryName
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Display the specified product.
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product.
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage.
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $allowedCategory = Category::where('id', $request['category_id'])->firstOrFail();
        // Log::info($allowedCategory);
        $categoryName = $allowedCategory->name;

        // Find the product and update its details
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'category_name' => $categoryName
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage.
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function indexForCustomer()
    {
        $products = Product::all();

        return response()->json($products);
    }
}
