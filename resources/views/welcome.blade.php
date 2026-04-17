<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZADA.CO | Timeless Elegance</title>
    
    {{-- Google Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-zada: #1e1b18; 
            --accent-zada: #e8b86d; /* Gold ZADA */
            --glass-zada: rgba(255, 255, 255, 0.03);
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-zada);
            color: #f4f1ee;
            overflow-x: hidden;
        }

        /* ===== BRAND WATERMARK BACKGROUND ===== */
        .bg-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 20vw;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.02);
            z-index: -1;
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
        }

        /* ===== NAVIGATION ===== */
        .navbar {
            background: rgba(30, 27, 24, 0.8);
            backdrop-filter: blur(15px);
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(232, 184, 109, 0.2);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .back-btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            padding: 0;
            margin-right: 10px;
            transition: .3s;
        }

        .back-btn:hover {
            color: var(--accent-zada);
        }
        
        .brand-box .main-logo {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
        }

        .nav-menu { 
            display: flex; 
            list-style: none; 
            gap: 35px; 
            margin: 0; 
            align-items: center; 
        }
        
        .nav-menu a { 
            text-decoration: none; 
            color: rgba(255,255,255,0.6); 
            font-size: 12px; 
            font-weight: 700; 
            text-transform: uppercase;
            transition: 0.3s;
        }
        
        .nav-menu a:hover { 
            color: var(--accent-zada); 
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-login {
            background: transparent;
            border: 1px solid var(--accent-zada);
            color: var(--accent-zada);
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: var(--accent-zada);
            color: #000;
        }

        .btn-register {
            background: var(--accent-zada);
            border: 1px solid var(--accent-zada);
            color: #000;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #d4a857;
            border-color: #d4a857;
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
        }

        .hero-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(40px, 6vw, 70px);
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .hero-text a {
            background: var(--accent-zada);
            color: #000;
            padding: 15px 40px;
            text-decoration: none;
            font-weight: 800;
            border-radius: 5px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .hero-text a:hover {
            background: #d4a857;
            transform: translateY(-2px);
        }

        /* ===== PRODUCT CARD ===== */
        .section-container { 
            padding: 80px 10%; 
        }
        
        .zada-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .zada-card {
            background: var(--glass-zada);
            border: 1px solid rgba(255,255,255,0.05);
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

        .category-badge {
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
        }

        .stock-critical {
            color: #ff6b6b;
        }

        .cta-zada {
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

        .cta-zada h2 {
            font-family: 'Playfair Display', serif;
            color: var(--accent-zada);
            font-size: 28px;
            margin-bottom: 15px;
        }

        .cta-zada p {
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
        }

        .btn-zada-outline {
            background: transparent;
            border: 1px solid var(--accent-zada);
            color: var(--accent-zada);
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 12px;
            margin-right: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                gap: 20px;
                width: 100%;
                justify-content: center;
            }

            .auth-buttons {
                width: 100%;
                justify-content: center;
            }

            .hero-zada {
                padding: 0 5%;
                height: auto;
                min-height: 70vh;
            }

            .hero-text h1 {
                font-size: 32px;
            }

            .section-container {
                padding: 40px 5%;
            }

            .zada-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-watermark">ZADA.CO</div>

    <nav class="navbar">
        <div class="navbar-left">
            <button class="back-btn" onclick="history.back()" title="Kembali">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="brand-box">
                <div class="main-logo">ZADA<span style="color:var(--accent-zada)">.CO</span></div>
                <div style="font-size: 9px; letter-spacing: 3px; text-transform: uppercase; opacity: 0.6;">Timeless Elegance</div>
            </div>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ url('/') }}">Beranda</a></li>
            <li><a href="{{ url('/products') }}">Koleksi</a></li>
            @guest
                <li style="margin-left: auto;">
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                        @endif
                    </div>
                </li>
            @endguest
        </ul>
    </nav>

    <header class="hero-zada">
        <div class="hero-text">
            <span style="color:var(--accent-zada); letter-spacing:5px; font-weight:800; font-size:14px; text-transform:uppercase;">Exclusive Interior</span>
            <h1>ZADA LUXURY<br>COLLECTION</h1>
            <p style="max-width: 450px; opacity: 0.7; line-height: 1.8; margin: 20px 0;">Menciptakan ruang istirahat yang tidak hanya indah dipandang, namun memberikan kenyamanan abadi bagi keluarga Anda.</p>
            <a href="{{ url('/products') }}">Jelajahi Koleksi</a>
        </div>
    </header>

    <main class="section-container">
        <section class="cta-zada">
            @auth
                {{-- Tampilan untuk User yang SUDAH Login --}}
                <h2>Selamat Datang Kembali, {{ Auth::user()->name }}</h2>
                <p>Terima kasih telah menjadi bagian dari komunitas eksklusif ZADA. Jelajahi koleksi terbaru kami yang baru saja tiba khusus untuk Anda.</p>
                <a href="{{ url('/products') }}" class="btn-zada-gold">Mulai Belanja Sekarang</a>
            @else
                {{-- Tampilan untuk User yang BELUM Login --}}
                <h2>Jelajahi Koleksi Terbaik Kami</h2>
                <p>Daftar atau masuk untuk melihat koleksi produk lengkap, harga khusus, dan kemudahan berbelanja furniture mewah.</p>
                <div style="display: flex; justify-content: center; gap: 15px;">
                    <a href="{{ route('login') }}" class="btn-zada-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-zada-gold">Daftar Sekarang</a>
                </div>
            @endauth
        </section>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; margin-top: 60px; border-left: 4px solid var(--accent-zada); padding-left: 20px;">
            <div>
                <h2 style="font-family: 'Playfair Display', serif; margin: 0; font-size: 32px;">Produk Baru</h2>
                <p style="margin: 0; opacity: 0.5; font-size: 13px;">Curated pieces from ZADA.CO studios</p>
            </div>
            <a href="{{ url('/products') }}" style="color: var(--accent-zada); font-weight: 700; text-decoration: none; font-size: 14px;">Lihat Semua &rarr;</a>
        </div>

        <div class="zada-grid">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="zada-card">
                    {{-- 1. KATEGORI --}}
                    <div class="category-badge">
                        {{ $product->category->name ?? 'Furniture' }}
                    </div>
                    
                    {{-- 2. GAMBAR --}}
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    
                    {{-- 3. HARGA --}}
                    <div class="price-badge">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    {{-- 4. NAMA PRODUK --}}
                    <h3 class="product-name">{{ $product->name }}</h3>
                    
                    {{-- 5. STOK --}}
                    <div class="stock-info {{ ($product->stock ?? 0) <= 5 ? 'stock-critical' : '' }}">
                        @if(($product->stock ?? 0) > 0)
                            <i class="bi bi-box-seam"></i> Stok: {{ $product->stock }} Tersisa
                        @else
                            <span style="color: #ff6b6b;"><i class="bi bi-x-circle"></i> Habis</span>
                        @endif
                    </div>

                    <div style="font-size: 9px; opacity: 0.2; letter-spacing: 2px; margin-top: 20px; text-transform: uppercase; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px;">
                        ZADA Authentic Collection
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <p style="opacity: 0.6;">Tidak ada produk tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer style="padding: 80px 10%; background: #161412; margin-top: 100px; text-align: center;">
        <div style="font-family: 'Playfair Display', serif; font-size: 30px; margin-bottom: 10px;">ZADA.CO</div>
        <p style="opacity: 0.4; font-size: 13px; max-width: 600px; margin: 0 auto 30px auto;">Defining modern luxury through exceptional craftsmanship and timeless furniture design since 2024.</p>
        <div style="height: 1px; background: rgba(255,255,255,0.05); margin-bottom: 30px;"></div>
        <p style="font-size: 11px; opacity: 0.3;">&copy; 2024 ZADA.CO Luxury Interior Group. All Rights Reserved.</p>
    </footer>
</body>
</html>