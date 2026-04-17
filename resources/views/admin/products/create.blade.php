@extends('layouts.admin')

@section('title', 'Tambah Produk - ZADA.CO')

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
        width: 100%;
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

    .image-upload-wrapper {
        border: 2px dashed #eee;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        background: #fafafa;
        transition: 0.3s;
    }

    .image-upload-wrapper:hover {
        border-color: var(--zada-gold);
        background: #fff;
    }

    .btn-save {
        background: var(--zada-dark);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 16px 45px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-save:hover {
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
        <h1 class="header-title">Create New Product</h1>
        <p class="text-muted small fw-bold" style="letter-spacing: 1px;">Add exclusive pieces to your collection</p>
    </div>

    <div class="card card-luxury">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    {{-- KATEGORI --}}
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select-zada w-100" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SUPPLIER --}}
                    <div class="col-md-6">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select-zada w-100" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NAMA --}}
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control-zada w-100" placeholder="e.g. Silk Oversized Shirt" required>
                    </div>

                    {{-- HARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Price (IDR)</label>
                        <input type="number" name="price" class="form-control-zada w-100" placeholder="0" required>
                    </div>

                    {{-- STOK --}}
                    <div class="col-md-6">
                        <label class="form-label">Initial Stock</label>
                        <input type="number" name="stock" class="form-control-zada w-100" placeholder="0" required>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control-zada w-100" rows="4" placeholder="Crafted from the finest material..."></textarea>
                    </div>

                    {{-- FOTO PRODUK --}}
                    <div class="col-12">
                        <label class="form-label">Product Imagery</label>
                        <div class="image-upload-wrapper">
                            <img id="preview" src="#" alt="Preview" class="rounded shadow-sm mb-3 d-none" width="150">
                            <input type="file" name="image" id="imgInput" class="form-control-zada w-100" accept="image/*" required>
                            <small class="text-muted mt-2 d-block">Recommended: Square ratio (1:1), Max 2MB.</small>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                                Cancel
                            </a>
                            <button type="submit" class="btn-save shadow-sm">
                                Save Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    imgInput.onchange = evt => {
        const [file] = imgInput.files
        if (file) {
            preview.src = URL.createObjectURL(file)
            preview.classList.remove('d-none')
        }
    }
</script>

@endsection