@extends('layouts.admin')

@section('title', 'Edit Produk - ZADA.CO')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
    :root {
        --zada-gold: #c2a35d;
        --zada-dark: #1a1a1a;
        --zada-border: #f0f0f0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #fcfcfc;
    }

    .header-section {
        margin-bottom: 2.5rem;
    }

    .header-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.2rem;
        color: var(--zada-dark);
    }

    .card-luxury {
        background: #ffffff;
        border: 1px solid var(--zada-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        width: 100%; /* Rata Full Width */
    }

    .form-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #aaa;
        margin-bottom: 10px;
    }

    .form-control-zada, .form-select-zada {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 0.95rem;
        transition: 0.3s ease;
    }

    .form-control-zada:focus, .form-select-zada:focus {
        background-color: #fff;
        border-color: var(--zada-gold);
        box-shadow: 0 5px 15px rgba(194, 163, 93, 0.08);
        outline: none;
    }

    .image-preview-wrapper {
        border: 2px dashed #eee;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        background: #fafafa;
    }

    .btn-update {
        background: var(--zada-dark);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 16px 40px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-update:hover {
        background: var(--zada-gold);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(194, 163, 93, 0.3);
    }

    .btn-cancel {
        color: #999;
        text-decoration: none;
        font-weight: 600;
        padding: 16px 30px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: var(--zada-dark);
    }
</style>

<div class="container-fluid py-4">
    
    <div class="header-section">
        <h1 class="header-title">Edit Product Details</h1>
        <p class="text-muted small fw-bold" style="letter-spacing: 1px;">Manage inventory specifications and imagery</p>
    </div>

    <div class="card card-luxury">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.products.update', $product->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- KATEGORI --}}
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select-zada w-100" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NAMA --}}
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" 
                               class="form-control-zada w-100" required>
                    </div>

                    {{-- HARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Price (IDR)</label>
                        <input type="number" name="price" value="{{ $product->price }}" 
                               class="form-control-zada w-100" required>
                    </div>

                    {{-- STOK --}}
                    <div class="col-md-6">
                        <label class="form-label">Stock Inventory</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" 
                               class="form-control-zada w-100" required>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control-zada w-100" 
                                  rows="4">{{ $product->description }}</textarea>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="col-12">
                        <label class="form-label">Product Image</label>
                        <div class="image-preview-wrapper mb-2">
                            @if ($product->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         id="img-preview" width="200" class="rounded shadow-sm border border-white">
                                </div>
                            @endif
                            <input type="file" name="image" id="img-input" class="form-control-zada w-100">
                            <small class="text-muted mt-2 d-block" style="font-size: 11px;">Max file size: 2MB. Preferred aspect ratio 1:1.</small>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS Rata Kanan --}}
                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                                Discard
                            </a>
                            <button type="submit" class="btn-update shadow-sm">
                                Save Product Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    document.getElementById('img-input').onchange = evt => {
        const [file] = document.getElementById('img-input').files
        if (file) {
            const preview = document.getElementById('img-preview');
            if(preview) {
                preview.src = URL.createObjectURL(file);
            }
        }
    }
</script>

@endsection