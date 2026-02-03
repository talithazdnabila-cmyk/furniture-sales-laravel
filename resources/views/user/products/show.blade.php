@extends('layouts.user') 

@section('title', $product->name . ' - ZADA.CO')

@section('content')
{{-- Google Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-zada: #1e1b18; 
        --accent-zada: #e8b86d;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-zada); 
        color: #f4f1ee;
        margin: 0;
    }

    /* Back Button Area */
    .header-action { padding: 40px 10% 0; }
    .btn-back {
        display: inline-flex; align-items: center; gap: 10px;
        text-decoration: none; color: rgba(255,255,255,0.4); font-size: 11px;
        font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
        transition: 0.3s;
    }
    .btn-back:hover { color: var(--accent-zada); }

    /* Product Section */
    .product-detail-container { max-width: 1300px; margin: 20px auto 100px; padding: 0 40px; }
    
    .product-detail-wrapper { 
        display: grid; 
        grid-template-columns: 1.1fr 1fr; 
        gap: 60px; 
        align-items: start;
    }
    
    .product-image-container { 
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 60px; 
        display: flex; justify-content: center; align-items: center;
        min-height: 550px; /* Tinggi patokan */
    }
    .product-image-container img { 
        max-width: 100%; height: auto; 
        filter: drop-shadow(0 30px 50px rgba(0,0,0,0.5));
    }

    /* Content Box */
    .product-info-container {
        display: flex; flex-direction: column;
        height: 100%;
        min-height: 550px; /* Samakan dengan min-height gambar */
    }

    .info-top h2 { 
        font-family: 'Playfair Display', serif; font-size: 48px; color: #fff; 
        margin: 5px 0 10px; line-height: 1.1; 
    }
    .price-box { font-size: 30px; font-weight: 800; color: var(--accent-zada); margin-bottom: 20px; }

    /* REVISI: DYNAMIC SCROLL & FIT AREA */
    .narrative-box {
        flex: 1; /* Mengambil sisa ruang agar sejajar ke bawah */
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--glass-border);
        border-bottom: 1px solid var(--glass-border);
        margin-bottom: 25px;
        padding: 20px 0;
    }
    
    .scroll-area {
        overflow-y: auto;
        padding-right: 15px;
        /* Kalkulasi: Tinggi container gambar - elemen atas - elemen bawah */
        max-height: 280px; 
    }
    
    .scroll-area::-webkit-scrollbar { width: 2px; }
    .scroll-area::-webkit-scrollbar-thumb { background: var(--accent-zada); }
    
    .description-text { 
        color: rgba(255,255,255,0.5); 
        line-height: 1.8; 
        font-size: 15px; 
    }

    /* Purchase Area */
    .purchase-row { display: flex; gap: 15px; align-items: center; }
    .qty-selector { 
        display: flex; align-items: center; background: var(--glass);
        border: 1px solid var(--glass-border); border-radius: 10px; height: 50px; 
    }
    .qty-selector button { width: 40px; border: none; background: transparent; color: #fff; cursor: pointer; }
    .qty-selector input { width: 35px; text-align: center; border: none; background: transparent; color: #fff; font-weight: 700; outline: none; }

    .btn-buy { 
        flex: 1; height: 50px; background: var(--accent-zada); color: #000; border: none; 
        border-radius: 10px; font-weight: 800; font-size: 12px; letter-spacing: 2px; 
        cursor: pointer; text-transform: uppercase; transition: 0.3s;
    }
    .btn-buy:hover:not(:disabled) { transform: translateY(-2px); }

    /* Footer */
    .zada-footer {
        background: rgba(0,0,0,0.2);
        border-top: 1px solid var(--glass-border);
        padding: 60px 10%;
        text-align: center;
        margin-top: 80px;
    }
</style>

<div class="header-action">
    <a href="{{ url('/products') }}" class="btn-back"><i class="bi bi-arrow-left"></i> Back to Collection</a>
</div>

<div class="product-detail-container">
    <div class="product-detail-wrapper">
        <div class="product-image-container">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info-container">
            <div class="info-top">
                <p style="color:var(--accent-zada); font-weight:800; font-size:10px; letter-spacing:3px; text-transform:uppercase;">Curated Piece</p>
                <h2>{{ $product->name }}</h2>
                <div class="price-box">Rp {{ number_format($product->price,0,',','.') }}</div>
            </div>

            <div class="narrative-box">
                <p style="color:var(--accent-zada); font-size:10px; font-weight:800; text-transform:uppercase; margin-bottom:10px;">Design Narrative</p>
                <div class="scroll-area">
                    <div class="description-text">
                        {{ $product->description ?? 'Redefine your living sanctuary with the ' . $product->name . '. This piece is not just furniture; it is a meticulously crafted work of art designed to bring both timeless elegance and modern functionality to your home interior.' }}
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('user.checkout') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="purchase-row">
                    <div class="qty-selector">
                        <button type="button" class="qty-minus"><i class="bi bi-dash"></i></button>
                        <input type="text" name="qty" value="1" class="qty-input" readonly>
                        <button type="button" class="qty-plus"><i class="bi bi-plus"></i></button>
                    </div>
                    <button type="submit" class="btn-buy" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? 'Acquire Piece' : 'Sold Out' }}
                    </button> 
                </div>
                <p style="font-size: 10px; color: rgba(255,255,255,0.3); margin-top: 15px; text-transform: uppercase;">Stock Status: {{ $product->stock }} Units Available</p>
            </form>
        </div>
    </div>

    <div style="margin-top: 80px; border-top: 1px solid var(--glass-border); padding-top: 40px;">
        <h3 style="font-family: 'Playfair Display'; font-size: 26px; margin-bottom: 30px;">Recommended for You</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            @foreach ($relatedProducts as $item)
                <a href="{{ route('user.products.show', $item->id) }}" style="text-decoration:none; color:inherit; background:var(--glass); border:1px solid var(--glass-border); padding:20px; border-radius:15px; transition:0.3s;">
                    <div style="height:140px; display:flex; align-items:center; justify-content:center; margin-bottom:15px;">
                        <img src="{{ asset('storage/'.$item->image) }}" style="max-width:100%; max-height:100%; object-fit:contain;">
                    </div>
                    <h4 style="font-family:'Playfair Display'; font-size:16px; margin:0 0 5px;">{{ $item->name }}</h4>
                    <div style="color:var(--accent-zada); font-weight:700; font-size:14px;">Rp {{ number_format($item->price,0,',','.') }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<footer class="zada-footer">
    <div style="font-family: 'Playfair Display', serif; font-size: 24px; color: #fff; margin-bottom: 10px;">ZADA.CO</div>
    <p style="font-size: 10px; opacity: 0.3; letter-spacing: 2px; text-transform: uppercase;">Defining Elegance Since 2024</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const minus = document.querySelector('.qty-minus');
        const plus  = document.querySelector('.qty-plus');
        const input = document.querySelector('.qty-input');
        const max = {{ $product->stock }};
        if(minus && plus) {
            minus.onclick = () => { let v = parseInt(input.value); if(v > 1) input.value = v - 1; };
            plus.onclick = () => { let v = parseInt(input.value); if(v < max) input.value = v + 1; };
        }
    });
</script>
@endsection