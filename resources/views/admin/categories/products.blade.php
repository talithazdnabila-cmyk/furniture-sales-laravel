@extends('layouts.admin')

@section('title', 'Produk Berdasarkan Kategori - ZADA.CO')

@section('content')

<style>
    .card-product {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
        background: #fff;
    }
    .card-product:hover {
        transform: translateY(-5px);
    }
    .img-container {
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .zada-gold-text {
        color: #e8b86d;
        font-weight: 700;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-decoration-none">Kategori</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold m-0">Koleksi <span class="zada-gold-text">{{ $category->name }}</span></h3>
            <p class="text-muted small">Daftar produk eksklusif yang tersedia dalam kategori ini.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark btn-sm px-3" style="border-radius: 8px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        @forelse($category->products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card card-product shadow-sm h-100">
                
                {{-- PERBAIKAN LOGIKA GAMBAR --}}
                <div class="img-container">
                    @if($product->image)
                        {{-- Cek apakah path menggunakan 'products/' atau langsung --}}
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="card-img-top" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=No+Image';">
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-couch fa-3x mb-2" style="opacity: 0.2;"></i>
                            <p class="small m-0">No Image Available</p>
                        </div>
                    @endif
                </div>

                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $product->name }}</h6>
                    <p class="text-muted small mb-2 text-truncate" style="max-width: 100%;">
                        {{ $product->description ?? 'Furnitur berkualitas tinggi dari ZADA.' }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold text-dark">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="badge {{ $product->stock > 0 ? 'bg-light text-dark' : 'bg-danger' }} border" style="font-size: 10px; border-radius: 5px;">
                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                        </span>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-0 p-3 pt-0">
                    <div class="d-grid">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-dark btn-sm" style="border-radius: 8px;">
                            Edit Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                <i class="fas fa-box-open fa-3x text-muted"></i>
            </div>
            <h5 class="text-muted fw-bold">Belum ada produk.</h5>
            <p class="text-muted small">Tambahkan produk baru ke dalam kategori ini melalui menu Produk.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection