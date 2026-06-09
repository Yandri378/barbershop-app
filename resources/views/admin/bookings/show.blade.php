@extends('layouts.app')

@section('title', 'Detail Booking - Admin')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-calendar-check"></i> Detail Booking</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Booking</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Booking Details -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informasi Booking
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Booking</strong></p>
                        <p>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status</strong></p>
                        <p>
                            <span class="badge badge-{{ $booking->status }}" style="font-size: 1rem;">
                                {{ $booking->getStatusLabel() }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-person"></i> Customer</strong></p>
                        <p><strong>{{ $booking->customer->name }}</strong></p>
                        <p class="text-muted">{{ $booking->customer->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-calendar"></i> Tanggal & Jam</strong></p>
                        <p><strong>{{ $booking->getFormattedDate() }}</strong></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-person"></i> Tukang Cukur</strong></p>
                        <p><strong>{{ $booking->barber->name }}</strong></p>
                        <p class="text-muted">{{ $booking->barber->experience_years }} tahun pengalaman</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-scissors"></i> Layanan</strong></p>
                        <p><strong>{{ $booking->service->name }}</strong></p>
                        <p class="text-muted">{{ $booking->service->duration_minutes }} menit</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Harga</strong></p>
                        <h4 class="text-primary">{{ $booking->service->getPriceFormatted() }}</h4>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Dibuat</strong></p>
                        <p>{{ $booking->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Section -->
        @if ($booking->status === 'pending')
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-check2-square"></i> Aksi Booking
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" style="margin-bottom: 0;">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Setujui
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Booking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="reason" class="form-label">Alasan Penolakan</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @elseif ($booking->status === 'approved')
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-check2-square"></i> Aksi Booking
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="bi bi-check-circle"></i> Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Payment Details -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-credit-card"></i> Detail Pembayaran
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status Pembayaran</strong></p>
                        <p>
                            <span class="badge badge-{{ $booking->payment->status }}" style="font-size: 1rem;">
                                {{ $booking->payment->getStatusLabel() }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Total</strong></p>
                        <h4 class="text-primary">{{ $booking->payment->getAmountFormatted() }}</h4>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Metode Pembayaran</strong></p>
                        <p>{{ $booking->payment->payment_method ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Transaksi</strong></p>
                        <p>{{ $booking->payment->transaction_id ?? '-' }}</p>
                    </div>
                </div>

                @if ($booking->payment->notes)
                    <hr>
                    <p class="mb-1"><strong>Catatan</strong></p>
                    <p>{{ $booking->payment->notes }}</p>
                @endif

                @if ($booking->payment->status === 'pending')
                    <hr>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="bi bi-credit-card"></i> Update Status Pembayaran
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person"></i> Informasi Customer
            </div>
            <div class="card-body">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 30px; margin: 0 auto 15px;">
                    <i class="bi bi-person"></i>
                </div>
                <h5 class="text-center mb-3">{{ $booking->customer->name }}</h5>
                <p>
                    <strong>Email:</strong><br>
                    {{ $booking->customer->email }}
                </p>
            </div>
        </div>

        <!-- Barber Info -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person-check"></i> Informasi Tukang Cukur
            </div>
            <div class="card-body">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 30px; margin: 0 auto 15px;">
                    <i class="bi bi-person"></i>
                </div>
                <h5 class="text-center mb-3">{{ $booking->barber->name }}</h5>
                <p>
                    <strong>Status:</strong><br>
                    <span class="badge" style="background-color: {{ $booking->barber->status === 'available' ? '#28a745' : ($booking->barber->status === 'busy' ? '#dc3545' : '#ffc107') }};">
                        {{ $booking->barber->getStatusLabel() }}
                    </span>
                </p>
                <p>
                    <strong>Pengalaman:</strong><br>
                    {{ $booking->barber->experience_years }} tahun
                </p>
                @if ($booking->barber->phone)
                    <p>
                        <strong>Telepon:</strong><br>
                        {{ $booking->barber->phone }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Payment Status Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.payments.mark-paid', $booking->payment) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">Tandai pembayaran sebagai sudah diterima?</p>
                    <div class="form-group mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
