@extends('layouts.user')

@section('title', 'Acquisition History - ZADA.CO')

@section('content')
{{-- Google Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-zada: #1e1b18; 
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-zada); 
        color: #f4f1ee;
        margin: 0;
    }

    .history-container { 
        max-width: 1000px; 
        margin: 40px auto 100px; 
        padding: 0 20px; 
    }

    /* REVISI: TOMBOL KEMBALI */
    .nav-top {
        margin-bottom: 40px;
    }

    .btn-back-gallery {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: rgba(255,255,255,0.5);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: 0.3s;
        padding: 10px 0;
    }

    .btn-back-gallery:hover {
        color: var(--accent-zada);
        transform: translateX(-5px);
    }

    .page-header { margin-bottom: 50px; text-align: center; }
    .page-header h2 { 
        font-family: 'Playfair Display', serif; 
        font-size: 42px; 
        color: #fff; 
        margin-bottom: 10px;
    }
    .page-header p { 
        color: var(--accent-zada); 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 4px; 
        font-weight: 800; 
    }

    /* Transaction Card */
    .trx-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 30px;
        transition: 0.3s;
    }
    .trx-card:hover { border-color: rgba(232, 184, 109, 0.3); }

    .trx-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--glass-border);
        margin-bottom: 25px;
    }

    .trx-id { font-family: 'Plus Jakarta Sans'; font-weight: 800; color: #fff; font-size: 14px; letter-spacing: 1px; }
    
    .status-badge {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .status-pending { background: rgba(232, 184, 109, 0.1); color: var(--accent-zada); border: 1px solid var(--accent-zada); }
    .status-completed { background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid #2ecc71; }

    /* Shipping Info Section */
    .shipping-box {
        background: rgba(255,255,255,0.02);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 20px;
        align-items: start;
    }
    .shipping-icon { color: var(--accent-zada); font-size: 20px; }
    .shipping-content h6 { margin: 0 0 8px; font-size: 12px; text-transform: uppercase; color: var(--accent-zada); letter-spacing: 1px; }
    .shipping-content p { margin: 0; font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.6; }

    /* Product Items */
    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }
    .item-info h5 { font-family: 'Playfair Display', serif; font-size: 18px; margin: 0; color: #fff; }
    .item-info span { font-size: 12px; color: rgba(255,255,255,0.4); }
    
    .item-price { text-align: right; font-weight: 700; color: #fff; }

    /* Trx Footer */
    .trx-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 25px;
    }
    .date-text { font-size: 12px; color: rgba(255,255,255,0.3); }
    .grand-total-box { text-align: right; }
    .grand-total-box label { display: block; font-size: 10px; text-transform: uppercase; color: var(--accent-zada); font-weight: 800; margin-bottom: 5px; }
    .grand-total-box .price { font-size: 24px; font-weight: 800; color: var(--accent-zada); }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
        background: var(--glass);
        border-radius: 30px;
        border: 1px dashed var(--glass-border);
    }
</style>

<div class="history-container">
    {{-- Tombol Kembali --}}
    <div class="nav-top">
        <a href="{{ route('user.products') }}" class="btn-back-gallery">
            <i class="bi bi-arrow-left"></i> Kembali ke Galeri Produk
        </a>
    </div>

    <div class="page-header">
        <p>Your Private Gallery</p>
        <h2>Transaksi Saya</h2>
    </div>

    @forelse ($transactions as $trx)
        <div class="trx-card">
            <div class="trx-header">
                <div class="trx-id">
                    <i class="bi bi-hash"></i> {{ $trx->kode_transaksi }}
                </div>
                <div class="status-badge {{ $trx->status == 'pending' ? 'status-pending' : 'status-completed' }}">
                    {{ $trx->status }}
                </div>
            </div>

            <div class="shipping-box">
                <div class="shipping-icon"><i class="bi bi-box-seam"></i></div>
                <div class="shipping-content">
                    <h6>Destination Details</h6>
                    <p>
                        <strong>{{ $trx->nama_penerima }}</strong><br>
                        {{ $trx->no_telepon }}<br>
                        {{ $trx->alamat }}
                        @if($trx->catatan)
                            <br><i style="font-size: 12px; opacity: 0.7;">Note: "{{ $trx->catatan }}"</i>
                        @endif
                    </p>
                </div>
            </div>

            @foreach ($trx->details as $detail)
                <div class="item-row">
                    <div class="item-info">
                        <h5>{{ $detail->product->name ?? 'ZADA Masterpiece' }}</h5>
                        <span>{{ $detail->qty }} Unit &times; Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="item-price">
                        Rp {{ number_format($detail->qty * ($detail->product->price ?? 0), 0, ',', '.') }}
                    </div>
                </div>
            @endforeach

            <div class="trx-footer">
                <div class="date-text">
                    <i class="bi bi-calendar3"></i> {{ $trx->created_at->format('d F Y') }} &bull; {{ $trx->created_at->format('H:i') }}
                </div>
                <div class="grand-total-box">
                    <label>Total Investment</label>
                    <div class="price">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="bi bi-bag-x" style="font-size: 48px; color: var(--glass-border); margin-bottom: 20px; display: block;"></i>
            <h4 style="font-family: 'Playfair Display'; margin-bottom: 10px;">Belum ada akuisisi</h4>
            <p style="opacity: 0.5; font-size: 14px;">Mulai bangun koleksi furnitur mewah Anda hari ini.</p>
            <a href="{{ route('user.products') }}" style="display: inline-block; margin-top: 20px; color: var(--accent-zada); text-decoration: none; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 2px;">Jelajahi Koleksi &rarr;</a>
        </div>
    @endforelse
</div>

<footer style="text-align: center; padding: 60px 0; opacity: 0.2; font-size: 10px; letter-spacing: 2px; text-transform: uppercase;">
    &copy; 2026 ZADA.CO LUXURY FURNITURE &bull; Confidential Archive
</footer>
@endsection