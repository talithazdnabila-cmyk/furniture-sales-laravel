@extends('layouts.admin')

@section('title', 'Eksekutif Dashboard')

@section('content')

<style>
    :root {
        --zada-gold: #c5a059;
        --zada-dark: #1a1a1a;
        --border-color: #eceef0;
        --bg-body: #f8f9fa;
    }

    body { background-color: var(--bg-body); color: #333; font-family: 'Inter', sans-serif; }
    
    /* Card & Container */
    .stat-card {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .table-container-pro {
        background: white; border: 1px solid var(--border-color);
        border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Typography */
    .dashboard-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--zada-dark); }
    .label-xs { font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700; color: #888; }
    .value-lg { font-size: 1.4rem; font-weight: 700; color: var(--zada-dark); }

    /* Table Styling */
    .table-pro thead th {
        background: #fbfbfc; border-bottom: 1px solid var(--border-color);
        color: #666; font-size: 11px; font-weight: 700; padding: 15px;
    }
    .table-pro tbody td { padding: 12px 15px; border-bottom: 1px solid #f8f9fa; font-size: 13px; }

    /* Status Badges */
    .status-pill {
        padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700;
        border: 1px solid transparent; display: inline-block;
    }
    .status-pending { background: #fff9eb; color: #946c00; border-color: #ffecb5; }
    .status-success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .status-info { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }

    /* Activity Feed */
    .activity-item { position: relative; padding-left: 20px; border-left: 2px solid #eee; margin-left: 10px; padding-bottom: 15px; }
    .activity-item::before { 
        content: ''; position: absolute; left: -6px; top: 0; 
        width: 10px; height: 10px; border-radius: 50%; background: var(--zada-gold); 
    }
</style>

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="dashboard-title m-0">Eksekutif Dashboard</h3>
        <p class="text-muted small m-0">Pelaporan Intelijen ZADA.CO</p>
    </div>
    <button id="datePickerBtn" class="btn btn-white bg-white border shadow-sm btn-sm px-3 rounded-3">
        <i class="bi bi-calendar3 me-2 text-muted"></i> <span id="dateDisplay">{{ date('d M Y') }}</span>
    </button>
</div>

{{-- TOP STATS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="label-xs mb-1">Produk</div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="value-lg">{{ number_format($totalProduk) }}</div>
                <i class="bi bi-box-seam text-muted fs-4"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="label-xs mb-1">Stok Menipis</div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="value-lg text-danger">{{ $stokMenipis }}</div>
                <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="label-xs mb-1">Transaksi</div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="value-lg">{{ $totalTransaksi }}</div>
                <i class="bi bi-receipt fs-4" style="color: var(--zada-gold);"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="label-xs mb-1">Pelanggan</div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="value-lg">{{ $totalPelanggan }}</div>
                <i class="bi bi-people text-muted fs-4"></i>
            </div>
        </div>
    </div>
</div>

{{-- ANALYTICS CHART --}}
<div class="table-container-pro p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold m-0 text-uppercase small" style="letter-spacing: 1px;">Pendapatan</h6>
        <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle fw-bold" style="font-size: 11px;">Tahun</button>
        </div>
    </div>
    <canvas id="salesChart" height="70"></canvas>
</div>

<div class="row g-4">
    {{-- LEFT COLUMN --}}
    <div class="col-lg-8">
        {{-- TABLE RECENT SALES --}}
        <div class="table-container-pro">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold m-0 small text-uppercase">Transaksi Terbaru</h6>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-light btn-sm fw-bold px-3" style="font-size: 10px;">LIHAT RIWAYAT</a>
            </div>
            <div class="table-responsive">
                <table class="table table-pro m-0">
                    <thead>
                        <tr>
                            <th>NO TRX</th>
                            <th>PELANGGAN</th>
                            <th>JUMLAH</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $trx)
                        <tr>
                            <td class="text-muted fw-bold">#ZDA-{{ $trx->id }}</td>
                            <td class="fw-bold">{{ $trx->nama_pembeli ?? ($trx->user->name ?? '-') }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                            <td class="text-center">
                                <span class="status-pill {{ $trx->status == 'pending' ? 'status-pending' : 'status-success' }}">
                                    @if($trx->status == 'pending') MENUNGGU
                                    @elseif($trx->status == 'completed') SELESAI
                                    @elseif($trx->status == 'shipped') DIKIRIM
                                    @else {{ strtoupper($trx->status) }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TABLE LOGISTICS --}}
        <div class="table-container-pro">
            <div class="px-4 py-3 border-bottom">
                <h6 class="fw-bold m-0 small text-uppercase">Pelacakan Pengiriman</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-pro m-0">
                    <thead>
                        <tr>
                            <th>PENERIMA</th>
                            <th>TUJUAN</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimanTerbaru as $pengiriman)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $pengiriman->nama_penerima }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $pengiriman->no_telepon }}</div>
                            </td>
                            <td><small class="text-muted">{{ Str::limit($pengiriman->alamat, 45) }}</small></td>
                            <td class="text-center">
                                @php
                                    $s = strtolower($pengiriman->status);
                                    $class = ($s == 'delivered' || $s == 'selesai') ? 'status-success' : (($s == 'shipped' || $s == 'dikirim') ? 'status-info' : 'status-pending');
                                @endphp
                                <span class="status-pill {{ $class }}">
                                    @if($pengiriman->status == 'pending') MENUNGGU
                                    @elseif($pengiriman->status == 'shipped') DIKIRIM
                                    @elseif($pengiriman->status == 'completed') SELESAI
                                    @else {{ strtoupper($pengiriman->status) }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-4 text-muted">Tidak ada data pengiriman</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN (PENYEIMBANG) --}}
    <div class="col-lg-4">
        {{-- QUICK ACTIONS --}}
        <div class="table-container-pro p-4 mb-4">
            <h6 class="fw-bold mb-3 small text-uppercase">Aksi Cepat</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.transaksi.create') }}" class="btn btn-dark btn-sm py-2 fw-bold">TRANSAKSI MASUK</a>
                <a href="/admin/products" class="btn btn-outline-dark btn-sm py-2 fw-bold">KONTROL STOK</a>
            </div>
        </div>

        {{-- PERFORMANCE GOAL --}}
        <div class="table-container-pro p-4 mb-4">
            <h6 class="fw-bold mb-3 small text-uppercase">Target Penjualan Bulanan</h6>
            <div class="d-flex justify-content-between align-items-end mb-2">
                <h3 class="fw-bold m-0">72%</h3>
                <span class="text-muted" style="font-size: 11px;">Rp 360M / 500M</span>
            </div>
            <div class="progress" style="height: 6px; background: #eee; border-radius: 10px;">
                <div class="progress-bar" style="background: var(--zada-gold); width: 72%"></div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="table-container-pro p-4">
            <h6 class="fw-bold mb-4 small text-uppercase">Aktivitas Sistem</h6>
            <div class="activity-feed">
                <div class="activity-item">
                    <div class="fw-bold small">Transaksi Baru</div>
                    <div class="text-muted" style="font-size: 11px;">Pesanan #ZDA-102 diproses oleh Sistem</div>
                </div>
                <div class="activity-item">
                    <div class="fw-bold small">Peringatan Stok</div>
                    <div class="text-muted" style="font-size: 11px;">Produk "ZADA Premium" stoknya menipis</div>
                </div>
                <div class="activity-item" style="border: none; padding-bottom: 0;">
                    <div class="fw-bold small">Status Backup</div>
                    <div class="text-muted" style="font-size: 11px;">Backup database otomatis berhasil selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CALENDAR (Script lama Anda tetap bekerja di sini) --}}
<div id="calendarModal" class="calendar-modal">
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelBulan) !!},
            datasets: [{
                label: 'Pendapatan Bulanan',
                data: {!! json_encode($dataPenjualan) !!},
                borderWidth: 2,
                borderColor: '#c5a059',
                backgroundColor: 'rgba(197, 160, 89, 0.05)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#c5a059',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { borderDash: [5, 5], color: '#f0f0f0' }, ticks: { font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
</script>

@endsection