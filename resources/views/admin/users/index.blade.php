@extends('layouts.admin')

@section('title', 'Data Pelanggan - ZADA.CO')

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

    /* Avatar Style */
    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--zada-dark);
        color: var(--zada-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
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
    }

    /* Role Badge */
    .badge-role {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .role-admin { background: #e7f5ff; color: #1971c2; }
    .role-user { background: #f8f9fa; color: #495057; border: 1px solid #e9ecef; }

    /* Status Dot */
    .status-active {
        display: inline-flex;
        align-items: center;
        color: #0ca678;
        font-weight: 600;
        font-size: 13px;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        background: #0ca678;
        border-radius: 50%;
        margin-right: 8px;
    }

    /* Action Buttons */
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
    .btn-edit-soft { background: #fff4e5; color: #b07219; border: none; }
    .btn-edit-soft:hover { background: #e8b86d; color: white; }
    .btn-delete-soft { background: #fff0f0; color: #e03131; border: none; }
    .btn-delete-soft:hover { background: #fa5252; color: white; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h3 class="page-title m-0">Data Pelanggan</h3>
        <p class="text-muted small m-0">Kelola informasi pengguna dan hak akses pelanggan.</p>
    </div>

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">#</th>
                            <th>Pengguna</th>
                            <th>Kontak</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center text-muted font-monospace">{{ $loop->iteration }}</td>
                                
                                <td>
                                    <div class="d-flex align-items: center gap-3">
                                        <div class="user-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name ?? '-' }}</div>
                                            <small class="text-muted">Member sejak {{ $user->created_at->format('M Y') }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="small text-dark">
                                        <i class="fas fa-envelope me-2 text-muted"></i>{{ $user->email }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge-role {{ ($user->role ?? 'user') == 'admin' ? 'role-admin' : 'role-user' }}">
                                        {{ $user->role ?? 'user' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="status-active">
                                        <span class="status-dot"></span> Aktif
                                    </span>
                                </td>

                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="action-btn btn-edit-soft" title="Edit User">
                                            <i class="fas fa-user-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Hapus pelanggan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete-soft" title="Hapus User">
                                                <i class="fas fa-user-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                    <p>Belum ada data pelanggan yang terdaftar.</p>
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