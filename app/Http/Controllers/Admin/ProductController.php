<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Product::with('category');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }
        
        $products = $query->latest()->get();
        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::where('is_active', 1)->get();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        // SIMPAN GAMBAR
        $imagePath = $request->file('image')->store('products', 'public');

        // SIMPAN DATA PRODUK
        Product::create([
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::where('is_active', 1)->get();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
        ];

        // JIKA UPDATE GAMBAR
        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // hapus gambar
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
