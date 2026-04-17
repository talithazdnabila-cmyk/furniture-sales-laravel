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
    .table {
        font-size: 14px;
    }
    .table thead th {
        background-color: #fcfcfc;
        text-transform: uppercase;
        font-size: 12px;
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

    /* Filter Form Styling */
    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #333;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: var(--zada-gold);
        box-shadow: 0 0 0 0.2rem rgba(232, 184, 109, 0.25);
    }

    .btn-primary {
        background: var(--zada-gold);
        border: none;
        color: #111;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 20px;
        border-radius: 8px;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        background: #d9a856;
        color: #111;
    }

    .btn-secondary {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        color: #111;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 20px;
        border-radius: 8px;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: #111;
        border-color: #ccc;
    }

    /* Filter Form Print */
    @media print {
        .filter-form-card,
        form {
            display: none !important;
        }
    }

    /* CSS KHUSUS PRINT */
    @media print {
        /* Sembunyikan elemen yang tidak perlu dicetak */
        .main-header, 
        .sidebar, 
        .navbar, 
        footer, 
        .btn-print,
        .d-flex {
            display: none !important;
        }

        /* Reset container untuk print */
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }

        body {
            background: white !important;
            margin: 0;
            padding: 8px;
            font-size: 11px;
        }

        /* Header cetak */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 1px solid #111;
            padding-bottom: 8px;
        }

        .print-header h1 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 3px 0;
            letter-spacing: 0.5px;
        }

        .print-header p {
            margin: 2px 0;
            font-size: 10px;
            color: #666;
        }

        /* Styling tabel untuk print */
        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 9px;
            margin-bottom: 3px;
            line-height: 1;
        }

        .table thead th {
            background-color: #f0f0f0 !important;
            border: 0.5px solid #333 !important;
            padding: 2px !important;
            font-weight: bold;
            font-size: 9px !important;
            white-space: nowrap;
            overflow: hidden;
            word-break: break-word;
        }

        .table thead th:nth-child(1) { width: 6%; }
        .table thead th:nth-child(2) { width: 30%; }
        .table thead th:nth-child(3) { width: 22%; }
        .table thead th:nth-child(4) { width: 42%; }

        .table tbody td {
            border: 0.5px solid #ddd !important;
            padding: 1px !important;
            word-break: break-word;
            vertical-align: top;
            font-size: 9px !important;
        }

        .table tbody td:nth-child(1) { width: 6%; text-align: center; }
        .table tbody td:nth-child(2) { width: 30%; }
        .table tbody td:nth-child(3) { width: 22%; }
        .table tbody td:nth-child(4) { width: 42%; text-align: right; }

        .table tbody tr {
            page-break-inside: avoid;
        }

        .table tfoot tr {
            background-color: #f0f0f0 !important;
            font-weight: bold;
        }

        .table tfoot td {
            border: 0.5px solid #333 !important;
            padding: 3px !important;
            font-size: 7px;
        }

        /* Stat card cetak */
        .stat-card {
            page-break-inside: avoid;
            border: 0.5px solid #333 !important;
            margin-bottom: 8px !important;
            padding: 10px !important;
            display: inline-block;
            width: 32%;
            margin-right: 1%;
        }

        .stat-card .label {
            font-size: 9px;
        }

        .stat-card .value {
            font-size: 16px;
            font-weight: bold;
        }

        .card-luxury {
            box-shadow: none !important;
            border: 0.5px solid #333 !important;
        }

        /* Shadow dan efek visual */
        .shadow-sm {
            box-shadow: none !important;
        }

        /* Badge styling */
        .badge {
            border: 0.5px solid #333 !important;
            font-size: 8px;
        }

        /* Text color untuk print */
        a {
            color: #111 !important;
            text-decoration: none;
        }

        /* Print footer info */
        .print-footer {
            display: block !important;
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 0.5px solid #ddd;
            font-size: 8px;
            color: #666;
        }

        /* Table responsive untuk print */
        .table-responsive {
            overflow: visible !important;
        }

        /* Row sizing untuk print */
        .row {
            page-break-inside: avoid;
        }

        /* Text sizing untuk print */
        .page-title,
        .text-muted,
        h3 {
            display: none !important;
        }

        /* Margin dan padding */
        .mb-4 {
            margin-bottom: 5px !important;
        }

        /* Ensure content fits on page */
        * {
            orphans: 2;
            widows: 2;
        }
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

    <!-- Filter Form -->
    <div class="card card-luxury shadow-sm mb-4 filter-form-card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3 filter-form">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                        value="{{ $startDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Hingga Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                        value="{{ $endDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Header untuk Print -->
    <div class="print-header" style="display: none;">
        <h1>ZADA.CO</h1>
        <p style="margin: 5px 0; font-size: 12px;">LAPORAN PENJUALAN HARIAN</p>
        @if($startDate && $endDate)
            <p style="margin: 5px 0; font-size: 11px; color: #888;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        @endif
        <p style="margin: 5px 0; font-size: 11px; color: #888;">Dicetak pada: {{ date('d F Y H:i') }}</p>
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
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $trx->kode_transaksi ?? 'TRX-'.strtoupper(Str::random(5)) }}</td>
                                <td class="text-end">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
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

    <!-- Footer untuk Print -->
    <div class="print-footer" style="display: none;">
        <p style="margin: 10px 0; font-size: 11px;">Laporan ini adalah dokumen resmi dari ZADA.CO</p>
        <p style="margin: 0;">© 2024 ZADA.CO - All Rights Reserved</p>
    </div>
</div>

@endsection