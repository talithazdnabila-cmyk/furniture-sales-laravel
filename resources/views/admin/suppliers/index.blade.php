@extends('layouts.admin')

@section('title', 'Manajemen Supplier - ZADA.CO')

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
        padding: 18px 15px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f8f8f8;
        color: #444;
    }

    /* Info Supplier */
    .supplier-name {
        font-weight: 700;
        color: var(--zada-dark);
        display: block;
    }
    .supplier-email {
        font-size: 12px;
        color: #888;
    }

    /* Badge Status Modern */
    .status-pill {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-active { background: #e6fcf5; color: #0ca678; }
    .status-inactive { background: #f1f3f5; color: #495057; }

    /* Button Styling */
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

    .contact-info i {
        width: 20px;
        color: var(--zada-gold);
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Data Supplier</h3>
            <p class="text-muted small m-0">Daftar mitra pemasok material ZADA.CO</p>
        </div>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-add shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Supplier
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 p-3 d-flex align-items-center" style="border-radius: 10px; background: #e6fcf5; color: #0ca678;">
            <i class="fas fa-check-circle me-3 fa-lg"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">#</th>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td class="text-center text-muted font-monospace">{{ $loop->iteration }}</td>
                                
                                <td>
                                    <span class="supplier-name">{{ $supplier->name }}</span>
                                    <span class="supplier-email">{{ $supplier->email ?? 'No email set' }}</span>
                                </td>

                                <td class="contact-info">
                                    <div class="small mb-1">
                                        <i class="fas fa-phone-alt"></i> {{ $supplier->phone ?? '-' }}
                                    </div>
                                    <div class="small">
                                        <i class="fas fa-envelope"></i> {{ $supplier->email ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if ($supplier->is_active)
                                        <span class="status-pill status-active">Aktif</span>
                                    @else
                                        <span class="status-pill status-inactive">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" 
                                           class="action-btn btn-edit-soft" title="Edit">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
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
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3126/3126504.png" width="60" class="mb-3 opacity-25">
                                    <p class="text-muted">Database supplier masih kosong.</p>
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