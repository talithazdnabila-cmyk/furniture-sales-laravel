<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard') | ZADA.CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --accent: #e8b86d; /* Gold ZADA */
            --dark: #121212;
            --soft-bg: #f4f6f8;
            --grey: #8e8e93;
            --white: #ffffff;
        }

        body {
            background-color: var(--soft-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            background: var(--white);
            border-radius: 30px;
            height: calc(100vh - 40px);
            position: sticky;
            top: 20px;
            border: none;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            z-index: 1000;
        }

        .brand-section {
            padding: 30px 20px;
            text-align: center;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 3px;
            font-size: 24px;
            margin-bottom: 0;
            color: var(--accent); /* Tulisan ZADA warna Gold */
        }

        .brand-name span {
            font-weight: 900;
            filter: brightness(0.9); /* Membuat .CO sedikit lebih tegas */
        }

        .admin-profile-card {
            background: #fdfaf5;
            margin: 0 20px 20px 20px;
            padding: 15px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(232, 184, 109, 0.1);
        }

        .admin-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
            margin-bottom: 10px;
        }

        .sidebar-scroll {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 15px;
        }

        .sidebar a {
            color: #666;
            border-radius: 14px;
            padding: 11px 15px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all .3s ease;
            font-size: 13.5px;
            font-weight: 500;
            position: relative;
        }

        .sidebar a i { 
            margin-right: 12px; 
            font-size: 18px; 
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #fdfaf5;
            color: var(--dark);
            transform: translateX(5px);
        }

        .sidebar a:hover i {
            color: var(--accent);
        }

        /* --- MENU ACTIVE STATE --- */
        .sidebar a.active {
            background: var(--dark);
            color: var(--white);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .sidebar a.active i {
            color: var(--accent) !important; /* Ikon Jadi Gold */
            text-shadow: 0 0 8px rgba(232, 184, 109, 0.6); /* Efek Menyala */
        }

        .sidebar a.active::after {
            content: "";
            position: absolute;
            right: 10px;
            width: 5px;
            height: 5px;
            background: var(--accent);
            border-radius: 50%;
        }

        .menu-title {
            font-size: 10px;
            font-weight: 800;
            color: #bbb;
            margin: 20px 0 8px 15px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* --- CONTENT CARD (FRAME PUTIH) --- */
        .main-card {
            background: var(--white);
            border-radius: 25px;
            padding: 35px;
            min-height: 80vh;
            box-shadow: 0 10px 40px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .btn-logout {
            background: #fff0f0;
            color: #ff4d4d;
            border: none;
            padding: 12px;
            border-radius: 15px;
            width: 100%;
            font-weight: 700;
            font-size: 13px;
            transition: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout:hover { 
            background: #ff4d4d; 
            color: #fff; 
            transform: translateY(-2px);
        }

        /* Custom Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    <div class="row">

        <div class="col-lg-2 col-md-3">
            <div class="sidebar">
                <div class="brand-section">
                    <h1 class="brand-name">ZADA<span>.CO</span></h1>
                    <small style="letter-spacing: 2px; color: var(--grey); font-size: 9px; font-weight: 700;">ADMINISTRATION</small>
                </div>

                <div class="admin-profile-card">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('admin_photo/' . Auth::user()->photo) }}" class="admin-avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e8b86d&color=fff" class="admin-avatar">
                    @endif

                    <p class="mb-0 fw-bold" style="font-size: 13px;">{{ Auth::user()->name }}</p>
                    <span style="font-size: 11px; color: var(--grey);">{{ ucfirst(Auth::user()->role) }}</span>
                </div>

                <div class="sidebar-scroll">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>

                    <a href="{{ route('admin.profile.index') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>

                    <div class="menu-title">Data Master</div>
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i> Kategori
                    </a>
                    <a href="{{ route('admin.suppliers.index') }}" class="{{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Supplier
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>

                    <div class="menu-title">Transaksi</div>
                    <a href="{{ route('admin.transaksi.create') }}" class="{{ request()->routeIs('admin.transaksi.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i> Transaksi Masuk
                    </a>
                    <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.index') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i> Semua Transaksi
                    </a>
                    <a href="{{ route('admin.transaksi.payment-proofs') }}" class="{{ request()->routeIs('admin.transaksi.payment-proofs') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check"></i> Verifikasi Bukti Transfer
                    </a>

                    <div class="menu-title">Pengiriman</div>
                    <a href="{{ route('admin.pengiriman.index') }}" class="{{ request()->routeIs('admin.pengiriman.*') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt-fill"></i> Kelola Pengiriman
                    </a>

                    <div class="menu-title">Laporan</div>
                    <a href="{{ route('admin.reports.sales') }}" class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
                    </a>
                </div>

                <div class="p-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 col-md-9 px-lg-4">
            <div class="d-flex justify-content-between align-items-center py-3 mb-3">
                <h4 class="fw-bold m-0" style="font-family: 'Playfair Display', serif; letter-spacing: 1px;">@yield('title')</h4>
                <div class="text-end">
                    <small class="text-muted d-block" style="font-size: 10px; font-weight: 700; letter-spacing: 1px;">SISTEM KENDALI</small>
                    <span class="fw-bold" style="color: var(--dark);">{{ Auth::user()->name }}</span>
                </div>
            </div>

            {{-- Flash Message Notification --}}
            @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: #e6fcf5; border: 1px solid #0ca678; color: #0ca678; border-radius: 12px;">
                <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                    <i class="bi bi-check-circle-fill" style="font-size: 18px;"></i>
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: #ffe6e6; border: 1px solid #ff4d4d; color: #ff4d4d; border-radius: 12px;">
                <div style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                    <i class="bi bi-x-circle-fill" style="font-size: 18px;"></i>
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="main-card">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>