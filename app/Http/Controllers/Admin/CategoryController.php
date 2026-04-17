<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Category::withCount('products');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $categories = $query->get();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function showProducts($id)
{
    $category = Category::with('products')->findOrFail($id);

    return view('admin.categories.products', compact('category'));
}


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $imageName = null;

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
    }

        Category::create([
            'name' => $request->name,
            'image' => $imageName
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.categories.index') // ✅ BENAR
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
