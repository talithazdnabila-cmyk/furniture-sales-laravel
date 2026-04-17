<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
        
        $total = $cartItems->where('selected', true)->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $product = Product::findOrFail($request->product_id);
        $userId = Auth::id();

        // Check if product already in cart
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $cartItem = Cart::findOrFail($id);

        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);

        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan!');
    }

    /**
     * Toggle selected status for cart items
     */
    public function toggleSelected(Request $request)
    {
        $cartItem = Cart::findOrFail($request->cart_id);

        // Ensure user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->update(['selected' => $request->selected]);

        return response()->json(['success' => true]);
    }

    /**
     * Select all cart items
     */
    public function selectAll(Request $request)
    {
        $selectAll = $request->select_all === 'true';
        
        Cart::where('user_id', Auth::id())
            ->update(['selected' => $selectAll]);

        return response()->json(['success' => true]);
    }
}
