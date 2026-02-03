<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\DetailTransaksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Halaman form checkout
     */
    public function showCheckout()
    {
        if (!session()->has('checkout')) {
            return redirect()->route('user.products')
                ->with('error', 'Silakan pilih produk terlebih dahulu');
        }

        $checkout = session('checkout');
        $product = Product::findOrFail($checkout['product_id']);

        return view('user.checkout.index', compact('product', 'checkout'));
    }

    /**
     * List transaksi user
     */
 public function index()
{
    $transactions = Transaction::with('details.product')
        ->where('nama_pembeli', Auth::user()->name)
        ->orderBy('created_at', 'desc')
        ->get();

    // Ubah menjadi JAMAK (pakai 's') agar sinkron dengan route & folder
    return view('user.transactions.index', compact('transactions'));
}

    /**
     * Simpan data checkout ke session
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->qty > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        session([
            'checkout' => [
                'product_id' => $product->id,
                'qty'        => $request->qty,
            ]
        ]);

        return redirect()->route('user.checkout.index');
    }

    /**
     * Simpan transaksi user
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'qty'           => 'required|integer|min:1',
            'nama_penerima' => 'required|string',
            'no_telepon'    => 'required|string',
            'alamat'        => 'required|string',
            'catatan'       => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        if ($qty > $product->stock) {
            return redirect()->route('user.products')
                ->with('error', 'Stok tidak mencukupi');
        }

        $total = $product->price * $qty;

        $transaction = Transaction::create([
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'tanggal'        => now(),
            'nama_pembeli'   => Auth::user()->name,
            'nama_penerima'  => $request->nama_penerima,
            'no_telepon'     => $request->no_telepon,
            'alamat'         => $request->alamat,
            'catatan'        => $request->catatan ?? null,
            'total_harga'    => $total,
            'grand_total'    => $total,
            'status'         => 'pending',
        ]);

        DetailTransaksi::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => $qty,
            'harga'          => $product->price,
            'subtotal'       => $total,
        ]);

        session()->forget('checkout');

        return redirect()
            ->route('user.transactions.index')
            ->with('success', 'Pesanan berhasil dibuat, menunggu konfirmasi admin');
    }
}
