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

    /* Navbar */
    .navbar {
        background: rgba(30, 27, 24, 0.8);
        backdrop-filter: blur(15px);
        padding: 25px 80px;
        display: flex; justify-content: space-between; align-items: center;
        position: sticky; top: 0; z-index: 1000;
        border-bottom: 1px solid var(--glass-border);
    }
    
    .brand-logo {
        font-family: 'Playfair Display', serif;
        font-size: 24px; font-weight: 800; letter-spacing: 2px;
        color: #fff; text-decoration: none;
    }

    .nav-menu { display: flex; list-style: none; gap: 35px; margin: 0; align-items: center; }
    .nav-menu a { 
        text-decoration: none; color: rgba(255,255,255,0.6); 
        font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    }
    .nav-menu a:hover { color: var(--accent-zada); }

    /* REVISI: Header & Masterpieces Section */
    .masterpiece-header {
        padding: 80px 10% 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 30px;
    }

    .masterpiece-title h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(40px, 5vw, 60px);
        margin: 0;
        line-height: 1;
    }

    .masterpiece-title p {
        color: var(--accent-zada);
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    /* REVISI: Search Bar Glassmorphism */
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

    .search-icon {
        position: absolute;
        left: 20px; top: 50%;
        transform: translateY(-50%);
        color: var(--accent-zada);
        font-size: 18px;
    }

    /* Toolbar Filter */
    .toolbar {
        padding: 0 10%;
        margin-bottom: 50px;
        display: flex; gap: 12px;
        overflow-x: auto;
    }
    .toolbar::-webkit-scrollbar { display: none; }

    .filter-btn {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: rgba(255,255,255,0.5);
        padding: 10px 25px;
        border-radius: 50px;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; cursor: pointer;
        white-space: nowrap; transition: 0.3s;
    }
    .filter-btn.active, .filter-btn:hover {
        background: var(--accent-zada);
        color: #000; border-color: var(--accent-zada);
    }

    /* Product Grid */
    .main-container { padding: 0 10% 100px; }
    .zada-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .zada-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 24px; padding: 25px;
        text-decoration: none; color: #fff;
        transition: 0.4s; display: flex; flex-direction: column;
    }

    .zada-card:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: var(--accent-zada);
        transform: translateY(-10px);
    }

    .category-label {
        color: var(--accent-zada);
        font-size: 10px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .img-box {
        width: 100%; height: 220px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
    }
    .img-box img {
        max-width: 100%; max-height: 100%; object-fit: contain;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
    }

    .price-tag { font-size: 18px; font-weight: 800; color: var(--accent-zada); margin-bottom: 5px; }
    .product-name { font-family: 'Playfair Display', serif; font-size: 22px; margin: 0 0 15px 0; }

    .stock-status {
        margin-top: auto; padding-top: 15px;
        border-top: 1px solid var(--glass-border);
        font-size: 11px; display: flex; justify-content: space-between; opacity: 0.6;
    }

    .logout-btn {
        background: transparent; border: 1px solid var(--accent-zada);
        color: var(--accent-zada); padding: 8px 20px; border-radius: 4px;
        font-size: 11px; font-weight: 700; cursor: pointer;
    }
</style>

<div class="bg-watermark">ZADA.CO</div>

<nav class="navbar">
    <a href="{{ route('user.dashboard') }}" class="brand-logo">ZADA<span style="color:var(--accent-zada)">.CO</span></a>
    <ul class="nav-menu">
        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
        <li><a href="{{ url('/products') }}" style="color: var(--accent-zada)">Collection</a></li>
        <li><a href="{{ route('user.transactions.index') }}">Orders</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">LOGOUT</button>
    </form>
</nav>

{{-- REVISI: Area Masterpieces & Search --}}
<form action="{{ url('/products') }}" method="GET">
    <header class="masterpiece-header">
        <div class="masterpiece-title">
            <p>Exclusive Furniture</p>
            <h1>Our Masterpieces</h1>
        </div>
        
        <div class="search-container">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="search" class="search-input" placeholder="Search our collection..." value="{{ request('search') }}">
        </div>
    </header>

    <div class="toolbar">
        <button type="submit" name="category" value="" class="filter-btn {{ !request('category') ? 'active' : '' }}">All Pieces</button>
        @foreach ($categories as $cat)
            <button type="submit" name="category" value="{{ $cat->id }}" class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>
</form>

<main class="main-container">
    <div class="zada-grid">
        @forelse ($products as $product)
            <a href="{{ route('user.products.show', $product->id) }}" class="zada-card">
                <span class="category-label">{{ $product->category->name ?? 'Exquisite' }}</span>
                
                <div class="img-box">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>

                <div class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <h3 class="product-name">{{ $product->name }}</h3>
                
                <div class="stock-status">
                    <span><i class="bi bi-layers"></i> {{ $product->stock > 0 ? 'In Stock' : 'Sold Out' }}</span>
                    <span>Qty: {{ $product->stock }}</span>
                </div>
            </a>
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