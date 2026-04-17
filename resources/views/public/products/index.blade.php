@extends('layouts.public')

@section('title', 'Koleksi - ZADA.CO | Timeless Elegance')

@section('styles')
<style>
    :root {
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* ===== SEARCH & FILTER ===== */
    .search-section {
        padding: 40px 10%;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 30px;
    }

    .filter-title {
        color: var(--accent-zada);
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .search-container {
        position: relative;
        min-width: 350px;
    }

    .search-input {
        width: 100%;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        padding: 15px 20px 15px 50px;
        border-radius: 12px;
        color: #fff;
        font-family: inherit;
        transition: 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent-zada);
        background: rgba(255,255,255,0.07);
    }

    .search-input::placeholder {
        color: rgba(255,255,255,0.3);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent-zada);
        font-size: 18px;
    }

    /* Toolbar Filter */
    .toolbar {
        padding: 0 10%;
        margin-bottom: 50px;
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }

    .filter-btn {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: rgba(255,255,255,0.5);
        padding: 10px 25px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.3s;
    }

    .filter-btn.active, .filter-btn:hover {
        background: var(--accent-zada);
        color: #000;
        border-color: var(--accent-zada);
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
        cursor: pointer;
    }

    .zada-card:hover {
        border-color: var(--accent-zada);
        background: rgba(232, 184, 109, 0.05);
        transform: translateY(-5px);
    }

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
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--accent-zada);
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

    .stock-info {
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: auto;
    }

    /* Guest CTA */
    .guest-cta {
        background: linear-gradient(rgba(30, 27, 24, 0.9), rgba(30, 27, 24, 0.9)),
                url('https://i.pinimg.com/736x/96/5d/37/965d37fe1bc7f26cf32dba9b205bc23c.jpg');
        background-size: cover;
        background-position: center;
        border: 1px solid rgba(232, 184, 109, 0.3);
        border-radius: 15px;
        padding: 60px 40px;
        text-align: center;
        margin: 50px 10%;
        position: relative;
        overflow: hidden;
    }

    .guest-cta h2 {
        font-family: 'Playfair Display', serif;
        color: var(--accent-zada);
        font-size: 28px;
        margin-bottom: 15px;
    }

    .guest-cta p {
        opacity: 0.8;
        max-width: 600px;
        margin: 0 auto 30px auto;
        line-height: 1.6;
    }

    .btn-zada-gold {
        background: var(--accent-zada);
        color: #1e1b18;
        padding: 12px 30px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        transition: 0.3s;
        display: inline-block;
        border: none;
        cursor: pointer;
    }

    .btn-zada-gold:hover {
        background: #d4a857;
    }

    .btn-zada-outline {
        background: transparent;
        color: var(--accent-zada);
        border: 1px solid var(--accent-zada);
        padding: 12px 30px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        transition: 0.3s;
        display: inline-block;
        margin-left: 15px;
        cursor: pointer;
    }

    .btn-zada-outline:hover {
        background: var(--accent-zada);
        color: #000;
    }

    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 100px 0;
        opacity: 0.3;
    }

    .empty-state i {
        font-size: 60px;
    }

    .empty-state p {
        margin-top: 20px;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .search-section {
            padding: 30px 20px;
        }

        .search-container {
            min-width: 100%;
        }

        .toolbar {
            padding: 0 20px;
            margin-bottom: 30px;
        }

        .main-container {
            padding: 0 20px 60px;
        }

        .zada-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
    }
</style>
@endsection

@section('content')
{{-- SEARCH & FILTER --}}
<form action="{{ url('/products') }}" method="GET">
    <div class="search-section">
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
</form>

{{-- PRODUCTS GRID --}}
<main class="main-container">
    <div class="zada-grid">
        @forelse ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="zada-card">
                <span class="category-label">{{ $product->category->name ?? 'Furniture' }}</span>
                
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

                <div class="price-badge">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <h3 class="product-name">{{ $product->name }}</h3>
                
                <div class="stock-info">
                    <span><i class="bi bi-layers"></i> {{ $product->stock > 0 ? 'Tersedia' : 'Habis Terjual' }}</span>
                    <span>Qty: {{ $product->stock }}</span>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <i class="bi bi-wind"></i>
                <p>Tidak ada koleksi yang ditemukan.</p>
            </div>
        @endforelse
    </div>
</main>

{{-- GUEST CTA --}}
@guest
    <section class="guest-cta">
        <h2>Tertarik untuk Berbelanja?</h2>
        <p>Buat akun Anda sekarang dan nikmati pengalaman berbelanja furniture mewah ZADA.CO yang eksklusif, dengan harga spesial dan kemudahan pembayaran.</p>
        <a href="{{ route('login') }}" class="btn-zada-outline">Masuk</a>
        <a href="{{ route('register') }}" class="btn-zada-gold">Daftar Sekarang</a>
    </section>
@endguest
@endsection
