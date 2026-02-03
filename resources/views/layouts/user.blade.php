<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User')</title>

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
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 16px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(10px);
            color: white;
            z-index: 100;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            opacity: .9;
            transition: .3s;
        }

        .navbar a:hover {
            opacity: 1;
            color: var(--accent);
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
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
            opacity: .85;
            transition: .3s;
        }

        .logout-btn:hover {
            color: var(--accent);
            opacity: 1;
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

    @yield('content')

</body>
</html>
