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

    /* ===== CONTAINER ===== */
    .history-container { 
        max-width: 800px; 
        margin: 120px auto 80px; 
        padding: 0 15px; 
    }

    .page-header { margin-bottom: 25px; }
    .page-header h2 { font-family: 'Playfair Display', serif; font-size: 26px; color: #fff; margin: 0; }

    /* ===== TRX CARD (SHOPEE STYLE) ===== */
    .trx-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        margin-bottom: 15px;
        transition: 0.2s;
    }

    /* Top Bar: Store Name & Status */
    .trx-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .brand-tag {
        font-size: 11px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-text {
        font-size: 10px;
        font-weight: 700;
        color: var(--accent-zada);
        text-transform: uppercase;
    }

    /* Product Section */
    .item-container {
        padding: 15px;
        display: flex;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.03);
    }

    .item-img-box {
        width: 65px;
        height: 65px;
        background: rgba(255,255,255,0.05);
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .item-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-info {
        flex-grow: 1;
    }

    .item-name {
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        margin: 0 0 3px;
        color: #fff;
    }

    .item-meta {
        font-size: 11px;
        color: rgba(255,255,255,0.4);
        margin-bottom: 5px;
    }

    .item-price-qty {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }

    /* Bottom Bar: Total & Actions */
    .trx-bottom-bar {
        padding: 15px;
        background: rgba(255,255,255,0.01);
    }

    .total-info {
        display: flex;
        justify-content: flex-end;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 15px;
    }

    .total-label { font-size: 11px; color: rgba(255,255,255,0.5); }
    .total-price { font-size: 16px; font-weight: 800; color: var(--accent-zada); }

    /* Buttons Group */
    .btn-group {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-zada {
        padding: 8px 20px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        text-decoration: none;
        transition: 0.2s;
        display: inline-block;
        text-align: center;
    }

    .btn-buy-again {
        background: var(--accent-zada);
        color: var(--bg-zada);
        border: none;
    }

    .btn-buy-again:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
    }

    .btn-outline {
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.7);
    }

    .btn-outline:hover {
        border-color: var(--accent-zada);
        color: var(--accent-zada);
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        border: 1px dashed var(--glass-border);
        border-radius: 12px;
        opacity: 0.6;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.4);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        color: var(--accent-zada);
        transform: translateX(-3px);
    }

</style>

<div class="history-container">
    <div class="page-header">
        <h2>Pesanan Saya</h2>
    </div>

    @forelse ($transactions as $trx)
        <div class="trx-card" data-transaction-id="{{ $trx->id }}">
            {{-- Header ala Shopee --}}
            <div class="trx-top-bar">
                <div class="brand-tag">
                    <i class="bi bi-bag-check" style="color: var(--accent-zada)"></i> 
                    ZADA.CO 
                    <span style="opacity: 0.3; font-weight: 300;">#{{ $trx->kode_transaksi }}</span>
                </div>
                <div class="status-text" data-status-element>
                    @if($trx->status == 'pending') Menunggu Verifikasi
                    @elseif($trx->status == 'completed') Selesai
                    @elseif($trx->status == 'shipped') Sedang Dikirim
                    @elseif($trx->status == 'rejected') Ditolak
                    @else {{ ucfirst($trx->status) }}
                    @endif
                </div>
            </div>

            {{-- Product Items --}}
            @foreach ($trx->details as $detail)
                <div class="item-container">
                    <div class="item-img-box">
                        @if($detail->product && $detail->product->image)
                            <img src="{{ asset('storage/' . $detail->product->image) }}" alt="Product">
                        @else
                            <div style="height:100%; display:flex; align-items:center; justify-content:center; opacity:0.2;">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </div>
                    <div class="item-info">
                        <h5 class="item-name">{{ $detail->product->name ?? 'ZADA Masterpiece' }}</h5>
                        <div class="item-meta">Timeless Collection</div>
                        <div class="item-price-qty">
                            <span>x{{ $detail->qty }}</span>
                            <span style="color: var(--accent-zada)">Rp{{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Footer ala Shopee --}}
            <div class="trx-bottom-bar">
                <div class="total-info">
                    <span class="total-label">Total Pesanan:</span>
                    <span class="total-price">Rp{{ number_format($trx->grand_total, 0, ',', '.') }}</span>
                </div>
                
                <div class="btn-group">
                    {{-- Tombol Beli Lagi --}}
                    @if($trx->details->first() && $trx->details->first()->product)
                        <a href="{{ route('products.show', $trx->details->first()->product->id) }}" class="btn-zada btn-buy-again">
                            Beli Lagi
                        </a>
                    @endif
                    
                    <a href="{{ route('user.transactions.show', $trx->id) }}" class="btn-zada btn-outline">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="bi bi-cart-x" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
            <p>Belum ada transaksi.</p>
            <a href="{{ url('/products') }}" style="color:var(--accent-zada); text-decoration:none; font-size:11px; font-weight:800;">MULAI BELANJA</a>
        </div>
    @endforelse
</div>

<footer style="text-align: center; padding: 40px 0; opacity: 0.2; font-size: 8px; letter-spacing: 2px;">
    &copy; 2026 ZADA.CO LUXURY ARCHIVE
</footer>

<script>
// Auto-polling untuk status semua transaksi real-time
document.addEventListener('DOMContentLoaded', function() {
    const transactionCards = document.querySelectorAll('[data-transaction-id]');
    
    // Fungsi untuk update status transaksi
    function checkAllStatuses() {
        transactionCards.forEach(card => {
            const transactionId = card.getAttribute('data-transaction-id');
            const statusElement = card.querySelector('[data-status-element]');
            
            if (!statusElement) return;
            
            fetch(`/api/transaksi/${transactionId}/status`)
                .then(response => response.json())
                .then(data => {
                    const newStatus = data.status;
                    const statusTexts = {
                        'pending': 'Menunggu Verifikasi',
                        'shipped': 'Sedang Dikirim',
                        'completed': 'Selesai',
                        'rejected': 'Ditolak'
                    };
                    
                    const displayText = statusTexts[newStatus] || newStatus;
                    
                    if (statusElement.textContent.trim() !== displayText) {
                        // Ada perubahan status!
                        statusElement.textContent = displayText;
                        
                        // Tambahkan animasi highlight
                        card.style.animation = 'none';
                        setTimeout(() => {
                            card.style.animation = 'statusUpdate 0.6s ease-out';
                        }, 10);
                    }
                })
                .catch(error => console.error('Error checking status:', error));
        });
    }
    
    // Poll status setiap 5 detik
    setInterval(checkAllStatuses, 5000);
});

// CSS untuk animasi
const style = document.createElement('style');
style.textContent = `
    @keyframes statusUpdate {
        0% {
            background-color: rgba(232, 184, 109, 0.1);
            transform: scale(1);
        }
        50% {
            background-color: rgba(232, 184, 109, 0.2);
            transform: scale(1.01);
        }
        100% {
            background-color: transparent;
            transform: scale(1);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection