<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController1 extends Controller
{
    /**
     * Tampilkan halaman checkout
     */

     public function index(Request $request)
    {
        
         $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        // VALIDASI STOK
        // if ($qty > $product->stock) {
        //     return back()->with('error', 'Jumlah melebihi stok tersedia');
        // }

        // $total = $product->price * $qty;
      
    }
    public function show(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        // VALIDASI STOK
        if ($qty > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        $total = $product->price * $qty;

        return view('user.checkout.index', compact('product', 'qty', 'total'));
    }

    /**
     * Simpan transaksi (USER)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        if ($qty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // =========================
        // SIMPAN TRANSACTION
        // =========================
        $transaction = Transaction::create([
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'nama_pembeli'   => Auth::user()->name ?? 'Pembeli',
            'tanggal'        => now(),
            'total_harga'    => $product->price * $qty,
            'status'         => 'pending',
        ]);

        // =========================
        // SIMPAN DETAIL
        // =========================
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => $qty,
            'harga'          => $product->price,
            'subtotal'       => $product->price * $qty,
        ]);

        return redirect()
            ->route('user.transactions.index')
            ->with('success', 'Pesanan berhasil dibuat, menunggu konfirmasi admin');
    }
}
