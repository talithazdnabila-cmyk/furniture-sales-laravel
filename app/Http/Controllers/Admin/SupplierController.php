<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('admin.suppliers.index', compact('suppliers'));
    }
    public function create()
    {
        return view('admin.suppliers.create');
    }

        public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
    ]);

    $supplier->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
    ]);

    return redirect()
        ->route('admin.suppliers.index')
        ->with('success', 'Supplier berhasil diperbarui');
}

public function destroy(Supplier $supplier)
{
    $supplier->delete();

    return redirect()
        ->route('admin.suppliers.index')
        ->with('success', 'Supplier berhasil dihapus');
}

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);
        Supplier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }
}
