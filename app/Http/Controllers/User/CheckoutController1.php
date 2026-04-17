<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ShippingCity;

class CheckoutController1 extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function show(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        // Validasi stok
        if ($qty > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        $total = $product->price * $qty;

        // Ambil daftar kota untuk pilihan ongkir
        $cities = ShippingCity::all();

       return view('user.checkout.index', compact('product', 'checkout', 'cities'));
    }

    /**
     * Simpan transaksi (USER)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'qty'              => 'required|integer|min:1',
            'shipping_city_id' => 'required|exists:shipping_cities,id',
            'nama_penerima'    => 'required|string',
            'no_telepon'       => 'required|string',
            'alamat'           => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = $request->qty;

        if ($qty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Ambil data kota tujuan
        $city = ShippingCity::findOrFail($request->shipping_city_id);

        // Hitung biaya
        $subtotal      = $product->price * $qty;
        $shippingCost  = $city->shipping_cost;
        $grandTotal    = $subtotal + $shippingCost;

        // =========================
        // SIMPAN TRANSACTION
        // =========================
        $transaction = Transaction::create([
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'nama_pembeli'   => $request->nama_penerima,
            'tanggal'        => now(),
            'total_harga'    => $grandTotal,
            'status'         => 'pending',

            // Tambahan data pengiriman
            'alamat'         => $request->alamat,
            'no_telepon'     => $request->no_telepon,
            'city_id'        => $city->id,
            'shipping_cost'  => $shippingCost,
        ]);

        // =========================
        // SIMPAN DETAIL
        // =========================
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'qty'            => $qty,
            'harga'          => $product->price,
            'subtotal'       => $subtotal,
        ]);

        // Kurangi stok produk
        $product->stock = $product->stock - $qty;
        $product->save();

        return redirect()
            ->route('user.transactions.index')
            ->with('success', 'Pesanan berhasil dibuat. Total pembayaran: Rp ' . number_format($grandTotal, 0, ',', '.'));
    }
}
