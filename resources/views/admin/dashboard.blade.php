@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <h5>Total Booking</h5>
            <h2>{{ $stats['total_bookings'] }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h5>Menunggu Konfirmasi</h5>
            <h2>{{ $stats['pending_bookings'] }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h5>Disetujui</h5>
            <h2>{{ $stats['approved_bookings'] }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h5>Total Revenue</h5>
            <h2>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h2>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <h5>Pending Pembayaran</h5>
            <h2>Rp {{ number_format($stats['pending_payments'], 0, ',', '.') }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
            <h5>Total Customer</h5>
            <h2>{{ $stats['total_customers'] }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
            <h5>Total Tukang Cukur</h5>
            <h2>{{ $stats['total_barbers'] }}</h2>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <a href="{{ route('admin.bookings.index') }}" class="stat-card" style="background: linear-gradient(135deg, #ff9a56 0%, #ff6a88 100%); text-decoration: none; color: white;">
            <h5>Kelola Data</h5>
            <h2><i class="bi bi-arrow-right"></i></h2>
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning"></i> Quick Actions
            </div>
            <div class="card-body">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-calendar2"></i> Kelola Booking
                </a>
                <a href="{{ route('admin.barbers.index') }}" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-person"></i> Kelola Tukang Cukur
                </a>
                <a href="{{ route('admin.services.index') }}" class="btn btn-success btn-sm me-2">
                    <i class="bi bi-scissors"></i> Kelola Layanan
                </a>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-credit-card"></i> Kelola Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-check"></i> Booking Terbaru
            </div>
            <div class="card-body">
                @if ($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Tukang Cukur</th>
                                    <th>Layanan</th>
                                    <th>Tanggal & Jam</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->customer->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $booking->customer->email }}</small>
                                        </td>
                                        <td>{{ $booking->barber->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ $booking->getFormattedDate() }}</td>
                                        <td>
                                            <span class="badge badge-{{ $booking->status }}">
                                                {{ $booking->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $booking->payment->status }}">
                                                {{ $booking->payment->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada booking.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
