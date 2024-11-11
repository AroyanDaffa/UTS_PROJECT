<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        // Ambil semua kategori dari database
        $categories = Category::all();
        // Kirim data kategori ke view
        return view('dashboard.category', compact('categories'));
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        // Simpan kategori baru
        Category::create([
            'name' => $request->category_name,
        ]);

        // Redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Category added successfully.');
    }

    // Menampilkan form edit untuk kategori tertentu
    public function edit($id)
    {
        // Temukan kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Tampilkan view edit dengan data kategori
        return view('category.edit_category', compact('category'));
    }

    // Memperbarui data kategori
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        // Temukan kategori dan perbarui data
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->category_name,
        ]);

        // Redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    // Menghapus kategori dari database
    public function destroy($id)
    {
        // Temukan kategori berdasarkan ID dan hapus
        $category = Category::findOrFail($id);
        $category->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
