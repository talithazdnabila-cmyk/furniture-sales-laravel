@extends('layouts.admin')

@section('title', 'Manajemen Transaksi - ZADA.CO')

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

    .card-luxury {
        border: none;
        border-radius: 15px;
        background: #fff;
        overflow: hidden;
    }

    /* Table Styling */
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

    /* Transaction Code */
    .trx-code {
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 700;
        color: var(--zada-dark);
        background: #f4f4f4;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    .status-pending { background: #fff4e5; color: #b07219; }
    .status-success { background: #e6fcf5; color: #0ca678; }
    .status-failed { background: #fff5f5; color: #fa5252; }

    .price-text {
        font-weight: 700;
        color: var(--zada-dark);
    }

    .btn-detail {
        background: var(--zada-dark);
        color: white;
        border: none;
        padding: 6px 15px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-detail:hover {
        background: var(--zada-gold);
        color: var(--zada-dark);
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h3 class="page-title m-0">Semua Transaksi</h3>
        <p class="text-muted small m-0">Pantau seluruh arus masuk pesanan dan laporan penjualan.</p>
    </div>

    @if($transaksis->count() == 0)
        <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
            <div class="card-body">
                <i class="fas fa-receipt fa-4x text-light mb-3"></i>
                <h5 class="text-muted">Belum ada transaksi masuk</h5>
                <p class="text-muted small">Data transaksi akan muncul di sini setelah pelanggan melakukan checkout.</p>
            </div>
        </div>
    @else
        <div class="card card-luxury shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Kode Trx</th>
                                <th>Tanggal</th>
                                <th>Pembeli</th>
                                <th>Total Pembayaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $t)
                                <tr>
                                    <td>
                                        <span class="trx-code">{{ $t->kode_transaksi }}</span>
                                    </td>
                                    <td class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> 
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $t->nama_pembeli }}</div>
                                    </td>
                                    <td>
                                        <span class="price-text">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClass = 'status-pending';
                                            if(strtolower($t->status) == 'success' || strtolower($t->status) == 'selesai') $statusClass = 'status-success';
                                            if(strtolower($t->status) == 'failed' || strtolower($t->status) == 'batal') $statusClass = 'status-failed';
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $t->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.transaksi.show', $t->id) }}" class="btn-detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection