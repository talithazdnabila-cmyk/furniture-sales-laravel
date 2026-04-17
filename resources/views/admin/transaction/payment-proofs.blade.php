@extends('layouts.admin')

@section('title', 'Bukti Transfer - ZADA.CO')

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
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .table {
        font-size: 13px;
    }

    .table thead th {
        background-color: #fcfcfc;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        font-weight: 700;
        color: #888;
        border-top: none;
        padding: 18px 15px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 13px;
        border-bottom: 1px solid #f8f8f8;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
    }

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-view {
        background: #eef2ff;
        color: #4338ca;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 11px;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view:hover {
        background: #4338ca;
        color: white;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .modal-header h2 {
        margin: 0;
    }

    .close-modal {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }

    .close-modal:hover {
        color: #111;
    }

    .payment-proof-image {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 8px;
        margin: 20px 0;
    }

    .btn-approve {
        background: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-right: 10px;
    }

    .btn-approve:hover {
        background: #45a049;
    }

    .btn-reject {
        background: #f44336;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-reject:hover {
        background: #da190b;
    }

    .transaction-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .transaction-info div {
        margin-bottom: 8px;
    }

    .transaction-info strong {
        display: inline-block;
        width: 150px;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title m-0">Verifikasi Bukti Transfer</h3>
            <p class="text-muted small m-0">Kelola dan verifikasi bukti transfer dari pelanggan</p>
        </div>
    </div>

    <div class="card card-luxury">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th>Kode Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status Bukti</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="text-center text-muted fw-bold" style="font-size: 11px;">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <strong>{{ $transaction->kode_transaksi }}</strong>
                                    <div style="font-size: 11px; color: #999;">{{ $transaction->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td>
                                    <strong>{{ $transaction->nama_pembeli }}</strong>
                                    <div style="font-size: 11px; color: #999;">{{ $transaction->user->email ?? '-' }}</div>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $transaction->payment_proof_status }}">
                                        {{ ucfirst($transaction->payment_proof_status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn-view" onclick="viewPaymentProof({{ $transaction->id }})">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted">Belum ada bukti transfer yang diunggah.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk view bukti transfer -->
<div id="paymentProofModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Bukti Transfer</h2>
            <span class="close-modal" onclick="closeModal()">&times;</span>
        </div>
        <div id="modalBody">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<script>
function viewPaymentProof(transactionId) {
    // Simulate loading - in real app, this would fetch from server
    const transactions = @json($transactions);
    const transaction = transactions.find(t => t.id === transactionId);
    
    if (!transaction) return;

    let html = `
        <div class="transaction-info">
            <div><strong>Kode Transaksi:</strong> ${transaction.kode_transaksi}</div>
            <div><strong>Pelanggan:</strong> ${transaction.nama_pembeli}</div>
            <div><strong>Total:</strong> Rp ${transaction.grand_total.toLocaleString('id-ID')}</div>
            <div><strong>Tanggal Upload:</strong> ${new Date(transaction.updated_at).toLocaleDateString('id-ID')}</div>
        </div>
    `;

    if (transaction.payment_proof) {
        const fileUrl = '/storage/' + transaction.payment_proof;
        const ext = transaction.payment_proof.split('.').pop().toLowerCase();
        
        if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
            html += `<img src="${fileUrl}" alt="Bukti Transfer" class="payment-proof-image">`;
        } else if (ext === 'pdf') {
            html += `<div style="margin: 20px 0; text-align: center;">
                <p><i class="fas fa-file-pdf" style="font-size: 48px; color: #f44336; margin-bottom: 10px;"></i></p>
                <a href="${fileUrl}" target="_blank" class="btn-view" style="margin-right: 10px;">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>`;
        }
    }

    if (transaction.payment_proof_status === 'pending') {
        html += `
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <form action="/admin/transaksi/${transaction.id}/approve-payment-proof" method="POST" style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn-approve" style="width: 100%;">
                        <i class="fas fa-check me-1"></i> Setujui
                    </button>
                </form>
                <button onclick="showRejectForm(${transaction.id})" class="btn-reject" style="flex: 1;">
                    <i class="fas fa-times me-1"></i> Tolak
                </button>
            </div>
        `;
    } else if (transaction.payment_proof_status === 'rejected' && transaction.payment_proof_note) {
        html += `
            <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                <strong style="color: #856404;">Alasan Penolakan:</strong>
                <p style="margin-top: 10px; color: #856404;">${transaction.payment_proof_note}</p>
            </div>
        `;
    }

    document.getElementById('modalBody').innerHTML = html;
    document.getElementById('paymentProofModal').classList.add('show');
}

function closeModal() {
    document.getElementById('paymentProofModal').classList.remove('show');
}

function showRejectForm(transactionId) {
    const note = prompt('Masukkan alasan penolakan:');
    if (note !== null && note.trim() !== '') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/transaksi/${transactionId}/reject-payment-proof`;
        form.innerHTML = `
            @csrf
            <input type="hidden" name="note" value="${note}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('paymentProofModal');
    if (event.target == modal) {
        modal.classList.remove('show');
    }
}
</script>

@endsection
