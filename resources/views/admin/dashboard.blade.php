@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.css">

<style>
    /* Permainan warna latar belakang kartu agar lebih hidup */
    .stat-card {
        border: none;
        border-radius: 25px;
        background: #ffffff;
        transition: all 0.4s ease;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    /* Efek hiasan lingkaran warna di pojok kartu agar tidak flat */
    .stat-card::before {
        content: "";
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        z-index: -1;
        opacity: 0.1;
    }

    .card-produk::before { background: #e8b86d; }
    .card-stok::before { background: #ff4d4d; }
    .card-transaksi::before { background: #2ecc71; }
    .card-pelanggan::before { background: #3498db; }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(232, 184, 109, 0.15);
    }

    /* Gradient Icon Backgrounds */
    .icon-box {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    .bg-zada-gold { background: linear-gradient(135deg, #e8b86d, #b8860b); }
    .bg-zada-dark { background: linear-gradient(135deg, #2c3e50, #000000); }
    .bg-zada-red { background: linear-gradient(135deg, #ff6b6b, #ee5253); }
    .bg-zada-green { background: linear-gradient(135deg, #55efc4, #00b894); }

    /* Table Design */
    .table-container {
        background: white;
        border-radius: 25px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #f1f1f1;
    }

    .table-zada thead th {
        background: #fdfaf5;
        color: #b8860b;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 15px;
        border: none;
    }

    /* Quick Action Colorful Buttons */
    .btn-quick {
        border: none;
        border-radius: 20px;
        padding: 20px;
        color: white;
        text-align: center;
        text-decoration: none;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .btn-quick:hover {
        transform: scale(1.05);
        color: white;
        filter: brightness(1.1);
    }

    .gold-gradient { background: linear-gradient(135deg, #e8b86d 0%, #d4a017 100%); }
    .dark-gradient { background: linear-gradient(135deg, #434343 0%, #000000 100%); }
    
    .gold-text { color: #b8860b; }
    
    /* Calendar Modal Popup */
    .calendar-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
        animation: fadeIn 0.3s ease;
    }

    .calendar-modal.show {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .calendar-content {
        background-color: #ffffff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
    }

    .calendar-header h5 {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 800;
        margin: 0;
        color: #121212;
    }

    .close-calendar {
        font-size: 28px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
        transition: 0.3s;
        border: none;
        background: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-calendar:hover {
        color: #121212;
    }

    /* Calendar Grid */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .calendar-day-name {
        text-align: center;
        font-weight: 800;
        color: #999;
        font-size: 11px;
        text-transform: uppercase;
        padding: 10px 0;
        letter-spacing: 1px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        background: #f5f5f5;
        color: #333;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .calendar-day:hover {
        background: rgba(232, 184, 109, 0.2);
        border-color: #e8b86d;
    }

    .calendar-day.selected {
        background: #e8b86d;
        color: white;
        font-weight: 800;
    }

    .calendar-day.other-month {
        color: #ccc;
        cursor: default;
    }

    .calendar-day.other-month:hover {
        background: #f5f5f5;
        border-color: transparent;
    }

    .calendar-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-nav button {
        background: #e8b86d;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .calendar-nav button:hover {
        background: #d4a857;
    }

    .calendar-month-year {
        font-weight: 800;
        color: #121212;
        font-size: 14px;
        text-align: center;
        min-width: 150px;
    }

    #datePickerBtn {
        cursor: pointer;
        transition: 0.3s;
    }

    #datePickerBtn:hover {
        background: #f0ebe3 !important;
        border-color: #e8b86d !important;
    }
</style>

<div class="d-flex justify-content-between align-items-end mb-5">
    <div>
        <h2 class="fw-bold m-0" style="font-family: 'Playfair Display', serif; color: #121212;">Executive Dashboard</h2>
        <p class="text-muted m-0">Ringkasan eksklusif performa <span style="color: #b8860b; font-weight: 600;">ZADA.CO</span></p>
    </div>
    <button id="datePickerBtn" class="badge p-2 px-3" style="background: #fdfaf5; color: #e8b86d; border: 1px solid #e8b86d; border-radius: 12px;">
        <i class="bi bi-calendar3 me-2"></i> <span id="dateDisplay">{{ date('d M Y') }}</span>
    </button>
</div>

{{-- STAT CARDS --}}
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stat-card card-produk p-4">
            <div class="icon-box bg-zada-gold"><i class="bi bi-bag-heart"></i></div>
            <div class="text-muted small fw-bold text-uppercase">Total Produk</div>
            <h2 class="fw-bold m-0">{{ $totalProduk }} <span class="small fw-normal text-muted" style="font-size: 14px;">Items</span></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card card-stok p-4">
            <div class="icon-box bg-zada-red"><i class="bi bi-graph-down-arrow"></i></div>
            <div class="text-muted small fw-bold text-uppercase">Stok Menipis</div>
            <h2 class="fw-bold m-0 text-danger">{{ $stokMenipis }} <span class="small fw-normal text-muted" style="font-size: 14px;">Alert</span></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card card-transaksi p-4">
            <div class="icon-box bg-zada-green"><i class="bi bi-currency-dollar"></i></div>
            <div class="text-muted small fw-bold text-uppercase">Transaksi</div>
            <h2 class="fw-bold m-0">{{ $totalTransaksi }} <span class="small fw-normal text-muted" style="font-size: 14px;">Orders</span></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card card-pelanggan p-4">
            <div class="icon-box bg-zada-dark"><i class="bi bi-person-check"></i></div>
            <div class="text-muted small fw-bold text-uppercase">Pelanggan</div>
            <h2 class="fw-bold m-0">{{ $totalPelanggan }} <span class="small fw-normal text-muted" style="font-size: 14px;">Users</span></h2>
        </div>
    </div>
</div>

{{-- DIAGRAM PENJUALAN --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="table-container">
            <h5 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">
                <i class="bi bi-bar-chart-line-fill me-2 text-warning"></i>
                Grafik Penjualan Per Bulan
            </h5>

            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
</div>


<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0" style="font-family: 'Playfair Display', serif;"><i class="bi bi-stars me-2 text-warning"></i> Penjualan Terkini</h5>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold" style="font-size: 12px;">See All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-zada align-middle">
                    <thead>
                        <tr>
                            <th class="rounded-start">Customer</th>
                            <th>Investment</th>
                            <th class="text-center rounded-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $trx)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; border: 1px solid #e8b86d;">
                                        <span class="fw-bold text-dark" style="font-size: 12px;">{{ substr($trx->nama_pembeli ?? 'A', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $trx->nama_pembeli ?? ($trx->user->name ?? '-') }}</div>
                                        <small class="text-muted">Ref: #ZDA-{{ $trx->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="fw-bold gold-text">Rp {{ number_format($trx->total_harga,0,',','.') }}</span></td>
                            <td class="text-center">
                                @if($trx->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill">Awaiting</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">Completed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row g-3 mb-4">
            <div class="col-6">
                <a href="/admin/products" class="btn-quick gold-gradient shadow-sm text-white">
                    <i class="bi bi-box-seam fs-3 mb-2"></i>
                    <span class="small fw-bold">PRODUK</span>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('admin.transaksi.create') }}" class="btn-quick dark-gradient shadow-sm text-white">
                    <i class="bi bi-plus-circle fs-3 mb-2"></i>
                    <span class="small fw-bold">KONFIRMASI</span>
                </a>
            </div>
        </div>

        <div class="table-container">
            <h5 class="fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Most Desired</h5>
            @forelse($produkPopuler as $produk)
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="small fw-bold">{{ $produk->name }}</span>
                    <span class="small gold-text fw-bold">{{ $produk->total_terjual }} Sold</span>
                </div>
                <div class="progress" style="height: 6px; background: #fdfaf5;">
                    <div class="progress-bar bg-zada-gold" role="progressbar" style="width: {{ min($produk->total_terjual * 2, 100) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-muted small">Belum ada data penjualan produk.</p>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelBulan) !!},
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: {!! json_encode($dataPenjualan) !!},
                borderWidth: 3,
                tension: 0.3,
                borderColor: '#e8b86d',
                backgroundColor: 'rgba(232,184,109,0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Calendar Modal Popup -->
<div id="calendarModal" class="calendar-modal">
    <div class="calendar-content">
        <div class="calendar-header">
            <h5>Pilih Tanggal</h5>
            <button class="close-calendar" id="closeCalendar">&times;</button>
        </div>
        
        <div class="calendar-nav">
            <button id="prevMonth"><i class="bi bi-chevron-left"></i></button>
            <div class="calendar-month-year">
                <span id="monthYear"></span>
            </div>
            <button id="nextMonth"><i class="bi bi-chevron-right"></i></button>
        </div>

        <div class="calendar-grid" id="calendarGrid"></div>
    </div>
</div>

<script>
    let currentDate = new Date();
    let selectedDate = null;

    // Open Calendar
    document.getElementById('datePickerBtn').addEventListener('click', function() {
        document.getElementById('calendarModal').classList.add('show');
        renderCalendar();
    });

    // Close Calendar
    document.getElementById('closeCalendar').addEventListener('click', function() {
        document.getElementById('calendarModal').classList.remove('show');
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('calendarModal');
        if (event.target == modal) {
            modal.classList.remove('show');
        }
    });

    // Previous Month
    document.getElementById('prevMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    // Next Month
    document.getElementById('nextMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Render Calendar
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update month-year display
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        document.getElementById('monthYear').textContent = `${monthNames[month]} ${year}`;

        // Clear grid
        const grid = document.getElementById('calendarGrid');
        grid.innerHTML = '';

        // Day names
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach(day => {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day-name';
            dayEl.textContent = day;
            grid.appendChild(dayEl);
        });

        // First day of month
        const firstDay = new Date(year, month, 1).getDay();
        
        // Days from previous month
        const prevMonthDays = new Date(year, month, 0).getDate();
        for (let i = firstDay - 1; i >= 0; i--) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = prevMonthDays - i;
            grid.appendChild(dayEl);
        }

        // Days of current month
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day';
            dayEl.textContent = day;

            // Check if today
            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayEl.style.borderColor = '#e8b86d';
                dayEl.style.borderWidth = '2px';
            }

            dayEl.addEventListener('click', function() {
                selectDate(new Date(year, month, day));
            });

            grid.appendChild(dayEl);
        }

        // Days from next month
        const totalCells = grid.children.length - 7; // Minus header row
        const remainingCells = 42 - totalCells;
        for (let day = 1; day <= remainingCells; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = day;
            grid.appendChild(dayEl);
        }
    }

    // Select Date
    function selectDate(date) {
        selectedDate = date;
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                           'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const formattedDate = `${String(date.getDate()).padStart(2, '0')} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
        document.getElementById('dateDisplay').textContent = formattedDate;

        // Close modal
        document.getElementById('calendarModal').classList.remove('show');
    }

    // Initial render
    renderCalendar();
</script>

@endsection