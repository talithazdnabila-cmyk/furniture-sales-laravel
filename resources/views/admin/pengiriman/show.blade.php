@extends('layouts.admin')

@section('title', 'Detail Pengiriman')

@section('content')

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--zada-dark);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--zada-gold);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 12px;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
    }

    .detail-value {
        font-weight: 700;
        color: var(--zada-dark);
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-pending {
        background: #fff4e5;
        color: #b07219;
    }

    .status-shipped {
        background: #e7f3ff;
        color: #0c5282;
    }

    .status-completed {
        background: #e6fcf5;
        color: #0ca678;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #fafafa;
        border-radius: 12px;
        margin-bottom: 10px;
    }

    .product-name {
        font-weight: 600;
        color: var(--zada-dark);
    }

    .product-qty {
        font-size: 12px;
        color: #888;
    }

    .product-price {
        font-weight: 700;
        color: var(--zada-gold);
    }

    .total-box {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #fdfaf5;
        border-radius: 12px;
        border-left: 4px solid var(--zada-gold);
        margin-bottom: 10px;
    }

    .total-label {
        font-weight: 600;
    }

    .total-value {
        font-weight: 800;
    }

    .btn-change-status {
        background: var(--zada-dark);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-change-status:hover {
        background: var(--zada-gold);
        color: var(--zada-dark);
    }

    .btn-back {
        color: #888;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: var(--zada-gold);
    }
</style>

<div class="mb-4">
    <a href="{{ route('admin.pengiriman.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

{{-- INFORMASI PENGIRIMAN --}}
<div class="detail-card">
    <div class="section-title">Informasi Pengiriman</div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="detail-row">
                <span class="detail-label">Kode Transaksi</span>
                <span class="detail-value">{{ $pengiriman->kode_transaksi }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Penerima</span>
                <span class="detail-value">{{ $pengiriman->nama_penerima }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nomor Telepon</span>
                <span class="detail-value">{{ $pengiriman->no_telepon }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Alamat</span>
                <span class="detail-value" style="max-width: 200px;">{{ $pengiriman->alamat }}</span>
            </div>
            @if($pengiriman->catatan)
            <div class="detail-row">
                <span class="detail-label">Catatan</span>
                <span class="detail-value" style="font-style: italic;">{{ $pengiriman->catatan }}</span>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="detail-row">
                <span class="detail-label">Tanggal Pemesanan</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($pengiriman->created_at)->format('d M Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status Pengiriman</span>
                <span>
                    @if($pengiriman->status == 'pending')
                        <span class="status-badge status-pending">Menunggu Pengiriman</span>
                    @elseif($pengiriman->status == 'shipped')
                        <span class="status-badge status-shipped">Dalam Pengiriman</span>
                    @else
                        <span class="status-badge status-completed">Selesai</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Ongkos Kirim</span>
                <span class="detail-value" style="color: var(--zada-gold);">Rp {{ number_format($pengiriman->shipping_cost, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- PRODUK --}}
<div class="detail-card">
    <div class="section-title">Produk</div>
    
    @forelse($pengiriman->details as $detail)
    <div class="product-item">
        <div>
            <div class="product-name">{{ $detail->product->name ?? 'Produk Tidak Ditemukan' }}</div>
            <div class="product-qty">{{ $detail->qty }} Unit × Rp {{ number_format($detail->harga, 0, ',', '.') }}</div>
        </div>
        <div class="product-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
    </div>
    @empty
    <p class="text-muted">Tidak ada produk</p>
    @endforelse
</div>

{{-- RINGKASAN PEMBAYARAN --}}
<div class="detail-card">
    <div class="section-title">Ringkasan Pembayaran</div>
    
    <div class="total-box">
        <span class="total-label">Subtotal</span>
        <span class="total-value">Rp {{ number_format($pengiriman->total_harga, 0, ',', '.') }}</span>
    </div>
    
    <div class="total-box">
        <span class="total-label">Ongkos Kirim</span>
        <span class="total-value">Rp {{ number_format($pengiriman->shipping_cost, 0, ',', '.') }}</span>
    </div>
    
    <div class="total-box" style="border-left-color: var(--zada-dark); background: var(--zada-dark); color: white;">
        <span class="total-label" style="color: white;">Grand Total</span>
        <span class="total-value" style="color: var(--zada-gold);">Rp {{ number_format($pengiriman->grand_total, 0, ',', '.') }}</span>
    </div>
</div>

{{-- UBAH STATUS --}}
<div class="detail-card">
    <div class="section-title">Ubah Status Pengiriman</div>
    
    @if($pengiriman->status === 'pending')
        <div style="padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; color: #856404;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 18px;"></i>
                <span><strong>Transaksi belum dikonfirmasi!</strong> Konfirmasi transaksi terlebih dahulu di menu Transaksi Masuk sebelum mengubah status pengiriman.</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.pengiriman.updateStatus', $pengiriman->id) }}" style="opacity: 0.5; pointer-events: none;">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select" required disabled>
                    <option value="pending" {{ $pengiriman->status == 'pending' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                    <option value="shipped" {{ $pengiriman->status == 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="completed" {{ $pengiriman->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <button type="submit" class="btn-change-status" disabled>
                <i class="bi bi-check-circle"></i> Perbarui Status
            </button>
        </form>
    @elseif($pengiriman->payment_proof_status !== 'approved')
        <div style="padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; color: #856404;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 18px;"></i>
                <span><strong>Status pengiriman tidak bisa diubah!</strong> Bukti transfer harus disetujui terlebih dahulu di menu Verifikasi Bukti Transfer.</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.pengiriman.updateStatus', $pengiriman->id) }}" style="opacity: 0.5; pointer-events: none;">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select" required disabled>
                    <option value="pending" {{ $pengiriman->status == 'pending' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                    <option value="shipped" {{ $pengiriman->status == 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="completed" {{ $pengiriman->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <button type="submit" class="btn-change-status" disabled>
                <i class="bi bi-check-circle"></i> Perbarui Status
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.pengiriman.updateStatus', $pengiriman->id) }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ $pengiriman->status == 'pending' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                    <option value="shipped" {{ $pengiriman->status == 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="completed" {{ $pengiriman->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <button type="submit" class="btn-change-status">
                <i class="bi bi-check-circle"></i> Perbarui Status
            </button>
        </form>
    @endif
</div>

@endsection
