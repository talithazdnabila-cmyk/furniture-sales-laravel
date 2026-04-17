@extends('layouts.admin')

@section('title', 'Detail Transaksi - ZADA.CO')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    /* --- TAMPILAN LAYAR --- */
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

    .trx-code {
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 700;
        color: var(--zada-dark);
        background: #f4f4f4;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    .status-pending { background: #fff4e5; color: #b07219; }
    .status-success { background: #e6fcf5; color: #0ca678; }
    .status-failed { background: #fff5f5; color: #fa5252; }

    .detail-section {
        padding: 25px;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .detail-label {
        color: #888;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .detail-value {
        color: var(--zada-dark);
        font-size: 15px;
        font-weight: 700;
    }

    /* --- TOMBOL CETAK --- */
    .btn-print {
        background: var(--zada-gold);
        color: var(--zada-dark);
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-print:hover { opacity: 0.8; }

    /* --- CSS KHUSUS PRINT --- */
    @media print {
        /* Sembunyikan elemen sidebar, navbar admin, dan tombol-tombol */
        .btn-back, .btn-print, .main-header, .sidebar, footer, .nav-breadcrumb {
            display: none !important;
        }

        /* Hilangkan padding container dan bayangan kartu */
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }

        .card-luxury {
            box-shadow: none !important;
            border: 1px solid #eee !important;
            border-radius: 0 !important;
            width: 100% !important;
        }

        body {
            background-color: #fff !important;
            font-size: 11px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .page-title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        /* Compact details */
        .detail-section {
            padding: 12px 15px !important;
            border-bottom: 1px solid #f0f0f0 !important;
            margin-bottom: 0 !important;
        }

        .detail-row {
            margin-bottom: 8px !important;
        }

        .detail-label {
            font-size: 10px !important;
        }

        .detail-value {
            font-size: 12px !important;
            margin-top: 2px !important;
        }

        .row {
            margin: 0 !important;
        }

        .col-6, .col-5, .col-7, .col-8, .col-4 {
            padding: 0 !important;
        }

        .col-6:not(:last-child) {
            padding-right: 15px !important;
        }

        /* Table kompact */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        thead {
            background: #fafafa !important;
        }

        th, td {
            padding: 6px 8px !important;
            font-size: 10px !important;
            border: 1px solid #e0e0e0 !important;
        }

        thead th {
            padding: 8px !important;
        }

        /* Signature section */
        .mt-5 {
            margin-top: 15px !important;
        }

        .mb-5 {
            margin-bottom: 5px !important;
        }

        /* Pastikan background warna badge tetap tercetak */
        .status-badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #ccc;
            padding: 4px 8px !important;
        }

        .trx-code {
            background: #eee !important;
            -webkit-print-color-adjust: exact;
            padding: 4px 6px !important;
        }

        .mb-3 { margin-bottom: 6px !important; }
        .mb-2 { margin-bottom: 4px !important; }
        .mb-0 { margin-bottom: 0 !important; }
        .mt-2 { margin-top: 4px !important; }
        .mt-5 { margin-top: 10px !important; }
        
        .d-flex {
            gap: 0 !important;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        h6 {
            font-size: 12px !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }

        h2 {
            font-size: 24px !important;
            margin: 0 !important;
        }

        h5 {
            font-size: 13px !important;
            margin: 0 !important;
        }

        p {
            margin: 0 !important;
        }

        /* Page break handling */
        .d-none.d-print-block {
            display: block !important;
            page-break-before: avoid;
        }

        /* Prevent orphans and widows */
        table {
            page-break-inside: avoid;
        }

        .detail-section {
            page-break-inside: avoid;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    {{-- Header Dashboard --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="page-title m-0">Detail Transaksi</h3>
            <p class="text-muted small m-0">Invoice Resmi ZADA.CO</p>
        </div>
        <div class="d-flex gap-2">
            {{-- Tombol Selesai (hanya muncul jika status = shipped) --}}
            @if($transaksi->status == 'shipped')
                <form action="{{ route('admin.transaksi.selesai', $transaksi->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-print" style="background: var(--zada-gold); color: var(--zada-dark);">
                        <i class="fas fa-check me-2"></i> Tanda Terima
                    </button>
                </form>
            @endif
            
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print me-2"></i> Cetak Invoice
            </button>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-back" style="background: var(--zada-dark); color:white; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:600;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Layout Invoice --}}
    <div class="card card-luxury shadow-sm mb-4">
        <div class="detail-section d-none d-print-block">
            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-family: 'Playfair Display', serif; font-weight: 800; letter-spacing: 2px;">ZADA.CO</h2>
                <div class="text-end">
                    <h5 class="m-0">INVOICE PESANAN</h5>
                    <small class="text-muted">Dicetak pada: {{ date('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-row">
                <div>
                    <span class="detail-label">Kode Transaksi</span>
                    <div class="detail-value mt-2">
                        <span class="trx-code">{{ $transaksi->kode_transaksi }}</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="detail-label">Status Pembayaran</span>
                    <div class="detail-value mt-2">
                        @php
                            $statusClass = 'status-pending';
                            $statusText = strtolower($transaksi->status);
                            if(in_array($statusText, ['success', 'selesai', 'paid'])) $statusClass = 'status-success';
                            if(in_array($statusText, ['failed', 'batal', 'expired'])) $statusClass = 'status-failed';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $transaksi->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="row">
                <div class="col-6">
                    <h6 class="mb-3" style="font-weight: 700;">Informasi Pelanggan</h6>
                    <span class="detail-label d-block">Nama Lengkap</span>
                    <p class="detail-value mb-3">{{ $transaksi->nama_pembeli }}</p>
                    
                    <span class="detail-label d-block">Metode Pembayaran</span>
                    <p class="detail-value mb-0">{{ $transaksi->metode_pembayaran ?? 'Manual Transfer' }}</p>
                </div>
                <div class="col-6 text-end">
                    <h6 class="mb-3" style="font-weight: 700;">Waktu Pemesanan</h6>
                    <span class="detail-label d-block">Tanggal Transaksi</span>
                    <p class="detail-value">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}<br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('H:i') }} WIB</small>
                    </p>
                </div>
            </div>
        </div>

        {{-- INFORMASI PENGIRIMAN --}}
        <div class="detail-section">
            <div class="row">
                <div class="col-6">
                    <h6 class="mb-3" style="font-weight: 700;">Informasi Pengiriman</h6>
                    <span class="detail-label d-block">Penerima</span>
                    <p class="detail-value mb-2">{{ $transaksi->nama_penerima ?? '-' }}</p>
                    
                    <span class="detail-label d-block">Nomor Telepon</span>
                    <p class="detail-value mb-2">{{ $transaksi->no_telepon ?? '-' }}</p>
                    
                    <span class="detail-label d-block">Alamat Tujuan</span>
                    <p class="detail-value mb-2">{{ $transaksi->alamat ?? '-' }}</p>

                    @if($transaksi->catatan)
                    <span class="detail-label d-block">Catatan</span>
                    <p class="detail-value mb-0" style="font-style: italic;">{{ $transaksi->catatan }}</p>
                    @endif
                </div>
                <div class="col-6 text-end">
                    <h6 class="mb-3" style="font-weight: 700;">Biaya Pengiriman</h6>
                    <span class="detail-label d-block">Ongkos Kirim</span>
                    <p class="detail-value mb-3" style="font-size: 20px; color: var(--zada-gold);">
                        Rp {{ number_format($transaksi->shipping_cost ?? 0, 0, ',', '.') }}
                    </p>

                    <span class="detail-label d-block">Status Pengiriman</span>
                    <div class="detail-value mt-2">
                        @if($transaksi->status == 'pending')
                            <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill">Pending</span>
                        @elseif($transaksi->status == 'shipped')
                            <span class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-pill">Dikirim</span>
                        @elseif($transaksi->status == 'rejected')
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill">Ditolak</span>
                        @else
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-section p-0">
            <table class="table mb-0">
                <thead style="background: #fafafa;">
                    <tr>
                        <th class="ps-4">Produk</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end pe-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi->details as $detail)
                        <tr>
                            <td class="ps-4">
                                <span style="font-weight: 700; color: #111;">{{ $detail->product->name ?? 'Produk Tidak Ditemukan' }}</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td class="text-end pe-4" style="font-weight: 700;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Data produk kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="detail-section">
            <div class="row align-items-center">
                <div class="col-7">
                    <p class="small text-muted mb-0">
                        * Terima kasih telah berbelanja di ZADA.CO.<br>
                        * Simpan invoice ini sebagai bukti transaksi yang sah.
                    </p>
                </div>
                <div class="col-5">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="detail-label">Subtotal</span>
                        <span class="detail-value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3" style="padding-bottom: 10px; border-bottom: 1px solid #e0e0e0;">
                        <span class="detail-label">Ongkos Kirim</span>
                        <span class="detail-value">Rp {{ number_format($transaksi->shipping_cost ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="detail-label">Grand Total</span>
                        <span class="detail-value" style="font-size: 22px; color: var(--zada-gold);">
                            Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5 d-none d-print-block">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Hormat Kami,</p>
                <br><br>
                <p class="fw-bold">Management ZADA.CO</p>
            </div>
        </div>
    </div>
</div>

@endsection