@extends('layouts.admin')

@section('title', 'Laporan Penjualan - ZADA.CO')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    .page-title {
        font-weight: 800;
        letter-spacing: -1px;
        color: var(--zada-dark);
    }

    /* Stat Card Style */
    .stat-card {
        background: var(--zada-dark);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 30px;
        position: relative;
        overflow: hidden;
    }
    .stat-card .label {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.7;
        font-weight: 600;
    }
    .stat-card .value {
        font-size: 32px;
        font-weight: 800;
        margin-top: 10px;
        color: var(--zada-gold);
    }
    .stat-card i {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 120px;
        opacity: 0.1;
        transform: rotate(-15deg);
    }

    /* Table Styling */
    .card-luxury {
        border: none;
        border-radius: 15px;
        background: #fff;
        overflow: hidden;
    }
    .table thead th {
        background-color: #fcfcfc;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        font-weight: 700;
        color: #888;
        border-top: none;
        padding: 20px 15px;
    }
    .table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f8f8f8;
    }

    .font-mono {
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 600;
        color: #111;
    }

    .btn-print {
        background: #fff;
        color: var(--zada-dark);
        border: 1px solid #eee;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-print:hover {
        background: #f8f9fa;
        border-color: #ddd;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Laporan Penjualan</h3>
            <p class="text-muted small m-0">Rekapitulasi pendapatan harian ZADA.CO</p>
        </div>
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="stat-card shadow-sm">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                <i class="fas fa-sack-dollar"></i>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card shadow-sm" style="background: #fff; color: #111; border: 1px solid #eee;">
                <div class="label" style="opacity: 1; color: #888;">Jumlah Transaksi</div>
                <div class="value" style="color: #111;">{{ $transactions->count() }} <small style="font-size: 14px; color: #888;">Pesanan</small></div>
                <i class="fas fa-shopping-bag" style="color: #000; opacity: 0.05;"></i>
            </div>
        </div>
    </div>

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">#</th>
                            <th>Tanggal Transaksi</th>
                            <th>Kode TRX</th>
                            <th class="text-end">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td class="text-center text-muted font-monospace">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $trx->created_at->format('d F Y') }}</div>
                                    <small class="text-muted">{{ $trx->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $trx->kode_transaksi ?? 'TRX-'.strtoupper(Str::random(5)) }}</span>
                                </td>
                                <td class="text-end font-mono">
                                    Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-chart-line fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Belum ada data penjualan tercatat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($transactions->count() > 0)
                    <tfoot style="background: #fafafa;">
                        <tr>
                            <td colspan="3" class="text-end fw-bold py-3">GRAND TOTAL PENJUALAN</td>
                            <td class="text-end fw-800 text-success py-3" style="font-size: 16px; font-weight: 800;">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection