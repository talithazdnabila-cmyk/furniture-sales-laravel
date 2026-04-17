@extends('layouts.user')

@section('title', 'Finalisasi Pembelian - ZADA.CO')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-zada: #1e1b18; 
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-hover: rgba(255, 255, 255, 0.07);
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-zada); 
        color: #f4f1ee;
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

    /* ===== HERO ZADA ===== */
    .hero-zada {
        display: none;
    }

    .checkout-container { 
        max-width: 1200px; 
        margin: 120px auto 40px; 
        padding: 0 20px; 
    }

    .checkout-wrapper {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        align-items: start;
    }

    .checkout-form-section {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 40px;
        backdrop-filter: blur(10px);
    }

    .checkout-form-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        margin: 0 0 30px 0;
        text-align: left;
    }

    .form-section {
        margin-bottom: 35px;
        padding-bottom: 35px;
        border-bottom: 1px solid var(--glass-border);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--accent-zada);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .input-group { margin-bottom: 18px; }
    .input-group:last-child { margin-bottom: 0; }

    .input-group label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        margin-bottom: 8px;
    }

    /* Styling Input, Textarea, dan Select */
    .input-group input,
    .input-group textarea,
    .input-group select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 6px;
        border: 1px solid var(--glass-border);
        background: rgba(255,255,255,0.02);
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-group textarea {
        min-height: 100px;
        line-height: 1.5;
        resize: none;
    }

    .input-group select option {
        background-color: var(--bg-zada);
        color: white;
    }

    .input-group input:focus,
    .input-group textarea:focus,
    .input-group select:focus {
        border-color: var(--accent-zada);
        background: var(--glass-hover);
        box-shadow: 0 0 12px rgba(232, 184, 109, 0.08);
    }

    /* ORDER SUMMARY SIDEBAR */
    .order-summary {
        display: none;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 30px;
        backdrop-filter: blur(10px);
        height: fit-content;
        position: sticky;
        top: 200px;
    }

    .summary-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--accent-zada);
    }

    .product-summary {
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--glass-border);
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .summary-detail {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 8px;
        opacity: 0.8;
    }

    .summary-detail strong {
        opacity: 1;
    }

    .payment-summary {
        padding-top: 20px;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 13px;
        opacity: 0.7;
    }

    .payment-row strong {
        opacity: 1;
    }

    .payment-row.total-row {
        opacity: 1;
        font-size: 16px;
        color: var(--accent-zada);
        font-weight: 800;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--glass-border);
    }

    .btn-primary {
        background: var(--accent-zada);
        color: #1e1b18;
        padding: 15px 30px;
        border-radius: 6px;
        border: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 12px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(232, 184, 109, 0.25);
        filter: brightness(1.08);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
        margin-bottom: 35px;
    }

    .btn-back:hover {
        color: var(--accent-zada);
    }

    @media (max-width: 768px) {
        .checkout-form-section {
            max-width: 100%;
        }
        
        .checkout-wrapper {
            grid-template-columns: 1fr;
        }
        
        .order-summary {
            display: none;
        }
    }

    .step-indicator {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        align-items: center;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
    }

    .step.active {
        color: var(--accent-zada);
    }

    .step-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .step.active .step-number {
        background: var(--accent-zada);
        color: #1e1b18;
        border-color: var(--accent-zada);
    }

    .step-divider {
        flex: 1;
        height: 1px;
        background: var(--glass-border);
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-secondary {
        background: transparent;
        border: 1px solid var(--glass-border);
        color: rgba(255,255,255,0.7);
        padding: 15px 30px;
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        border-color: var(--accent-zada);
        color: var(--accent-zada);
    }

    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-group .btn-primary,
    .btn-group .btn-secondary {
        flex: 1;
        width: 100%;
    }
</style>

<div class="bg-watermark">ZADA.CO</div>

<div class="checkout-container">
    <div class="checkout-wrapper">
        <div class="checkout-form-section">
            {{-- STEP INDICATOR --}}
            <div class="step-indicator">
                <div class="step active" id="step1-ind">
                    <div class="step-number">1</div>
                    <span>Pengiriman</span>
                </div>
                <div class="step-divider"></div>
                <div class="step" id="step2-ind">
                    <div class="step-number">2</div>
                    <span>Konfirmasi</span>
                </div>
            </div>

            <form method="POST" action="{{ route('user.checkout.confirm') }}" id="checkoutForm">
                @csrf
                
                {{-- STEP 1: INFORMASI PENGIRIMAN --}}
                <div class="form-step active" id="step1">
                    <h2>Informasi Pengiriman</h2>

                    {{-- SECTION 1: PENERIMA --}}
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-person-fill"></i> Data Penerima
                        </div>

                        <div class="input-group">
                            <label>Nama Penerima</label>
                            <input type="text" name="nama_penerima" value="{{ Auth::user()->name }}" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="input-group">
                            <label>Nomor Telepon</label>
                            <input type="text" name="no_telepon" placeholder="Contoh: 08123456789" required>
                        </div>
                    </div>

                    {{-- SECTION 2: ALAMAT --}}
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-geo-alt-fill"></i> Alamat Pengiriman
                        </div>

                        <div class="input-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" placeholder="Masukkan detail alamat, nomor rumah, dan patokan..." required></textarea>
                        </div>

                        <div class="input-group">
                            <label>Kota Tujuan</label>
                            <select name="shipping_city_id" id="shipping_city" required onchange="hitungOngkir()">
                                <option value="" disabled selected>-- Pilih Kota Tujuan --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" data-cost="{{ $city->shipping_cost }}">
                                        {{ $city->city_name }} 
                                        @if($city->shipping_cost == 0)
                                            (Gratis Ongkir)
                                        @else
                                            (+Rp {{ number_format($city->shipping_cost,0,',','.') }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- SECTION 3: CATATAN --}}
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-chat-left-text-fill"></i> Catatan Pesanan
                        </div>

                        <div class="input-group">
                            <label>Catatan (Opsional)</label>
                            <textarea name="catatan" placeholder="Tambahkan catatan atau permintaan khusus untuk pesanan Anda..." style="min-height: 80px;"></textarea>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn-primary" onclick="goToStep(2)">
                            Lanjut ke Konfirmasi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                {{-- STEP 2: RINGKASAN & PEMBAYARAN --}}
                <div class="form-step" id="step2">
                    <h2>Ringkasan Pesanan</h2>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-package"></i> Detail Produk
                        </div>
                        <div class="input-group" style="border: 1px solid var(--glass-border); padding: 20px; border-radius: 6px; background: rgba(255,255,255,0.01);">
                            @if(isset($cartItems) && $cartItems->isNotEmpty())
                                {{-- Checkout dari Cart --}}
                                @foreach($cartItems as $item)
                                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--glass-border);">
                                        <div style="font-family: 'Playfair Display', serif; font-size: 14px; margin-bottom: 10px;">{{ $item->product->name }}</div>
                                        <div class="summary-detail">
                                            <span>Harga Satuan:</span>
                                            <strong>Rp {{ number_format($item->product->price, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="summary-detail">
                                            <span>Jumlah:</span>
                                            <strong>{{ $item->quantity }} Pcs</strong>
                                        </div>
                                        <div class="summary-detail">
                                            <span>Subtotal:</span>
                                            <strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Checkout dari Product Detail --}}
                                <div style="font-family: 'Playfair Display', serif; font-size: 16px; margin-bottom: 15px;">{{ $product->name }}</div>
                                <div class="summary-detail">
                                    <span>Harga Satuan:</span>
                                    <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                </div>
                                <div class="summary-detail">
                                    <span>Jumlah:</span>
                                    <strong>{{ $checkout['qty'] }} Pcs</strong>
                                </div>
                                <div class="summary-detail" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--glass-border);">
                                    <span>Subtotal:</span>
                                    <strong>Rp {{ number_format($product->price * $checkout['qty'], 0, ',', '.') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-truck"></i> Pengiriman
                        </div>
                        <div class="input-group" style="border: 1px solid var(--glass-border); padding: 20px; border-radius: 6px; background: rgba(255,255,255,0.01);">
                            <div class="summary-detail">
                                <span>Ke:</span>
                                <strong id="confirm-city">-</strong>
                            </div>
                            <div class="summary-detail">
                                <span>Penerima:</span>
                                <strong id="confirm-name">-</strong>
                            </div>
                            <div class="summary-detail">
                                <span>Ongkos Kirim:</span>
                                <strong id="confirm-ongkir">Rp 0</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-cash-coin"></i> Total Pembayaran
                        </div>
                        <div style="background: linear-gradient(135deg, rgba(232,184,109,0.1), rgba(232,184,109,0.05)); border: 1px solid var(--accent-zada); padding: 20px; border-radius: 6px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Total Pesanan:</span>
                                <span style="font-size: 28px; font-weight: 800; color: var(--accent-zada);" id="confirm-total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn-secondary" onclick="goToStep(1)">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-credit-card"></i> Konfirmasi & Bayar
                        </button>
                    </div>
                </div>

                @if(isset($cartItems) && $cartItems->isNotEmpty())
                    <input type="hidden" id="hargaProduk" value="{{ $total }}">
                @else
                    <input type="hidden" id="hargaProduk" value="{{ $product->price * $checkout['qty'] }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="{{ $checkout['qty'] }}">
                @endif
            </form>
        </div>

        {{-- ORDER SUMMARY SIDEBAR --}}
        <div class="order-summary">
            <div class="summary-title">Ringkasan Pesanan</div>

            <div class="product-summary">
                @if(isset($cartItems) && $cartItems->isNotEmpty())
                    {{-- Cart Summary --}}
                    @foreach($cartItems as $item)
                        <div style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div class="product-name" style="font-size: 13px;">{{ $item->product->name }}</div>
                            <div class="summary-detail" style="font-size: 12px;">
                                <span>{{ $item->quantity }} Pcs</span>
                                <strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Product Detail Summary --}}
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="summary-detail">
                        <span>Harga Satuan:</span>
                        <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                    </div>
                    <div class="summary-detail">
                        <span>Jumlah:</span>
                        <strong>{{ $checkout['qty'] }} Pcs</strong>
                    </div>
                @endif
            </div>

            <div class="payment-summary">
                <div class="payment-row">
                    <span>Subtotal</span>
                    <strong>
                        @if(isset($cartItems) && $cartItems->isNotEmpty())
                            Rp {{ number_format($total, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($product->price * $checkout['qty'], 0, ',', '.') }}
                        @endif
                    </strong>
                </div>
                <div class="payment-row">
                    <span>Ongkos Kirim</span>
                    <strong id="sidebar-ongkir">Rp 0</strong>
                </div>
                <div class="payment-row total-row">
                    <span>Total</span>
                    <span id="sidebar-total">
                        @if(isset($cartItems) && $cartItems->isNotEmpty())
                            Rp {{ number_format($total, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($product->price * $checkout['qty'], 0, ',', '.') }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;

function goToStep(step) {
    // Validasi step 1 sebelum lanjut ke step 2
    if (step === 2 && currentStep === 1) {
        if (!validateStep1()) {
            alert('Silakan lengkapi semua informasi pengiriman terlebih dahulu.');
            return;
        }
        updateConfirmationSummary();
    }

    // Hide current step
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.getElementById(`step${currentStep}-ind`).classList.remove('active');

    // Show next step
    currentStep = step;
    document.getElementById(`step${currentStep}`).classList.add('active');
    document.getElementById(`step${currentStep}-ind`).classList.add('active');

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep1() {
    const form = document.getElementById('checkoutForm');
    const namaPenerima = form.querySelector('input[name="nama_penerima"]').value.trim();
    const noTelepon = form.querySelector('input[name="no_telepon"]').value.trim();
    const alamat = form.querySelector('textarea[name="alamat"]').value.trim();
    const shippingCity = form.querySelector('select[name="shipping_city_id"]').value;

    return namaPenerima && noTelepon && alamat && shippingCity;
}

function updateConfirmationSummary() {
    const form = document.getElementById('checkoutForm');
    
    // Get values
    const namaPenerima = form.querySelector('input[name="nama_penerima"]').value;
    const shippingCitySelect = form.querySelector('select[name="shipping_city_id"]');
    const cityName = shippingCitySelect.options[shippingCitySelect.selectedIndex].text.split('(')[0].trim();
    const ongkir = parseInt(shippingCitySelect.options[shippingCitySelect.selectedIndex].getAttribute('data-cost')) || 0;
    const hargaProduk = parseInt(document.getElementById('hargaProduk').value);
    const total = hargaProduk + ongkir;

    // Update confirmation section
    document.getElementById('confirm-name').textContent = namaPenerima;
    document.getElementById('confirm-city').textContent = cityName;
    document.getElementById('confirm-ongkir').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('confirm-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

    // Update sidebar
    document.getElementById('sidebar-ongkir').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('sidebar-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function hitungOngkir() {
    var select = document.getElementById("shipping_city");
    var selected = select.options[select.selectedIndex];

    var ongkir = parseInt(selected.getAttribute("data-cost")) || 0;
    var hargaProduk = parseInt(document.getElementById("hargaProduk").value);
    var total = hargaProduk + ongkir;

    document.getElementById("sidebar-ongkir").innerHTML = "Rp " + ongkir.toLocaleString('id-ID');
    document.getElementById("sidebar-total").innerHTML = "Rp " + total.toLocaleString('id-ID');
}

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    var cityId = document.getElementById("shipping_city").value;
    if (!cityId) {
        e.preventDefault();
        alert('Silakan pilih kota tujuan terlebih dahulu.');
    }
});
</script>

@endsection