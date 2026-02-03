<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    // ===============================
    // SEMUA TRANSAKSI
    // ===============================
    public function index()
    {
        $transaksis = Transaction::latest()->get();
        return view('admin.transaction.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaction::with('details.product')->findOrFail($id);
        return view('admin.transaction.show', compact('transaksi'));
    }

    // ===============================
    // TRANSAKSI MASUK (FORM INPUT)
    // ===============================
    public function create()
    {
        $transaksiPending = Transaction::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.transaction.konfirmasi', compact('transaksiPending'));
    }

    public function transaksiMasuk()
    {
        // Mengambil transaksi dari user yang belum dikonfirmasi
        $transaksi = Transaction::where('status', 'pending')->orderBy('created_at', 'desc')->get(); 
        return view('admin.transaction.masuk', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'total'   => 'required|numeric',
            'status'  => 'required|string',
        ]);

        $transaksi = Transaction::findOrFail($id);

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'total_harga'   => $request->total,
            'status'  => $request->status,
        ]);

        return redirect()
            ->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    public function konfirmasi($id)
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->status = 'lunas';
        $transaksi->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi');
    }

    public function tolak($id)
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->status = 'ditolak';
        $transaksi->save();

        return redirect()->back()->with('success', 'Transaksi berhasil ditolak');
    }
    // ===============================
    // SIMPAN TRANSAKSI
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:100',
            'produk_id'    => 'required|array',
            'produk_id.*'  => 'exists:products,id',
            'qty'          => 'required|array',
            'qty.*'        => 'integer|min:1',
        ]);

        // ===============================
        // SIMPAN TRANSAKSI UTAMA
        // ===============================
        $transaksi = Transaction::create([
            'kode_transaksi' => 'TRX-' . time(),
            'tanggal'        => now(),
            'nama_pembeli'   => $request->nama_pembeli,
            'total_harga'    => 0,
            'status'         => 'pending', // 🔥 transaksi masuk = pending
        ]);

        $total = 0;

        // ===============================
        // SIMPAN DETAIL TRANSAKSI
        // ===============================
        foreach ($request->produk_id as $i => $produkId) {

            $produk = Product::findOrFail($produkId);
            $qty    = $request->qty[$i];
            $subtotal = $produk->price * $qty;

            DetailTransaksi::create([
                'transaction_id' => $transaksi->id,
                'product_id'     => $produkId,
                'qty'            => $qty,
                'price'          => $produk->price,
                'subtotal'       => $subtotal,
            ]);

            // kurangi stok produk
            $produk->decrement('stock', $qty);

            $total += $subtotal;
        }

        // ===============================
        // UPDATE TOTAL HARGA
        // ===============================
        $transaksi->update([
            'total_harga' => $total,
        ]);

        return redirect()
            ->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan');
    }
}
