@extends('layouts.admin')

@section('title', 'Manajemen Produk - ZADA.CO')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    .page-title {
        font-weight: 800;
        letter-spacing: -1px;
        color: var(--zada-dark);
    }

    .card-luxury {
        border: none;
        border-radius: 15px;
        background: #fff;
        overflow: hidden;
    }

    /* Table Styling */
    .table thead th {
        background-color: #fcfcfc;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        font-weight: 700;
        color: #888;
        border-top: none;
        padding: 20px 15px;
    }

    .table tbody td {
        padding: 20px 15px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f8f8f8;
    }

    /* Product Image Styling */
    .product-img-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        background: #f5f5f5;
        border: 1px solid #eee;
    }

    /* Badge Custom */
    .badge-category {
        background: #f0f0f0;
        color: #555;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
    }

    .badge-stock {
        font-weight: 700;
        font-size: 12px;
    }

    .text-price {
        font-weight: 700;
        color: var(--zada-dark);
    }

    /* Action Buttons */
    .btn-add {
        background: var(--zada-dark);
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-add:hover {
        background: var(--zada-gold);
        color: var(--zada-dark);
        transform: translateY(-2px);
    }

    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
        text-decoration: none;
    }
    .btn-edit-soft { background: #fff4e5; color: #b07219; }
    .btn-edit-soft:hover { background: #e8b86d; color: white; }
    .btn-delete-soft { background: #fff0f0; color: #e03131; border: none; }
    .btn-delete-soft:hover { background: #fa5252; color: white; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Data Produk</h3>
            <p class="text-muted small m-0">Kelola katalog furnitur eksklusif Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-add shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 p-3" style="border-radius: 10px; background: #e6fcf5; color: #0ca678;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">#</th>
                            <th width="80">Foto</th>
                            <th>Info Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center text-muted font-monospace">{{ $loop->iteration }}</td>
                                
                                {{-- FOTO PRODUK --}}
                                <td>
                                    <div class="product-img-wrapper">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- NAMA PRODUK --}}
                                <td>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <small class="text-muted">ID: #PROD-{{ $product->id }}</small>
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    <span class="badge-category">
                                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>

                                {{-- HARGA --}}
                                <td class="text-price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                {{-- STOK --}}
                                <td class="text-center">
                                    <span class="badge-stock {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}">
                                        {{ $product->stock }} <small class="text-muted">unit</small>
                                    </span>
                                    @if($product->stock <= 5)
                                        <div style="font-size: 9px; text-transform: uppercase; font-weight: 800;" class="text-danger">Low Stock</div>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                           class="action-btn btn-edit-soft" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete-soft" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-light mb-3"></i>
                                    <p class="text-muted">Belum ada produk dalam katalog Anda.</p>
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