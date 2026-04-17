<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ZADA.CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        .login-screen {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            height: 100vh;
        }

        /* --- LEFT SECTION (Identik dengan Register) --- */
        .left {
            background: url('https://i.pinimg.com/736x/a1/9b/11/a19b114b050e877f9ef3888da44bfa6f.jpg') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
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
            padding: 80px;
            background: var(--soft-bg);
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 6px;
            margin-bottom: 50px;
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
            margin-bottom: 35px;
            font-weight: 400;
        }

        /* Input Styling (Identik dengan Register) */
        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            color: #444;
        }

        input {
            width: 100%;
            padding: 14px 0;
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

        /* Password Toggle Button */
        .password-input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 0;
            bottom: 5px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--grey);
            font-size: 18px;
            padding: 0;
            width: auto;
            margin: 0;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--accent);
        }

        /* Error Alert Styling */
        .alert {
            padding: 14px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            animation: slideDown 0.3s ease-in-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background-color: #fee5e5;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
            display: block;
        }

        input.input-error {
            border-bottom-color: #dc3545 !important;
        }

        /* Button Styling */
        button {
            width: 100%;
            padding: 18px;
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
            margin-top: 20px;
        }

        button:hover {
            background: var(--accent);
            box-shadow: 0 10px 20px rgba(232, 184, 109, 0.2);
        }

        .footer-link {
            margin-top: 30px;
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

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .login-screen { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 40px; }
        }
    </style>
</head>
<body>

<div class="login-screen">

    {{-- LEFT SECTION --}}
    <div class="left">
        <div class="left-content">
            <h2>ZADA.CO</h2>
        </div>
    </div>

    {{-- RIGHT SECTION --}}
    <div class="right">
        <div class="form-container">
            <span class="brand-logo">ZADA.CO</span>

            <h1>Welcome Back</h1>
            <div class="subtitle">Please enter your credentials to log in.</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $errors->first('email') ?? $errors->first() }}
                    </div>
                @endif

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Masukan Email Anda" value="{{ old('email') }}" required autofocus class="{{ $errors->has('email') ? 'input-error' : '' }}">
                </div>

                <div class="input-group password-input-group">
                    <label>Security Key</label>
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required class="{{ $errors->has('password') ? 'input-error' : '' }}">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" title="Tampilkan/Sembunyikan Password">
                        <i class="bi bi-eye-fill" id="passwordIcon"></i>
                    </button>
                </div>

                <button type="submit">Sign In</button>

                <div class="footer-link">
                    Don't have an account?
                    <a href="{{ route('register') }}">Buat Akun</a>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye-fill');
            passwordIcon.classList.add('bi-eye-slash-fill');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-slash-fill');
            passwordIcon.classList.add('bi-eye-fill');
        }
    }
</script>

</body>
</html>