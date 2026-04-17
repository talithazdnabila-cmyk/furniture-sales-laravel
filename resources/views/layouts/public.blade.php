<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ZADA.CO | Timeless Elegance')</title>
    
    {{-- Google Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-zada: #1e1b18; 
            --accent-zada: #e8b86d;
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

        /* ===== FOOTER ===== */
        .zada-footer {
            background: rgba(0,0,0,0.2);
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 60px 10%;
            text-align: center;
            margin-top: 80px;
        }

        .zada-footer .brand {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: #fff;
            margin-bottom: 10px;
        }

        .zada-footer p {
            font-size: 10px;
            opacity: 0.3;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-wrap: wrap;
            }

            .nav-menu {
                flex-wrap: wrap;
                gap: 20px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="bg-watermark">ZADA.CO</div>

    {{-- NAVBAR --}}
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
            @else
                <li><a href="{{ route('user.transactions.index') }}">Pesanan Saya</a></li>
                <li style="margin-left: auto;">
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-login">Keluar</button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer class="zada-footer">
        <div class="brand">ZADA<span style="color:var(--accent-zada)">.CO</span></div>
        <p>&copy; 2024 LUXURY INTERIOR GROUP. ALL RIGHTS RESERVED.</p>
    </footer>
</body>
</html>
