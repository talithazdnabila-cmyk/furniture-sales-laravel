@extends('layouts.admin')

@section('title', 'Katalog Produk - ZADA.CO')

@section('content')

<style>
    :root {
        --zada-gold: #c5a059;
        --zada-dark: #1a1a1a;
        --border-color: #eceef0;
        --bg-body: #f8f9fa;
    }

    body { 
        background-color: var(--bg-body); 
        color: #333; 
        font-family: 'Inter', sans-serif; 
    }
    
    /* Typography Match Dashboard */
    .page-title { 
        font-family: 'Playfair Display', serif; 
        font-weight: 700; 
        color: var(--zada-dark); 
    }

    .label-xs { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 0.8px; 
        font-weight: 700; 
        color: #888; 
    }

    /* Card Luxury Styling */
    .card-luxury {
        background: white; 
        border: 1px solid var(--border-color);
        border-radius: 12px; 
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Table Styling Match Dashboard */
    .table-pro thead th {
        background: #fbfbfc; 
        border-bottom: 1px solid var(--border-color);
        color: #666; 
        font-size: 11px; 
        font-weight: 700; 
        padding: 18px 15px;
        text-transform: uppercase; 
        letter-spacing: 1px;
    }

    .table-pro tbody td { 
        padding: 15px; 
        border-bottom: 1px solid #f8f9fa; 
        font-size: 13px; 
        vertical-align: middle; 
    }

    /* Product Image Frame */
    .product-frame {
        width: 54px; 
        height: 54px; 
        border-radius: 10px;
        overflow: hidden; 
        background: #f5f5f5;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Status & Badge Styling */
    .badge-category {
        background: #eff6ff; 
        color: #1e40af; 
        border: 1px solid #bfdbfe;
        font-size: 10px; 
        font-weight: 700; 
        padding: 4px 10px; 
        border-radius: 6px;
        text-transform: uppercase;
    }

    .low-stock-alert {
        background: #fff0f0; 
        color: #e03131; 
        border: 1px solid #ffe3e3;
        font-size: 9px; 
        font-weight: 800; 
        padding: 2px 6px; 
        border-radius: 4px;
        display: inline-block;
        margin-top: 4px;
    }

    /* Button Actions Styling */
    .btn-zada-dark {
        background: var(--zada-dark); 
        color: white; 
        border: none;
        padding: 10px 20px; 
        border-radius: 8px; 
        font-size: 11px;
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-zada-dark:hover { 
        background: var(--zada-gold); 
        color: white; 
        transform: translateY(-1px); 
    }

    /* Action Table Buttons */
    .btn-action-edit {
        background: #fff9eb; 
        color: #946c00; 
        border: 1px solid #ffecb5;
        font-size: 10px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-action-edit:hover {
        background: #c5a059;
        color: white;
        border-color: #c5a059;
    }

    .btn-action-delete {
        background: #fff0f0; 
        color: #e03131; 
        border: 1px solid #ffe3e3;
        font-size: 10px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 6px;
        transition: 0.2s;
    }

    .btn-action-delete:hover {
        background: #e03131;
        color: white;
        border-color: #e03131;
    }

    /* Search Form Styling */
    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 13px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: var(--zada-gold);
        box-shadow: 0 0 0 0.2rem rgba(197, 160, 89, 0.15);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: var(--zada-dark);
        border: 1px solid var(--border-color);
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        border-color: #999;
    }
</style>

<div class="container-fluid px-4 py-4">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Katalog Produk</h3>
            <p class="text-muted small m-0">Manajemen Inventaris ZADA.CO Intelligence</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-zada-dark shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> TAMBAH PRODUK BARU
        </a>
    </div>

    {{-- SEARCH FORM --}}
    <div class="card card-luxury shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex gap-2">
                <div class="flex-grow-1">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk berdasarkan nama atau deskripsi..." value="{{ $search ?? '' }}">
                </div>
                <button type="submit" class="btn btn-zada-dark">
                    <i class="bi bi-search me-2"></i> Cari
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i> Reset
                </a>
            </form>
        </div>
    </div>

    {{-- MAIN DATA TABLE --}}
    <div class="card card-luxury">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-pro mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No</th>
                            <th width="80">Preview</th>
                            <th>Detail Produk</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Stok</th>
                            <th class="text-end">Opsi Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center text-muted fw-bold" style="font-size: 11px;">
                                    {{ $loop->iteration }}
                                </td>
                                
                                <td>
                                    <div class="product-frame shadow-sm">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-image text-muted" style="font-size: 18px;"></i>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14px; letter-spacing: -0.3px;">{{ $product->name }}</div>
                                    <div class="label-xs" style="font-size: 9px; color: #aaa; margin-top: 2px;">ID: ZDA-PRO-{{ $product->id }}</div>
                                </td>

                                <td>
                                    <span class="badge-category">
                                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-category" style="background: #fef3e5; color: #946c00; border-color: #ffd99d;">
                                        {{ $product->supplier->name ?? 'Belum ditentukan' }}
                                    </span>
                                </td>

                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                <td class="text-center">
                                    <div class="fw-bold {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}" style="font-size: 14px;">
                                        {{ $product->stock }} <span class="text-muted fw-normal" style="font-size: 11px;">unit</span>
                                    </div>
                                    @if($product->stock <= 5)
                                        <span class="low-stock-alert">STOK KRITIS</span>
                                    @endif
                                </td>

                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                           class="btn btn-action-edit d-flex align-items-center">
                                            <i class="bi bi-pencil-square me-1"></i> EDIT
                                        </a>

                                        {{-- TOMBOL HAPUS --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus produk ini dari katalog permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action-delete d-flex align-items-center">
                                                <i class="bi bi-trash3 me-1"></i> HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted py-4">
                                        <i class="bi bi-box-seam display-4 mb-3 d-block" style="opacity: 0.3;"></i>
                                        <p class="label-xs">Katalog produk belum tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection