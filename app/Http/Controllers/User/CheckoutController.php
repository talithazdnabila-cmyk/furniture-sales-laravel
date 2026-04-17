<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCity;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request, $productId)
{
    $product = Product::find($productId);
    $cities = ShippingCity::all();

    $checkout = [
        'qty' => $request->qty ?? 1
    ];

    return view('user.checkout.index', compact('product', 'checkout', 'cities'));
}

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
