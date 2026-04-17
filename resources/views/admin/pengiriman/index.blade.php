@extends('layouts.admin')

@section('title', 'Kelola Pengiriman | ZADA')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
        --bg-light: #f8f9fa;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-light);
    }

    /* Page Title Styling */
    .page-header h3 {
        font-family: 'Playfair Display', serif;
        color: var(--zada-dark);
        letter-spacing: -0.5px;
    }

    /* Stats Card Styling */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease;
    }

    .stat-card:hover { transform: translateY(-5px); }
    .stat-card.pending { border-top: 4px solid #ffc107; }
    .stat-card.shipped { border-top: 4px solid #17a2b8; }
    .stat-card.completed { border-top: 4px solid #28a745; }

    .stat-number {
        font-size: 36px;
        font-weight: 800;
        color: var(--zada-dark);
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 11px;
        color: #999;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Table Container Styling */
    .pengiriman-container {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
    }

    .table-pengiriman thead th {
        background: #fff;
        border-bottom: 2px solid #f8f9fa;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #bbb;
        padding: 15px 20px;
    }

    .table-pengiriman tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table-pengiriman tbody tr:hover { background: #fdfaf5; }

    /* Custom Badges */
    [class^="status-badge-"] {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-badge-pending { background: #fff4e5; color: #b07219; }
    .status-badge-shipped { background: #e7f3ff; color: #0c5282; }
    .status-badge-completed { background: #e6fcf5; color: #0ca678; }

    /* Customer Avatar & Info */
    .customer-info { display: flex; align-items: center; gap: 12px; }
    .customer-avatar {
        width: 38px; height: 38px;
        border-radius: 12px;
        background: var(--zada-dark);
        color: var(--zada-gold);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 14px;
    }

    .customer-name { font-weight: 700; color: var(--zada-dark); font-size: 14px; margin-bottom: 2px; }
    .customer-phone { font-size: 12px; color: #999; }

    /* Action Button */
    .btn-detail {
        background: #f8f9fa;
        color: var(--zada-dark);
        border: 1px solid #eee;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: var(--zada-dark);
        color: var(--zada-gold);
        border-color: var(--zada-dark);
    }
</style>

<div class="page-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold mb-1">Kelola Pengiriman</h3>
            <p class="text-muted small m-0">Logistik & Manajemen Distribusi Pesanan ZADA</p>
        </div>
        <div class="col-md-6 text-md-end">
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-2 text-warning"></i> {{ date('d M Y') }}
            </span>
        </div>
    </div>
</div>

{{-- STATISTIK --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card pending">
            <div class="stat-number">{{ $pending }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card shipped">
            <div class="stat-number">{{ $shipped }}</div>
            <div class="stat-label">On Transit</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card completed">
            <div class="stat-number">{{ $completed }}</div>
            <div class="stat-label">Received</div>
        </div>
    </div>
</div>

{{-- TABEL PENGIRIMAN --}}
<div class="pengiriman-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0" style="color: var(--zada-dark);">Log Pengiriman</h5>
        <div class="search-box">
            </div>
    </div>

    @if($pengiriman->count() > 0)
    <div class="table-responsive">
        <table class="table table-pengiriman align-middle mb-0">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Tujuan</th>
                    <th>Ongkos Kirim</th>
                    <th>Total Akhir</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengiriman as $item)
                <tr>
                    <td>
                        <div class="customer-info">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($item->nama_penerima ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="customer-name">{{ $item->nama_penerima ?? 'Guest' }}</div>
                                <div class="customer-phone">{{ $item->no_telepon ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="m-0 text-muted small" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $item->alamat ?? '-' }}
                        </p>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">Rp {{ number_format($item->shipping_cost ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="fw-extrabold text-dark" style="font-weight: 800;">Rp {{ number_format($item->grand_total, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @if($item->status == 'pending')
                            <span class="status-badge-pending">Menunggu Verifikasi</span>
                        @elseif($item->status == 'shipped')
                            <span class="status-badge-shipped">Dalam Pengiriman</span>
                        @else
                            <span class="status-badge-completed">Selesai</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.pengiriman.show', $item->id) }}" class="btn-detail">
                            <i class="bi bi-arrow-right-short fs-5 align-middle"></i> Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Data" style="width: 80px; opacity: 0.2;">
        <p class="mt-3 text-muted fw-bold">Tidak ada data pengiriman saat ini.</p>
    </div>
    @endif
</div>

@endsection