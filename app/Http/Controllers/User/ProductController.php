<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Halaman produk (semua / filter kategori / sort)
     */
    public function index(Request $request)
    {
        // 🔹 Ambil kategori (untuk button filter)
        $categories = Category::withCount('products')
            ->latest()
            ->get();

        // 🔹 Query produk
        $products = Product::with('category');

        // 🔹 Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $products->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // 🔹 Filter berdasarkan kategori
        if ($request->filled('category')) {
            $products->where('category_id', $request->category);
        }

        // 🔹 Sorting harga
        if ($request->sort === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $products->orderBy('price', 'desc');
        } else {
            $products->latest();
        }

        return view('user.products.index', [
            'categories' => $categories,
            'products'   => $products->get(),
        ]);
    }

    /**
     * Detail produk
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // 🔹 Produk terkait (kategori sama)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('user.products.show', [
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
