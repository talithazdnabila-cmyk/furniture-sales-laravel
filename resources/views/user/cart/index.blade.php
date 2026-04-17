@extends('layouts.user')

@section('title', 'Carts - ZADA.CO')

@section('content')
<style>
    :root {
        --bg-zada: #1e1b18;
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    body {
        background-color: var(--bg-zada);
        color: #f4f1ee;
    }

    .cart-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 5%;
        margin-top: 55px;
    }

    .cart-header {
        margin-bottom: 25px;
    }

    .cart-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        margin: 0 0 10px;
        color: #fff;
        font-weight: 700;
    }

    .cart-header p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }

    .empty-cart {
        text-align: center;
        padding: 100px 20px;
    }

    .empty-cart-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-cart p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 30px;
    }

    .btn-primary {
        display: inline-block;
        background: var(--accent-zada);
        color: #000;
        padding: 14px 40px;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 2px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(232, 184, 109, 0.3);
    }

    .cart-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    /* Select All Section */
    .select-all-box {
        background: linear-gradient(135deg, rgba(232, 184, 109, 0.1) 0%, rgba(232, 184, 109, 0.05) 100%);
        border: 1px solid var(--accent-zada);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .select-all-box:hover {
        background: linear-gradient(135deg, rgba(232, 184, 109, 0.15) 0%, rgba(232, 184, 109, 0.08) 100%);
    }

    .select-all-box label {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        margin: 0;
    }

    .select-all-box input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--accent-zada);
    }

    .select-all-box span {
        color: #fff;
        font-weight: 600;
        font-size: 14px;
    }

    /* Cart Items */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .cart-item {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .cart-item:hover {
        border-color: var(--accent-zada);
        background: rgba(232, 184, 109, 0.05);
        transform: translateX(4px);
    }

    .cart-item.unselected {
        opacity: 0.6;
    }

    .cart-item-checkbox {
        flex-shrink: 0;
        padding-top: 4px;
    }

    .cart-item-checkbox input {
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: var(--accent-zada);
    }

    .cart-item-image {
        flex-shrink: 0;
    }

    .cart-item-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .cart-item:hover .cart-item-image img {
        transform: scale(1.05);
    }

    .cart-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 120px;
    }

    .cart-item-info h3 {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        margin: 0 0 8px;
        color: #fff;
    }

    .cart-item-price {
        color: var(--accent-zada);
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 12px;
    }

    .cart-item-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 6px;
        overflow: hidden;
    }

    .qty-control button,
    .qty-control input {
        padding: 8px 12px;
        border: none;
        background: transparent;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .qty-control button {
        color: var(--accent-zada);
    }

    .qty-control button:hover:not(:disabled) {
        background: rgba(232, 184, 109, 0.1);
    }

    .qty-control button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-control input {
        width: 50px;
        text-align: center;
        border: 0;
        border-left: 1px solid var(--glass-border);
        border-right: 1px solid var(--glass-border);
    }

    .btn-delete {
        background: transparent;
        border: 1px solid rgba(255, 107, 107, 0.5);
        color: #ff6b6b;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-delete:hover {
        background: rgba(255, 107, 107, 0.1);
        border-color: #ff6b6b;
    }

    .cart-item-total {
        font-weight: 700;
        color: var(--accent-zada);
        font-size: 16px;
    }

    /* Order Summary */
    .order-summary {
        background: var(--bg-zada);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        order: 2;
        position: sticky;
        bottom: 20px;
        z-index: 40;
    }

    .order-summary h2 {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        margin: 0 0 15px;
        color: #fff;
        font-weight: 700;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2px 0;
        border-bottom: 1px solid var(--glass-border);
        font-size: 12px;
    }

    .summary-row:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
    }

    .summary-row span:first-child {
        color: rgba(255, 255, 255, 0.6);
    }

    .summary-row span:last-child {
        color: #fff;
        font-weight: 600;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0 0;
        margin-top: 10px;
        border-top: 2px solid var(--accent-zada);
        font-size: 16px;
        font-weight: 700;
    }

    .summary-total span:last-child {
        color: var(--accent-zada);
    }

    .summary-actions {
        display: flex;
        flex-direction: row;
        gap: 12px;
        margin-top: 15px;
        align-items: center;
        justify-content: flex-end;
    }

    .summary-actions > * {
        flex: none;
    }

    .summary-actions form {
        display: none;
    }

    .summary-actions form button {
        display: none;
    }

    .btn-checkout {
        flex: 1.5;
        background: var(--accent-zada);
        color: #000;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 9px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        white-space: nowrap;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(232, 184, 109, 0.3);
    }

    .btn-continue-shopping {
        flex: 1;
        background: transparent;
        color: var(--accent-zada);
        border: 1px solid var(--accent-zada);
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 9px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        white-space: nowrap;
    }

    .btn-continue-shopping:hover {
        color: #fff;
        background: rgba(232, 184, 109, 0.1);
    }

    /* Success Message */
    .success-alert {
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(232, 184, 109, 0.1);
        border: 1px solid var(--accent-zada);
        color: var(--accent-zada);
        padding: 16px 20px;
        border-radius: 8px;
        z-index: 50;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    @media (max-width: 768px) {
        .cart-container {
            padding: 30px 4%;
        }

        .cart-header h1 {
            font-size: 28px;
        }

        .cart-item {
            flex-direction: column;
            padding: 16px;
        }

        .cart-item-image img {
            width: 100%;
            height: 200px;
        }

        .summary-actions {
            flex-direction: row;
            justify-content: flex-end;
        }

        .summary-actions > * {
            width: auto;
            flex: none;
        }

        .cart-item-actions {
            width: 100%;
        }

        .btn-delete {
            width: 100%;
        }

        .btn-checkout {
            width: auto;
            padding: 8px 12px;
        }

        .btn-continue-shopping {
            width: auto;
            padding: 8px 12px;
        }
    }
</style>

<div class="cart-container">
    <!-- Header -->
    <div class="cart-header">
        <h1>Keranjang Belanja</h1>
        <p>Pilih pesanan Anda sebelum checkout</p>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Empty Cart -->
    @if ($cartItems->isEmpty())
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <p>Keranjang Anda kosong</p>
            <a href="{{ route('user.products') }}" class="btn-primary">Lihat Koleksi Kami</a>
        </div>
    @else
        <!-- Cart Content -->
        <div class="cart-content">
            <!-- Cart Items Section -->
            <div>
                <!-- Select All -->
                <div class="select-all-box">
                    <label>
                        <input type="checkbox" id="selectAllCheckbox">
                        <span>Pilih Semua ({{ $cartItems->count() }} item)</span>
                    </label>
                </div>

                <!-- Items List -->
                <div class="cart-items" style="order: 1;">
                    @foreach ($cartItems as $item)
                        <div class="cart-item {{ !$item->selected ? 'unselected' : '' }}" data-product-id="{{ $item->id }}">
                            <!-- Checkbox -->
                            <div class="cart-item-checkbox">
                                <input type="checkbox" class="itemCheckbox"
                                    data-cart-id="{{ $item->id }}"
                                    data-price="{{ $item->product->price }}"
                                    data-quantity="{{ $item->quantity }}"
                                    {{ $item->selected ? 'checked' : '' }}>
                            </div>

                            <!-- Image -->
                            <div class="cart-item-image">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}">
                                @else
                                    <div style="width: 120px; height: 120px; background: var(--glass); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: rgba(255,255,255,0.3);">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="cart-item-details">
                                <div class="cart-item-info">
                                    <h3>{{ $item->product->name }}</h3>
                                    <div class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>

                                <div class="cart-item-actions">
                                    <!-- Quantity Control -->
                                    <div class="qty-control">
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                            <button type="{{ $item->quantity > 1 ? 'submit' : 'button' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                                        </form>
                                        <input type="text" value="{{ $item->quantity }}" readonly>
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                            <button type="submit">+</button>
                                        </form>
                                    </div>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('cart.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Total Price -->
                            <div class="cart-item-total itemTotal" style="white-space: nowrap;">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-total">
                    <span>Total</span>
                    <span id="totalAmount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="summary-actions">
                    <div style="display: flex; gap: 8px; margin-left: auto;">
                        <a href="{{ route('user.products') }}" class="btn-continue-shopping">
                            ← Lanjut Belanja
                        </a>
                        <a href="{{ route('user.checkout.index') }}" class="btn-checkout">
                            Lanjut ke Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    const token = '{{ csrf_token() }}';

    function initializeCheckboxes() {
        document.querySelectorAll('.itemCheckbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                toggleItemSelected(this.dataset.cartId, this.checked);
                updateSelectAllState();
                updateItemAppearance(this);
            });
        });

        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.itemCheckbox').forEach(checkbox => {
                    checkbox.checked = isChecked;
                    toggleItemSelected(checkbox.dataset.cartId, isChecked);
                    updateItemAppearance(checkbox);
                });
            });
        }
    }

    function updateItemAppearance(checkbox) {
        const cartItem = checkbox.closest('.cart-item');
        if (checkbox.checked) {
            cartItem.classList.remove('unselected');
        } else {
            cartItem.classList.add('unselected');
        }
    }

    function toggleItemSelected(cartId, selected) {
        fetch('{{ route("cart.toggleSelected") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                cart_id: cartId,
                selected: selected
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(() => {
            updateTotal();
        })
        .catch(error => console.error('Error:', error));
    }

    function updateSelectAllState() {
        const allCheckboxes = document.querySelectorAll('.itemCheckbox');
        const checkedCheckboxes = document.querySelectorAll('.itemCheckbox:checked');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        if (selectAllCheckbox && allCheckboxes.length > 0) {
            selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
        }
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.itemCheckbox:checked').forEach(checkbox => {
            const price = parseFloat(checkbox.dataset.price) || 0;
            const quantity = parseInt(checkbox.dataset.quantity) || 0;
            total += price * quantity;
        });

        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');

        const subtotalEl = document.getElementById('subtotal');
        const totalAmountEl = document.getElementById('totalAmount');

        if (subtotalEl) subtotalEl.textContent = formattedTotal;
        if (totalAmountEl) totalAmountEl.textContent = formattedTotal;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeCheckboxes();
        updateTotal();
    });
</script>
@endsection
