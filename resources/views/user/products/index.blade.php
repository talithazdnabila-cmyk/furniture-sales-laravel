@extends('layouts.user')

@section('title', 'Collections - ZADA.CO')

@section('content')

{{-- Google Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-zada: #1e1b18; 
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    body {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-zada);
        color: #f4f1ee;
        overflow-x: hidden;
    }

    /* Watermark Branding */
    .bg-watermark {
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
        font-size: 20vw; font-weight: 900;
        color: rgba(255, 255, 255, 0.015);
        z-index: -1; pointer-events: none; user-select: none;
    }

    /* ===== HERO ZADA ===== */
    .hero-zada {
        height: 85vh;
        display: flex;
        align-items: center;
        padding: 0 10%;
        background: linear-gradient(90deg, var(--bg-zada) 30%, transparent 100%), 
                    url('https://i.pinimg.com/736x/96/5d/37/965d37fe1bc7f26cf32dba9b205bc23c.jpg');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center;
        margin-top: 120px;
    }

    .hero-text h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(40px, 6vw, 70px);
        line-height: 1.1;
        margin-bottom: 10px;
    }

    /* ===== SEARCH & FILTER ===== */
    .search-section {
        padding: 40px 10%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .search-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-title {
        color: var(--accent-zada);
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 0;
    }

    .search-container {
        position: relative;
        flex: 1;
        min-width: 300px;
        max-width: 500px;
    }

    .search-input {
        width: 100%;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        padding: 14px 20px 14px 50px;
        border-radius: 10px;
        color: #fff;
        font-family: inherit;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .search-input::placeholder {
        color: rgba(255,255,255,0.4);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent-zada);
        background: rgba(255,255,255,0.08);
        box-shadow: 0 0 0 3px rgba(232, 184, 109, 0.15);
    }

    .search-icon {
        position: absolute;
        left: 18px; 
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent-zada);
        font-size: 16px;
        pointer-events: none;
    }

    /* Toolbar Filter */
    .toolbar {
        display: flex; 
        gap: 10px;
        justify-content: center;
        align-items: center;
        padding: 0 10% 15px 10%;
        margin-bottom: 35px;
    }

    .toolbar::-webkit-scrollbar { 
        height: 3px;
    }

    .toolbar::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.03);
        border-radius: 10px;
    }

    .toolbar::-webkit-scrollbar-thumb {
        background: var(--accent-zada);
        border-radius: 10px;
    }

    .toolbar::-webkit-scrollbar-thumb:hover {
        background: rgba(232, 184, 109, 0.8);
    }

    .filter-btn {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: rgba(255,255,255,0.5);
        padding: 10px 24px;
        border-radius: 50px;
        font-size: 11px; 
        font-weight: 700;
        text-transform: uppercase; 
        cursor: pointer;
        white-space: nowrap; 
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .filter-btn:hover {
        background: var(--accent-zada);
        color: #000; 
        border-color: var(--accent-zada);
        transform: translateY(-1px);
    }

    .filter-btn.active {
        background: var(--accent-zada);
        color: #000; 
        border-color: var(--accent-zada);
    }

    @media (max-width: 768px) {
        .search-section {
            padding: 30px 5%;
            gap: 15px;
        }

        .search-wrapper {
            flex-direction: column;
            gap: 15px;
        }

        .search-container {
            min-width: 100%;
            max-width: 100%;
        }

        .toolbar {
            padding: 0 5% 10px 5%;
            margin-bottom: 25px;
        }

        .filter-btn {
            padding: 8px 18px;
            font-size: 10px;
        }
    }

    /* Product Grid */
    .main-container { 
        padding: 0 10% 100px; 
    }

    .zada-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .zada-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 25px;
        position: relative;
        text-decoration: none;
        color: #fff;
        overflow: hidden;
        transition: 0.4s;
        display: flex;
        flex-direction: column;
    }

    .zada-card:hover {
        border-color: var(--accent-zada);
        background: rgba(232, 184, 109, 0.05);
        transform: translateY(-5px);
    }

    /* Initial Z Watermark on Card */
    .zada-card::before {
        content: 'Z';
        position: absolute;
        top: 10px;
        right: 20px;
        font-family: 'Playfair Display', serif;
        font-size: 40px;
        color: rgba(232, 184, 109, 0.1);
        font-weight: 900;
        z-index: 0;
    }

    .category-label {
        color: var(--accent-zada);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .category-badge {
        color: var(--accent-zada);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .zada-card img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.5));
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .price-tag {
        font-size: 15px;
        font-weight: 800;
        color: var(--accent-zada);
        margin-bottom: 5px;
    }

    .price-badge {
        font-size: 15px;
        font-weight: 800;
        color: var(--accent-zada);
        margin-bottom: 5px;
    }
    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        margin: 0 0 10px 0;
        line-height: 1.2;
    }

    .stock-status {
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid var(--glass-border);
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stock-info {
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid var(--glass-border);
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stock-critical {
        color: #ff6b6b;
    }

    .add-to-cart-btn {
        margin-top: 15px;
        width: 100%;
        padding: 12px;
        background: var(--accent-zada);
        color: #000;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
        position: relative;
        z-index: 2;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(232, 184, 109, 0.3);
    }

    .add-to-cart-btn:disabled {
        background: rgba(232, 184, 109, 0.4);
        cursor: not-allowed;
        opacity: 0.6;
    }

</style>

<div class="bg-watermark">ZADA.CO</div>

<header class="hero-zada">
    <div class="hero-text">
        <span style="color:var(--accent-zada); letter-spacing:5px; font-weight:800; font-size:14px; text-transform:uppercase;">Furniture Eksklusif</span>
        <h1>Koleksi<br>Masterpiece Kami</h1>
        <p style="max-width: 450px; opacity: 0.7; line-height: 1.8; margin: 20px 0;">Jelajahi koleksi furniture mewah pilihan kami yang dirancang khusus untuk melengkapi gaya hidup Anda.</p>
    </div>
</header>

{{-- REVISI: Area Search & Filter --}}
<form action="{{ route('user.products') }}" method="GET">
    <div class="search-section">
        <div class="search-wrapper">
            <div>
                <div class="filter-title">Cari Produk</div>
            </div>
            
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari koleksi kami..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="toolbar">
            <button type="submit" name="category" value="" class="filter-btn {{ !request('category') ? 'active' : '' }}">Semua Barang</button>
            @foreach ($categories as $cat)
                <button type="submit" name="category" value="{{ $cat->id }}" class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>
</form>

<main class="main-container">
    <div class="zada-grid">
        @forelse ($products as $product)
            <div class="zada-card">
                {{-- 1. KATEGORI --}}
                <div class="category-badge">
                    {{ $product->category->name ?? 'Furniture' }}
                </div>
                
                {{-- 2. GAMBAR & LINK --}}
                <a href="{{ route('user.products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </a>
                
                {{-- 3. HARGA --}}
                <div class="price-badge">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                {{-- 4. NAMA PRODUK --}}
                <a href="{{ route('user.products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <h3 class="product-name">{{ $product->name }}</h3>
                </a>
                
                {{-- 5. STOK --}}
                <div class="stock-info {{ $product->stock <= 5 ? 'stock-critical' : '' }}">
                    @if($product->stock > 0)
                        <i class="bi bi-box-seam"></i> Stok: {{ $product->stock }} Tersisa
                    @else
                        <span style="color: #ff6b6b;"><i class="bi bi-x-circle"></i> Habis</span>
                    @endif
                </div>

                {{-- 6. ADD TO CART BUTTON --}}
                <form method="POST" action="{{ route('cart.store') }}" style="width: 100%;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-to-cart-btn" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? '+ Tambah ke Keranjang' : 'Habis' }}
                    </button>
                </form>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 100px 0; opacity: 0.3;">
                <i class="bi bi-wind" style="font-size: 60px;"></i>
                <p style="margin-top: 20px; font-size: 18px;">No masterpieces found in this collection.</p>
            </div>
        @endforelse
    </div>
</main>

<footer style="padding: 60px 10%; background: rgba(0,0,0,0.2); text-align: center; border-top: 1px solid var(--glass-border);">
    <div style="font-family: 'Playfair Display', serif; font-size: 24px; margin-bottom: 10px;">ZADA.CO</div>
    <p style="font-size: 11px; opacity: 0.3; letter-spacing: 2px;">&copy; 2024 LUXURY INTERIOR GROUP. ALL RIGHTS RESERVED.</p>
</footer>

@endsection