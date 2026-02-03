@extends('layouts.user')

@section('title', 'Finalize Acquisition - ZADA.CO')

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

    .checkout-container { 
        max-width: 900px; 
        margin: 60px auto 100px; 
        padding: 0 20px; 
    }

    .checkout-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 50px;
        backdrop-filter: blur(10px);
    }

    .checkout-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        margin-bottom: 10px;
        color: #fff;
    }

    .checkout-header p {
        color: var(--accent-zada);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 800;
        margin-bottom: 40px;
    }

    /* Order Summary Box */
    .order-summary {
        background: rgba(255,255,255,0.02);
        border: 1px dashed var(--glass-border);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 25px;
        align-items: center;
    }

    .product-preview {
        width: 100px; height: 100px;
        background: var(--glass);
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }

    .product-preview img { max-width: 80%; height: auto; }

    .summary-detail h4 { font-family: 'Playfair Display', serif; font-size: 20px; margin: 0 0 5px; color: #fff; }
    .summary-detail p { font-size: 13px; color: rgba(255,255,255,0.4); margin: 0; }

    .total-price { font-size: 20px; font-weight: 800; color: var(--accent-zada); }

    /* Form Styling */
    .form-section-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
        color: #fff;
        border-left: 3px solid var(--accent-zada);
        padding-left: 15px;
    }

    .input-group { margin-bottom: 25px; }
    .input-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .input-group input, .input-group textarea {
        width: 100%;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 15px 20px;
        color: #fff;
        font-family: inherit;
        transition: 0.3s;
        outline: none;
    }

    .input-group input:focus, .input-group textarea:focus {
        border-color: var(--accent-zada);
        background: rgba(255,255,255,0.05);
    }

    /* Buttons */
    .btn-group {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        margin-top: 40px;
    }

    .btn-secondary {
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        background: transparent;
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        color: rgba(255,255,255,0.5);
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-primary {
        background: var(--accent-zada);
        border: none;
        border-radius: 15px;
        padding: 20px;
        color: #1e1b18;
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(232, 184, 109, 0.3); }
    .btn-secondary:hover { background: var(--glass); color: #fff; }

    .zada-footer {
        text-align: center;
        padding: 60px 0;
        opacity: 0.3;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
</style>

<div class="checkout-container">
    <div class="checkout-card">
        <div class="checkout-header">
            <p>Secure Checkout</p>
            <h2>Form Pesanan</h2>
        </div>

        <form method="POST" action="{{ route('user.checkout.confirm') }}">
            @csrf

            {{-- RINGKASAN PRODUK --}}
            <div class="order-summary">
                <div class="product-preview">
                    {{-- Ganti src sesuai dengan variable image produk anda --}}
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="summary-detail">
                    <h4>{{ $product->name }}</h4>
                    <p>Quantity: {{ $checkout['qty'] }} Unit &bull; Rp {{ number_format($product->price, 0, ',', '.') }}/unit</p>
                </div>
                <div class="total-price">
                    Rp {{ number_format($product->price * $checkout['qty'], 0, ',', '.') }}
                </div>
            </div>

            {{-- DATA PENGIRIMAN --}}
            <div class="form-section-title">Shipping Information</div>

            <div class="input-group">
                <label>Nama Penerima</label>
                <input type="text" name="nama_penerima" value="{{ Auth::user()->name }}" required placeholder="Full name as per ID">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="input-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" name="no_telepon" placeholder="08xxxxxxxxxx" required>
                </div>
                <div class="input-group">
                    <label>Optional Note</label>
                    <input type="text" name="catatan" placeholder="E.g. Apartment floor, gate code">
                </div>
            </div>

            <div class="input-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="4" placeholder="Street Name, House Number, District, City, Province, Postal Code" required></textarea>
            </div>

            {{-- HIDDEN FIELDS --}}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="qty" value="{{ $checkout['qty'] }}">

            {{-- BUTTONS --}}
            <div class="btn-group">
                <a href="{{ route('user.products') }}" class="btn-secondary">
                    <i class="bi bi-arrow-left" style="margin-right: 8px;"></i> Cancel
                </a>
                <button type="submit" class="btn-primary">
                    Confirm & Proceed to Payment <i class="bi bi-chevron-right" style="margin-left: 8px;"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="zada-footer">
        &copy; 2026 ZADA.CO LUXURY FURNITURE &bull; Encrypted Transaction
    </div>
</div>
@endsection