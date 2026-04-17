@extends('layouts.admin')

@section('title', 'Kategori Produk - ZADA.CO')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    .page-title {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--zada-dark);
        font-family: 'Playfair Display', serif;
    }

    /* Card Styling */
    .card-luxury {
        border: none;
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        font-weight: 700;
        color: #666;
        border-top: none;
        padding: 15px;
    }

    .table tbody td {
        padding: 18px 15px;
        color: #333;
        font-size: 14px;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Custom Buttons */
    .btn-add {
        background: var(--zada-dark);
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        border: none;
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
        transition: 0.3s;
        margin: 0 2px;
        text-decoration: none;
    }

    /* Warna Tombol Baru */
    .btn-view-soft { background: #eef2ff; color: #4338ca; }
    .btn-view-soft:hover { background: #4338ca; color: white; }

    .btn-edit-soft { background: #fff4e5; color: #b07219; }
    .btn-edit-soft:hover { background: #e8b86d; color: white; }

    .btn-delete-soft { background: #fff0f0; color: #e03131; border: none; }
    .btn-delete-soft:hover { background: #fa5252; color: white; }

    .alert-zada {
        background: #e6fcf5;
        border: none;
        color: #0ca678;
        border-radius: 8px;
        font-weight: 600;
    }

    /* Search Form Styling */
    .form-control {
        border: 1px solid #eceef0;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 13px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: var(--zada-gold);
        box-shadow: 0 0 0 0.2rem rgba(232, 184, 109, 0.15);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: var(--zada-dark);
        border: 1px solid #eceef0;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        border-color: #999;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Kategori Produk</h3>
            <p class="text-muted small m-0">Kelola klasifikasi furnitur eksklusif ZADA.CO Anda.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-add shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Kategori
        </a>
    </div>

    {{-- SEARCH FORM --}}
    <div class="card card-luxury shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex gap-2">
                <div class="flex-grow-1">
                    <input type="text" name="search" class="form-control" placeholder="Cari kategori berdasarkan nama..." value="{{ $search ?? '' }}">
                </div>
                <button type="submit" class="btn btn-add">
                    <i class="fas fa-search me-2"></i> Cari
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">#</th>
                            <th>Nama Kategori</th>
                            <th class="text-center" width="150">Jumlah Produk</th>
                            <th class="text-end" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="text-center text-muted fw-bold">#{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold text-dark" style="font-size: 15px;">{{ $category->name }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark rounded-pill border px-3 py-2">
                                        {{ $category->products_count ?? $category->products->count() }} Item
                                    </span>
                                </td>
                                <td class="text-end px-3">
                                    {{-- TOMBOL LIHAT PRODUK --}}
                                    <a href="{{ route('admin.categories.products', $category->id) }}"
                                       class="action-btn btn-view-soft" title="Lihat Produk">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="action-btn btn-edit-soft" title="Edit Kategori">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn btn-delete-soft" title="Hapus Kategori">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-25" style="filter: grayscale(1);">
                                    <p class="text-muted mb-0 fw-bold">Belum ada kategori yang ditambahkan.</p>
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