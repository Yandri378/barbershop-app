@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('extra-styles')
<style>
    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .payment-method {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #667eea;
        background-color: #f8f9ff;
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-method.selected {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .payment-icon {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .bank-instructions {
        background-color: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 15px;
        border-radius: 4px;
        margin-top: 20px;
        display: none;
    }

    .bank-instructions.show {
        display: block;
    }

    .detail-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item strong {
        flex: 1;
    }

    .detail-item .value {
        text-align: right;
        font-weight: bold;
        color: #667eea;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-credit-card"></i> Konfirmasi Pembayaran</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Booking Summary -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-calendar-check"></i> Ringkasan Booking
            </div>
            <div class="card-body">
                <div class="detail-section">
                    <div class="detail-item">
                        <strong>ID Booking:</strong>
                        <span class="value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Layanan:</strong>
                        <span class="value">{{ $booking->service->name }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Tukang Cukur:</strong>
                        <span class="value">{{ $booking->barber->name }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Tanggal & Jam:</strong>
                        <span class="value">{{ $booking->getFormattedDate() }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Harga Layanan:</strong>
                        <span class="value">{{ $booking->service->getPriceFormatted() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method Selection -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-credit-card"></i> Pilih Metode Pembayaran
            </div>
            <div class="card-body">
                <form id="paymentForm" action="{{ route('customer.payments.submit', $booking) }}" method="POST">
                    @csrf

                    <div class="payment-methods">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="transfer" required>
                            <div class="payment-icon"><i class="bi bi-bank"></i></div>
                            <div><strong>Transfer Bank</strong></div>
                            <small class="text-muted">ke rekening admin</small>
                        </label>

                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash" required>
                            <div class="payment-icon"><i class="bi bi-cash-coin"></i></div>
                            <div><strong>Tunai</strong></div>
                            <small class="text-muted">saat kunjungan</small>
                        </label>
                    </div>

                    <!-- Transfer Instructions -->
                    <div class="bank-instructions" id="bankInstructions">
                        <h5 class="mb-3"><i class="bi bi-info-circle"></i> Petunjuk Transfer</h5>
                        <p><strong>Rekening Admin:</strong></p>
                        <ul>
                            <li>Bank: BCA</li>
                            <li>Nomor Rekening: 1234567890</li>
                            <li>Atas Nama: BarberShop Admin</li>
                        </ul>
                        <p class="mb-0 text-muted"><small>Masukkan ID Booking sebagai keterangan transfer</small></p>
                    </div>

                    <!-- Transaction ID -->
                    <div class="form-group mb-3">
                        <label for="transaction_id" class="form-label">ID Transaksi / Bukti Transfer (Opsional)</label>
                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" 
                               placeholder="Masukkan nomor referensi atau bukti transfer">
                        <small class="text-muted">Membantu admin mengkonfirmasi pembayaran</small>
                    </div>

                    <!-- Notes -->
                    <div class="form-group mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Tuliskan informasi tambahan jika ada..."></textarea>
                    </div>

                    <!-- Checkbox Agreement -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agreement" required>
                        <label class="form-check-label" for="agreement">
                            Saya sudah melakukan pembayaran sesuai metode yang dipilih dan siap menunggu konfirmasi dari admin
                        </label>
                    </div>

                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Kirim Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Total Payment -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-credit-card"></i> Total Pembayaran
            </div>
            <div class="card-body text-center">
                <h4 class="text-muted mb-3">Jumlah Pembayaran</h4>
                <h2 class="text-primary mb-3" id="totalPayment">{{ $payment->getAmountFormatted() }}</h2>
                <span class="badge badge-warning" style="font-size: 1rem;">
                    {{ $payment->getStatusLabel() }}
                </span>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-exclamation-triangle"></i> Penting
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <p><strong><i class="bi bi-clock"></i> Waktu Pembayaran</strong></p>
                    <p>Pembayaran harus dilakukan sebelum jam booking Anda. Admin akan mengkonfirmasi pembayaran dalam waktu maksimal 30 menit.</p>
                </div>

                <div class="alert alert-info">
                    <p><strong><i class="bi bi-info-circle"></i> Cara Konfirmasi</strong></p>
                    <p>Setelah Anda mengirim pembayaran, tunggu admin mengkonfirmasi. Anda akan melihat status "Sudah Dibayar" di dashboard.</p>
                </div>

                <div class="alert alert-light">
                    <p><strong><i class="bi bi-question-circle"></i> Pertanyaan?</strong></p>
                    <p class="mb-0">Hubungi admin untuk bantuan lebih lanjut.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-scripts')
<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
            this.closest('.payment-method').classList.add('selected');

            const instructions = document.getElementById('bankInstructions');
            if (this.value === 'transfer') {
                instructions.classList.add('show');
            } else {
                instructions.classList.remove('show');
            }
        });
    });
</script>
@endsection
