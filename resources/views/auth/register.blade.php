<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | ZADA.CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #e8b86d;
            --dark: #000;
            --soft-bg: #fdfdfd;
            --grey: #888;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            overflow: hidden;
        }

        .auth-screen {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            height: 100vh;
            width: 100%;
        }

        /* --- PERBAIKAN FOTO (SAMA DENGAN LOGIN) --- */
        .left {
            /* Menggunakan background-size: 100% auto atau cover dengan posisi fixed agar tidak zoom */
            background-image: url('https://i.pinimg.com/736x/a1/9b/11/a19b114b050e877f9ef3888da44bfa6f.jpg');
            background-position: center center;
            background-size: cover; /* Memastikan cover tetap konsisten */
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Mengunci tinggi agar tidak terpengaruh panjang form */
        }

        .left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.4));
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .left-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 400;
            letter-spacing: 2px;
        }

        /* --- RIGHT SECTION --- */
        .right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px; /* Dikurangi agar form tidak menarik tinggi gambar */
            background: var(--soft-bg);
            height: 100vh;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 360px; /* Sedikit diperkecil agar lebih rapi */
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 6px;
            margin-bottom: 40px;
            text-align: center;
            display: block;
            color: var(--dark);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .subtitle {
            color: var(--grey);
            font-size: 14px;
            margin-bottom: 25px;
            font-weight: 400;
        }

        .input-group {
            margin-bottom: 15px; /* Jarak antar input dirapatkan agar form tidak terlalu panjang */
        }

        .input-group label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 5px;
            color: #444;
        }

        input {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            font-family: inherit;
            font-size: 14px;
            background: transparent;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus {
            border-bottom-color: var(--accent);
        }

        input::placeholder {
            color: #ccc;
            font-weight: 300;
        }

        button {
            width: 100%;
            padding: 16px;
            border-radius: 4px;
            border: none;
            background: var(--dark);
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            cursor: pointer;
            transition: 0.4s;
            margin-top: 15px;
        }

        button:hover {
            background: var(--accent);
            box-shadow: 0 10px 20px rgba(232, 184, 109, 0.2);
        }

        .footer-link {
            margin-top: 25px;
            text-align: center;
            font-size: 13px;
            color: var(--grey);
        }

        .footer-link a {
            color: var(--dark);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px solid var(--accent);
            padding-bottom: 2px;
            margin-left: 5px;
        }

        @media (max-width: 992px) {
            .auth-screen { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 40px; }
        }
    </style>
</head>
<body>

<div class="auth-screen">

    <div class="left">
        <div class="left-content">
            <h2>ZADA.CO</h2>
        </div>
    </div>

    <div class="right">
        <div class="form-container">
            <span class="brand-logo">ZADA.CO</span>

            <h1>Buat Akun</h1>
            <div class="subtitle">Join us to experience timeless elegance.</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Masukan Nama Lengkap" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Masukan Email Anda" value="{{ old('email') }}" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukan Password" required>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="konfirmasi password" required>
                </div>

                <button type="submit">Sign Up</button>

                <div class="footer-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>