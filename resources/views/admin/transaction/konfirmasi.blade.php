@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran - ZADA.CO')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
        --zada-soft-gold: #fcf8f1;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: var(--zada-dark);
        letter-spacing: -0.5px;
    }

    /* Transaction Card */
    .transaction-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid #f1f1f1;
    }
    
    .transaction-header {
        background: var(--zada-dark);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left .trx-id {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--zada-gold);
        font-weight: 800;
        margin-bottom: 3px;
        display: block;
    }

    .header-left .buyer-name {
        font-size: 16px;
        font-family: 'Playfair Display', serif;
        margin: 0;
    }

    .header-right { text-align: right; }
    .total-label { font-size: 9px; text-transform: uppercase; opacity: 0.6; display: block; margin-bottom: 1px; }
    .total-amount { font-size: 20px; font-weight: 800; color: var(--zada-gold); }

    .transaction-body { padding: 30px; }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .info-box {
        background: var(--bg-soft);
        padding: 20px;
        border-radius: 15px;
        border: 1px solid #eee;
    }

    .info-box h6 {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        color: #999;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box p { margin-bottom: 8px; font-size: 14px; color: #444; }
    .info-box strong { color: var(--zada-dark); }

    /* Product Table */
    .product-list { width: 100%; border-collapse: collapse; }
    .product-list th {
        font-size: 11px;
        text-transform: uppercase;
        color: #999;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .product-list td { padding: 15px 0; border-bottom: 1px solid #f9f9f9; font-size: 14px; }

    /* Action Buttons */
    .action-area {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn-zada {
        padding: 12px 25px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.3s;
        border: none;
    }

    .btn-confirm { background: var(--zada-dark); color: var(--zada-gold); }
    .btn-confirm:hover { background: #000; transform: translateY(-2px); }

    .btn-reject { background: #fff; color: #e03131; border: 1px solid #ffe3e3; }
    .btn-reject:hover { background: #fff0f0; }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Konfirmasi Pembayaran</h3>
            <p class="text-muted small m-0">Verifikasi bukti transfer untuk memproses pesanan pelanggan.</p>
        </div>
        <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill fw-bold">
            <i class="fas fa-clock text-warning me-2"></i> {{ $transaksiPending->count() }} Menunggu
        </span>
    </div>

    @forelse($transaksiPending as $trx)
    <div class="transaction-card">
        <div class="transaction-header">
            <div class="header-left">
                <span class="trx-id">ID: #{{ $trx->kode_transaksi }}</span>
                <h4 class="buyer-name">{{ $trx->nama_pembeli }}</h4>
            </div>
            <div class="header-right">
                <span class="total-label">Total Payment</span>
                <span class="total-amount">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="transaction-body">
            <div class="info-grid">
                {{-- Shipping Info --}}
                <div class="info-box">
                    <h6><i class="fas fa-truck"></i> Informasi Pengiriman</h6>
                    <p><strong>Penerima:</strong> {{ $trx->nama_penerima }}</p>
                    <p><strong>Kontak:</strong> {{ $trx->no_telepon }}</p>
                    <p><strong>Alamat:</strong> {{ $trx->alamat }}</p>
                    @if($trx->catatan)
                        <p class="mt-2 p-2 bg-white rounded border small italic text-muted">"{{ $trx->catatan }}"</p>
                    @endif
                </div>

                {{-- Product Summary --}}
                <div class="info-box">
                    <h6><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h6>
                    <table class="product-list">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Jml</th>
                                <th class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trx->details as $detail)
                            <tr>
                                <td><strong>{{ $detail->product->name ?? 'ZADA Masterpiece' }}</strong></td>
                                <td class="text-center">{{ $detail->qty }}</td>
                                <td class="text-end">Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="action-area">
                <form action="{{ route('admin.transaksi.tolak', $trx->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-zada btn-reject" onclick="return confirm('Tolak transaksi ini?')">
                        <i class="fas fa-times me-2"></i> Tolak Transaksi
                    </button>
                </form>
                
                <form action="{{ route('admin.transaksi.konfirmasi', $trx->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-zada btn-confirm" onclick="return confirm('Konfirmasi pembayaran sekarang?')">
                        <i class="fas fa-check me-2"></i> Konfirmasi & Kirim Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state shadow-sm border">
        <div class="mb-4">
            <i class="fas fa-check-double fa-4x text-muted opacity-25"></i>
        </div>
        <h4 class="fw-bold text-muted">Tidak Ada Antrean</h4>
        <p class="text-muted small">Semua pembayaran telah diproses dengan sempurna.</p>
    </div>
    @endforelse
</div>

@endsection