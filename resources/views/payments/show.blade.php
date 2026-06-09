@extends('layouts.app')

@section('title', 'Info Pembayaran')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-credit-card"></i> Informasi Pembayaran</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Rincian Pembayaran
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Booking</strong></p>
                        <h5>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status Pembayaran</strong></p>
                        <p>
                            <span class="badge badge-{{ $payment->status }}" style="font-size: 1rem;">
                                {{ $payment->getStatusLabel() }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Layanan</strong></p>
                        <p>{{ $booking->service->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tukang Cukur</strong></p>
                        <p>{{ $booking->barber->name }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tanggal & Jam</strong></p>
                        <p>{{ $booking->getFormattedDate() }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Metode Pembayaran</strong></p>
                        <p>{{ $payment->payment_method ?? '-' }}</p>
                    </div>
                </div>

                @if ($payment->transaction_id)
                    <hr>
                    <p class="mb-1"><strong>ID Transaksi</strong></p>
                    <p>{{ $payment->transaction_id }}</p>
                @endif

                @if ($payment->notes)
                    <hr>
                    <p class="mb-1"><strong>Catatan</strong></p>
                    <p>{{ $payment->notes }}</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-arrow-repeat"></i> Riwayat Pembayaran
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker" style="background-color: #28a745;">
                            <i class="bi bi-check"></i>
                        </div>
                        <div class="timeline-content">
                            <strong>Pembayaran Dibuat</strong>
                            <p class="text-muted small">{{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($payment->updated_at != $payment->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker" style="background-color: {{ $payment->status === 'paid' ? '#28a745' : '#dc3545' }};">
                                <i class="bi bi-{{ $payment->status === 'paid' ? 'check' : 'x' }}"></i>
                            </div>
                            <div class="timeline-content">
                                <strong>{{ $payment->getStatusLabel() }}</strong>
                                <p class="text-muted small">{{ $payment->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-currency-dollar"></i> Total Pembayaran
            </div>
            <div class="card-body text-center">
                <h4 class="text-muted mb-3">Jumlah Pembayaran</h4>
                <h2 class="text-primary">{{ $payment->getAmountFormatted() }}</h2>
            </div>
        </div>

        @if ($payment->status === 'pending')
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi
                </div>
                <div class="card-body">
                    <p class="text-muted">Admin sedang memverifikasi pembayaran Anda. Silakan tunggu...</p>
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </card>
        @elseif ($payment->status === 'paid')
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-check-circle"></i> Pembayaran Dikonfirmasi
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Pembayaran Anda telah dikonfirmasi!
                    </div>
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-left"></i> Lihat Booking
                    </a>
                </div>
            </card>
        @else
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle"></i> Pembayaran Gagal
                </div>
                <div class="card-body">
                    <p class="text-danger">Pembayaran tidak berhasil dikonfirmasi.</p>
                    <a href="{{ route('customer.payments.confirmation', $booking) }}" class="btn btn-warning w-100">
                        <i class="bi bi-repeat"></i> Coba Lagi
                    </a>
                </div>
            </card>
        @endif
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 10px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
    }

    .timeline-marker {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        flex-shrink: 0;
        font-weight: bold;
    }

    .timeline-content strong {
        display: block;
        margin-bottom: 5px;
    }
</style>
@endsection
