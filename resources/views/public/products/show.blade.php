@extends('layouts.public')

@section('title', $product->name . ' - ZADA.CO')

@section('styles')
<style>
    :root {
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* Back Button & Header */
    .header-section {
        padding: 40px 80px 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.4);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: var(--accent-zada);
    }

    /* Product Detail Layout */
    .product-detail-container {
        max-width: 1300px;
        margin: 20px auto 100px;
        padding: 0 40px;
    }

    .product-detail-wrapper {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    .product-image-container {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
        border: 2px solid;
        border-image: linear-gradient(135deg, rgba(232, 184, 109, 0.6) 0%, rgba(232, 184, 109, 0.2) 50%, rgba(232, 184, 109, 0.4) 100%) 1;
        border-radius: 16px;
        padding: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 480px;
        position: relative;
        box-shadow: 
            inset 0 0 30px rgba(232, 184, 109, 0.1),
            0 0 30px rgba(232, 184, 109, 0.15),
            0 20px 60px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    .product-image-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 14px;
        padding: 2px;
        background: linear-gradient(135deg, rgba(232, 184, 109, 0.5) 0%, rgba(232, 184, 109, 0.1) 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    .product-image-container::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid rgba(232, 184, 109, 0.2);
        border-radius: 12px;
        pointer-events: none;
    }

    .product-image-container img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.6)) brightness(1.05);
        position: relative;
        z-index: 1;
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .product-image-container:hover img {
        transform: scale(1.08) translateY(-15px);
        filter: drop-shadow(0 50px 100px rgba(232, 184, 109, 0.25)) brightness(1.1);
    }

    .product-info-container {
        display: flex;
        flex-direction: column;
        min-height: 550px;
    }

    .info-top p.tag-label {
        color: var(--accent-zada);
        font-weight: 800;
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin: 0 0 8px;
    }

    .info-top h2 {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        color: #fff;
        margin: 5px 0 10px;
        line-height: 1.1;
    }

    .price-box {
        font-size: 30px;
        font-weight: 800;
        color: var(--accent-zada);
        margin-bottom: 20px;
    }

    .narrative-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--glass-border);
        border-bottom: 1px solid var(--glass-border);
        margin-bottom: 25px;
        padding: 20px 0;
    }

    .narrative-title {
        color: var(--accent-zada);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .scroll-area {
        overflow-y: auto;
        padding-right: 15px;
        max-height: 280px;
    }

    .scroll-area::-webkit-scrollbar {
        width: 2px;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background: var(--accent-zada);
    }

    .description-text {
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.8;
        font-size: 15px;
    }

    /* Action Section */
    .action-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .stock-box {
        padding: 15px;
        background: rgba(232, 184, 109, 0.1);
        border: 1px solid var(--accent-zada);
        border-radius: 10px;
    }

    .stock-box p {
        font-size: 13px;
        color: var(--accent-zada);
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
    }

    .stock-value {
        color: #fff;
        font-weight: 700;
        margin-left: 6px;
    }

    .login-cta {
        background: rgba(232, 184, 109, 0.1);
        border: 1px solid rgba(232, 184, 109, 0.3);
        border-radius: 10px;
        padding: 30px;
        text-align: center;
    }

    .login-cta p {
        margin: 0 0 20px 0;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
    }

    .login-cta-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cta-btn {
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }

    .cta-btn-primary {
        background: var(--accent-zada);
        color: #000;
    }

    .cta-btn-primary:hover {
        background: #d4a857;
    }

    .cta-btn-secondary {
        background: transparent;
        border: 1px solid var(--accent-zada);
        color: var(--accent-zada);
    }

    .cta-btn-secondary:hover {
        background: var(--accent-zada);
        color: #000;
    }

    /* Recommended Section */
    .recommended-section {
        margin-top: 80px;
        border-top: 1px solid var(--glass-border);
        padding-top: 40px;
    }

    .recommended-title {
        font-family: 'Playfair Display';
        font-size: 26px;
        margin-bottom: 30px;
    }

    .recommended-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .recommended-card {
        display: block;
        text-decoration: none;
        color: inherit;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        padding: 20px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .recommended-card:hover {
        border-color: var(--accent-zada);
        transform: translateY(-5px);
    }

    .recommended-image {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .recommended-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .recommended-name {
        font-family: 'Playfair Display';
        font-size: 16px;
        margin: 0 0 5px;
    }

    .recommended-price {
        color: var(--accent-zada);
        font-weight: 700;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .product-detail-wrapper {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .product-image-container {
            min-height: 350px;
            padding: 30px;
        }

        .info-top h2 {
            font-size: 32px;
        }

        .recommended-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@endsection

@section('content')

{{-- PRODUCT DETAIL --}}
<div class="product-detail-container">
    <div class="product-detail-wrapper">
        {{-- PRODUCT IMAGE --}}
        <div class="product-image-container">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>

        {{-- PRODUCT INFO --}}
        <div class="product-info-container">
            <div class="info-top">
                <p class="tag-label">Curated Piece</p>
                <h2>{{ $product->name }}</h2>
                <div class="price-box">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>

            <div class="narrative-box">
                <p class="narrative-title">Design Narrative</p>
                <div class="scroll-area">
                    <div class="description-text">
                        {{ $product->description ?? 'Redefine your living sanctuary with the ' . $product->name . '. This piece is not just furniture; it is a meticulously crafted work of art designed to bring both timeless elegance and modern functionality to your home interior.' }}
                    </div>
                </div>
            </div>

            {{-- ACTION SECTION FOR GUESTS --}}
            <div class="action-section">
                <div class="stock-box">
                    <p>
                        <i class="bi bi-box-seam" style="margin-right: 8px;"></i>
                        Stock: <span class="stock-value">{{ $product->stock }} Units</span>
                    </p>
                </div>

                <div class="login-cta">
                    <p>Tertarik dengan {{ $product->name }} ini? Silakan login atau daftar akun untuk membeli dan menyelesaikan transaksi.</p>
                    <div class="login-cta-buttons">
                        <a href="{{ route('login') }}" class="cta-btn cta-btn-secondary">Masuk</a>
                        <a href="{{ route('register') }}" class="cta-btn cta-btn-primary">Buat Akun Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RECOMMENDED PRODUCTS --}}
    @if ($relatedProducts->count() > 0)
        <div class="recommended-section">
            <h3 class="recommended-title">Recommended for You</h3>
            <div class="recommended-grid">
                @foreach ($relatedProducts as $item)
                    <a href="{{ route('products.show', $item->id) }}" class="recommended-card">
                        <div class="recommended-image">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <h4 class="recommended-name">{{ $item->name }}</h4>
                        <div class="recommended-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection
