@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-calendar-check"></i> Detail Booking</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Detail Booking</li>
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
                        <p class="mb-1"><strong>Status Booking</strong></p>
                        <p>
                            <span class="badge badge-{{ $booking->status }}">
                                {{ $booking->getStatusLabel() }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Booking</strong></p>
                        <p>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-calendar"></i> Tanggal & Jam</strong></p>
                        <p>{{ $booking->getFormattedDate() }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-scissors"></i> Layanan</strong></p>
                        <p>{{ $booking->service->name }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-person"></i> Tukang Cukur</strong></p>
                        <p>{{ $booking->barber->name }}</p>
                        <small class="text-muted">Pengalaman: {{ $booking->barber->experience_years }} tahun</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="mb-1"><strong><i class="bi bi-clock"></i> Durasi</strong></p>
                        <p>{{ $booking->service->duration_minutes }} menit</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barber Details -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person"></i> Detail Tukang Cukur
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; margin: 0 auto;">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h4>{{ $booking->barber->name }}</h4>
                        <p class="text-muted">{{ $booking->barber->bio }}</p>
                        <p>
                            <strong>Pengalaman:</strong> {{ $booking->barber->experience_years }} tahun
                        </p>
                        <p>
                            <strong>Status:</strong> 
                            <span class="availability-indicator" style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ $booking->barber->status === 'available' ? '#28a745' : ($booking->barber->status === 'busy' ? '#dc3545' : '#ffc107') }};"></span>
                            {{ $booking->barber->getStatusLabel() }}
                        </p>
                        @if ($booking->barber->phone)
                            <p>
                                <strong>Telepon:</strong> {{ $booking->barber->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-scissors"></i> Detail Layanan
            </div>
            <div class="card-body">
                <h5>{{ $booking->service->name }}</h5>
                <p class="text-muted">{{ $booking->service->description }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Harga:</strong></p>
                        <h4 class="text-primary">{{ $booking->service->getPriceFormatted() }}</h4>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Durasi:</strong></p>
                        <h4>{{ $booking->service->duration_minutes }} menit</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Section -->
        @include('reviews.submit')

        <!-- Display Review -->
        @if ($booking->review)
            @include('reviews.display')
        @endif

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="btn-group w-100" role="group">
                    @if ($booking->status === 'pending' || $booking->status === 'approved')
                        <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Yakin ingin membatalkan booking ini?')">
                                <i class="bi bi-x-circle"></i> Batalkan Booking
                            </button>
                        </form>
                    @endif

                    @if ($booking->payment && $booking->payment->status === 'pending' && $booking->status === 'approved')
                        <a href="{{ route('customer.payments.confirmation', $booking) }}" class="btn btn-warning flex-grow-1">
                            <i class="bi bi-credit-card"></i> Lakukan Pembayaran
                        </a>
                    @endif

                    <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary flex-grow-1">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Payment Card -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-credit-card"></i> Status Pembayaran
            </div>
            <div class="card-body">
                @if($booking->payment)
                    <div class="text-center mb-3">
                        <span class="badge badge-{{ $booking->payment->status }}" style="font-size: 1.1rem; padding: 10px 20px;">
                            {{ $booking->payment->getStatusLabel() }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1"><strong>Total Pembayaran</strong></p>
                        <h3 class="text-primary">{{ $booking->payment->getAmountFormatted() }}</h3>
                    </div>

                    <hr>

                    @if ($booking->payment->status === 'pending')
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle"></i> 
                            Silakan lakukan pembayaran sebelum jam booking.
                        </div>
                    @elseif ($booking->payment->status === 'paid')
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> 
                            Pembayaran sudah dikonfirmasi.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> 
                            Pembayaran gagal. Hubungi admin.
                        </div>
                    @endif

                    <p class="mb-1"><strong>Metode Pembayaran</strong></p>
                    <p>{{ $booking->payment->payment_method ?? 'Belum ditentukan' }}</p>

                    @if ($booking->payment->transaction_id)
                        <p class="mb-1"><strong>ID Transaksi</strong></p>
                        <p>{{ $booking->payment->transaction_id }}</p>
                    @endif

                    @if ($booking->payment->notes)
                        <p class="mb-1"><strong>Catatan</strong></p>
                        <p>{{ $booking->payment->notes }}</p>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        Pembayaran belum tercatat dalam sistem.
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-hourglass-split"></i> Timeline
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker" style="background-color: #28a745;">
                            <i class="bi bi-check"></i>
                        </div>
                        <div class="timeline-content">
                            <strong>Booking Dibuat</strong>
                            <p class="text-muted small">{{ $booking->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($booking->status === 'approved' || $booking->status === 'completed' || $booking->status === 'rejected')
                        <div class="timeline-item">
                            <div class="timeline-marker" style="background-color: {{ $booking->status === 'rejected' ? '#dc3545' : '#28a745' }};">
                                <i class="bi bi-{{ $booking->status === 'rejected' ? 'x' : 'check' }}"></i>
                            </div>
                            <div class="timeline-content">
                                <strong>{{ $booking->getStatusLabel() }}</strong>
                                <p class="text-muted small">{{ $booking->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($booking->payment && $booking->payment->status === 'paid')
                        <div class="timeline-item">
                            <div class="timeline-marker" style="background-color: #28a745;">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="timeline-content">
                                <strong>Pembayaran Dikonfirmasi</strong>
                                <p class="text-muted small">{{ $booking->payment->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
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

    .timeline-item:not(:last-child) .timeline-marker::after {
        content: '';
        position: absolute;
        width: 2px;
        height: 50px;
        background: #ddd;
        left: 19px;
        top: 40px;
    }

    .timeline-content strong {
        display: block;
        margin-bottom: 5px;
    }

    .availability-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }
</style>
@endsection
