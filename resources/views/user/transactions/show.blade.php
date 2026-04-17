@extends('layouts.user')

@section('title', 'Detail - ' . $transaction->kode_transaksi)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-zada: #121110; 
        --accent-zada: #e8b86d;
        --accent-hover: #d4a35d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
        --text-muted: rgba(244, 241, 238, 0.6);
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-zada); 
        color: #f4f1ee;
        margin: 0;
    }

    .screen-wrapper {
        min-height: 100vh;
        padding: 100px 5% 40px 5%;
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Header */
    .header-mini {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 30px;
        border-bottom: 1px solid var(--glass-border);
        padding-bottom: 20px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(24px, 4vw, 32px);
        margin: 5px 0 0 0;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: 1px solid var(--accent-zada);
        color: var(--accent-zada);
    }

    /* Grid System - Proportional Adjustment */
    .main-grid {
        display: grid;
        grid-template-columns: 1.4fr 0.6fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .main-grid { grid-template-columns: 1fr; }
    }

    .card-section {
        background: var(--glass);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        color: var(--accent-zada);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--glass-border);
    }

    /* Items */
    .item-mini {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .item-mini:last-child { border-bottom: none; }

    .item-img {
        width: 60px; height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--glass-border);
    }

    .item-name { font-family: 'Playfair Display', serif; font-size: 16px; margin: 0; }
    .item-meta { font-size: 12px; color: var(--text-muted); }

    /* Timeline / Log */
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-item::before {
        content: "";
        position: absolute;
        left: -21px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--accent-zada);
        box-shadow: 0 0 10px var(--accent-zada);
    }

    .timeline-item:not(:last-child)::after {
        content: "";
        position: absolute;
        left: -16px;
        top: 15px;
        width: 1px;
        height: 100%;
        background: var(--glass-border);
    }

    /* Info */
    .info-group { margin-bottom: 15px; }
    .info-label { font-size: 10px; color: var(--accent-zada); font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .info-value { font-size: 14px; line-height: 1.5; }

    /* Summary */
    .summary-row {
        display: flex; justify-content: space-between;
        padding: 12px 0;
        font-size: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }
    
    .total-row {
        margin-top: 10px;
        padding: 15px 0;
        border-top: 2px solid var(--accent-zada);
        color: var(--accent-zada);
        font-weight: 800;
        font-size: 22px;
    }

    .btn-submit {
        background: var(--accent-zada);
        color: #121110;
        border: none;
        padding: 14px;
        border-radius: 6px;
        font-weight: 800;
        width: 100%;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover { background: var(--accent-hover); transform: translateY(-2px); }

    .footer-note {
        text-align: center;
        font-size: 10px;
        color: var(--text-muted);
        padding: 40px 0;
        letter-spacing: 3px;
    }
</style>

<div class="screen-wrapper">
    <div class="header-mini">
        <div>
            <h1 class="page-title">Pesanan #{{ $transaction->kode_transaksi }}</h1>
        </div>
        <div class="status-badge">
            {{ $transaction->status }}
        </div>
    </div>

    <div class="main-grid">
        <div class="left-col">
            <div class="card-section">
                <h6 class="section-title">Barang Pesanan</h6>
                <div class="item-list">
                    @foreach ($transaction->details as $detail)
                        <div class="item-mini">
                            <img src="{{ $detail->product->image ? asset('storage/' . $detail->product->image) : 'https://via.placeholder.com/60' }}" class="item-img">
                            <div style="flex:1">
                                <h4 class="item-name">{{ $detail->product->name }}</h4>
                                <div class="item-meta">{{ $detail->qty }} Unit &times; Rp {{ number_format($detail->product->price, 0, ',', '.') }}</div>
                            </div>
                            <div style="font-weight: 700; color: var(--accent-zada);">
                                Rp {{ number_format($detail->qty * $detail->product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-section">
                <h6 class="section-title">Informasi Pengiriman</h6>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="info-group">
                        <div class="info-label">Penerima</div>
                        <div class="info-value"><strong>{{ $transaction->nama_penerima }}</strong></div>
                        <div class="info-value" style="font-size: 12px; opacity: 0.7;">{{ $transaction->no_telepon }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Alamat Tujuan</div>
                        <div class="info-value">{{ $transaction->alamat }}</div>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h6 class="section-title">Log Aktivitas & Status</h6>
                <div class="timeline">
                    <div class="timeline-item">
                        <div style="font-size: 13px; font-weight: 700;">Pesanan Berhasil Dibuat</div>
                        <div style="font-size: 11px; opacity: 0.6;">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <div class="timeline-item" style="padding-bottom: 0;">
                        <div style="font-size: 13px; font-weight: 700;">Status Saat Ini: <span style="color: var(--accent-zada)">{{ ucfirst($transaction->status) }}</span></div>
                        <div style="font-size: 11px; opacity: 0.6;">Pembaruan terakhir otomatis oleh sistem</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-col">
            <div class="card-section" style="position: sticky; top: 120px;">
                <h6 class="section-title">Ringkasan Biaya</h6>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($transaction->shipping_cost ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>

                @if($transaction->status === 'pending')
                    <div style="margin-top: 25px;">
                        <div class="info-label" style="margin-bottom: 15px; text-align: center;">Unggah Bukti Pembayaran</div>
                        <form action="{{ route('user.transactions.upload-payment-proof', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="payment_proof" style="width: 100%; margin-bottom: 15px; font-size: 12px;" required>
                            <button type="submit" class="btn-submit">Kirim Bukti</button>
                        </form>
                    </div>
                @elseif($transaction->payment_proof)
                    <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 8px; border: 1px solid var(--glass-border); text-align: center;">
                        <div class="info-label">Status Verifikasi</div>
                        <div style="font-size: 13px; margin-top: 5px;">
                            @if($transaction->payment_proof_status === 'approved')
                                <span style="color: #81c784;"><i class="bi bi-patch-check"></i> Pembayaran Valid</span>
                            @elseif($transaction->payment_proof_status === 'rejected')
                                <span style="color: #e57373;"><i class="bi bi-exclamation-triangle"></i> Ditolak</span>
                            @else
                                <span style="color: var(--accent-zada);"><i class="bi bi-clock"></i> Sedang Diperiksa</span>
                            @endif
                        </div>
                    </div>
                @endif

                <div style="margin-top: 20px; font-size: 11px; text-align: center; color: var(--text-muted);">
                    <i class="bi bi-shield-lock"></i> Pembayaran Aman & Terenkripsi
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-note">
        &copy; 2026 ZADA.CO LUXURY &bull; ARCHIVE
    </footer>
</div>

<script>
    // Script polling untuk update otomatis tanpa refresh manual
    setInterval(function() {
        fetch(`/api/transaksi/{{ $transaction->id }}/status`)
            .then(res => res.json())
            .then(data => {
                if(data.status.toLowerCase() !== "{{ strtolower($transaction->status) }}") {
                    location.reload();
                }
            });
    }, 10000);
</script>
@endsection