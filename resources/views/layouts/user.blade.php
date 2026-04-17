<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User')</title>
    
    {{-- Google Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #111;
            --accent: #e8b86d;
            --bg: #f4f6f8;
            --text: #333;
            --radius: 14px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #1e1b18;
            color: #f4f1ee;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(30, 27, 24, 0.8);
            backdrop-filter: blur(15px);
            color: white;
            z-index: 100;
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
            color: #e8b86d;
        }

        .brand-box .main-logo {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 35px;
            margin: 0;
        }

        .navbar a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            transition: .3s;
        }

        .navbar a:hover {
            color: #e8b86d;
        }

        .btn {
            background: white;
            color: black !important;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            transition: .3s;
            text-decoration: none;
        }

        .btn:hover {
            background: var(--accent);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #e8b86d;
            color: #e8b86d;
            padding: 8px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            transition: .3s;
        }

        .logout-btn:hover {
            background: #e8b86d;
            color: #1e1b18;
        }

        /* ================= HERO ================= */
        .hero {
            min-height: 100vh;
            background: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6')
                        center / cover no-repeat;
            padding: 140px 80px;
            position: relative;
            display: flex;
            align-items: center;
            margin-top: 70px;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to right,
                rgba(0,0,0,.50),
                rgba(0,0,0,.2)
            );
        }

        .hero-content {
            position: relative;
            color: white;
            max-width: 560px;
        }

        .hero-content h1 {
            font-size: 48px;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .hero-content p {
            font-size: 16px;
            opacity: .9;
            margin-bottom: 32px;
        }

        /* ================= PRODUCT ================= */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
            transition: .3s;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,.1);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            filter: brightness(1.08) contrast(1.05);
        }

        .product-card h5 {
            margin-top: 12px;
            font-size: 16px;
        }

        .product-card p {
            margin-top: 6px;
            font-weight: bold;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .navbar {
                padding: 16px 24px;
            }

            .hero {
                padding: 120px 24px;
            }

            .hero-content h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-left">
            <button class="back-btn" onclick="history.back()" title="Kembali">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="brand-box">
                <div class="main-logo">ZADA<span style="color:var(--accent)">.CO</span></div>
                <div style="font-size: 9px; letter-spacing: 3px; text-transform: uppercase; opacity: 0.6;">Timeless Elegance</div>
            </div>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li><a href="{{ route('user.products') }}">Koleksi</a></li>
            <li><a href="{{ route('cart.index') }}">Keranjang</a></li>
            <li><a href="{{ route('user.transactions.index') }}">Pesanan Saya</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">KELUAR</button>
                </form>
            </li>
        </ul>
    </nav>

    @yield('content')

</body>
</html>
