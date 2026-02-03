<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // proteksi user (tanpa kernel)
        if (!auth()->check()) {
            return redirect('/login');
        }

        $role = strtolower(trim((string) (auth()->user()->role ?? '')));
        if ($role !== 'customer' && $role !== 'user') {
            return redirect('/admin/dashboard');
        }

        $categories = Category::all();
        $products   = Product::where('is_active', true)
            ->latest()
            ->limit(6)
            ->get();

        return view('user.dashboard', compact('categories', 'products'));
    }
}
