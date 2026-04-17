<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ShippingCity;

class PengirimanController extends Controller
{
    /**
     * Tampilkan daftar pengiriman
     */
    public function index()
    {
        $pengiriman = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik pengiriman
        $pending = Transaction::where('status', 'pending')->count();
        $shipped = Transaction::where('status', 'shipped')->count();
        $completed = Transaction::where('status', 'completed')->count();

        return view('admin.pengiriman.index', compact('pengiriman', 'pending', 'shipped', 'completed'));
    }

    /**
     * Tampilkan detail pengiriman
     */
    public function show($id)
    {
        $pengiriman = Transaction::with('user', 'details.product')->findOrFail($id);
        return view('admin.pengiriman.show', compact('pengiriman'));
    }

    /**
     * Update status pengiriman
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,completed'
        ]);

        $pengiriman = Transaction::findOrFail($id);
        
        // Check if transaction is still pending (not confirmed from transaksi masuk)
        if ($pengiriman->status === 'pending') {
            return redirect()->route('admin.pengiriman.index')
                ->with('error', 'Tidak dapat mengubah status pengiriman. Transaksi harus dikonfirmasi terlebih dahulu di menu Transaksi Masuk.');
        }
        
        // Check if payment proof is approved before allowing status update
        if ($pengiriman->payment_proof_status !== 'approved') {
            return redirect()->route('admin.pengiriman.index')
                ->with('error', 'Tidak dapat mengubah status pengiriman. Bukti transfer harus disetujui terlebih dahulu.');
        }
        
        $pengiriman->status = $request->status;
        $pengiriman->save();

        return redirect()->route('admin.pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui');
    }
}
