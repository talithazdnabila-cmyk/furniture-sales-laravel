@extends('layouts.admin')

@section('title', 'Konfirmasi Transaksi - ZADA.CO')

@section('content')

<style>
    :root {
        --zada-gold: #e8b86d;
        --zada-dark: #111;
    }

    .page-title {
        font-weight: 800;
        letter-spacing: -1px;
        color: var(--zada-dark);
        font-family: 'Playfair Display', serif;
    }

    .card-luxury {
        border: none;
        border-radius: 15px;
        background: #fff;
        overflow: hidden;
    }

    .table thead th {
        background-color: #fcfcfc;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        font-weight: 700;
        color: #888;
        padding: 20px 15px;
        border: none;
    }

    .table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f8f8f8;
    }

    .trx-id {
        font-family: 'Monaco', monospace;
        background: #f4f4f4;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
    }

    .btn-confirm-gold {
        background: var(--zada-dark);
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        transition: 0.3s;
    }

    .btn-confirm-gold:hover {
        background: var(--zada-gold);
        color: var(--zada-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(232, 184, 109, 0.3);
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h3 class="page-title m-0">Menunggu Konfirmasi</h3>
        <p class="text-muted small m-0">Validasi pembayaran pelanggan untuk memproses pesanan.</p>
    </div>

    <div class="card card-luxury shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th width="100">ID TRX</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th class="text-end">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiPending as $trx)
                            <tr>
                                <td>
                                    <span class="trx-id">#{{ $trx->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $trx->nama_pembeli ?? ($trx->user->name ?? 'Guest Customer') }}</div>
                                    <small class="text-muted">Status: <span class="text-warning">Menunggu Verifikasi</span></small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.transaksi.update', $trx->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn-confirm-gold" onclick="return confirm('Konfirmasi pembayaran untuk transaksi #{{ $trx->id }}?')">
                                            <i class="fas fa-check-circle me-1"></i> Konfirmasi Pembayaran
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4436/4436481.png" width="60" class="mb-3 opacity-25">
                                    <p class="text-muted">Tidak ada transaksi yang perlu dikonfirmasi saat ini.</p>
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