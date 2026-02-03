<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk grafik (12 bulan terakhir)
        $grafikPenjualan = Transaction::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('SUM(grand_total) as total_penjualan')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

        // Buat array untuk semua bulan dari 12 bulan terakhir
        $labelBulan = [];
        $dataPenjualan = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labelBulan[] = $date->format('F');
            
            // Cari data untuk bulan ini
            $dataMonth = $grafikPenjualan->filter(function ($item) use ($date) {
                return $item->bulan == $date->month && $item->tahun == $date->year;
            })->first();
            
            $dataPenjualan[] = $dataMonth ? $dataMonth->total_penjualan : 0;
        }

        // Produk paling laris (berdasarkan qty terjual)
        $produkPopuler = DetailTransaksi::select('product_id', DB::raw('SUM(qty) as total_terjual'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_terjual', 'desc')
            ->take(3)
            ->get()
            ->map(function ($detail) {
                return (object) [
                    'name' => optional($detail->product)->name ?? 'Unknown',
                    'total_terjual' => $detail->total_terjual
                ];
            });

        return view('admin.dashboard', [
            'totalProduk' => Product::count(),

            'stokMenipis' => Product::where('stock', '<=', 5)->count(),

            'totalTransaksi' => Transaction::count(),

            'totalPelanggan' => User::whereIn('role', ['customer', 'user'])->count(),

            'transaksiTerbaru' => Transaction::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),

            'produkPopuler' => $produkPopuler,

            // data untuk chart
            'labelBulan' => $labelBulan,
            'dataPenjualan' => $dataPenjualan
        ]);
    }
}
