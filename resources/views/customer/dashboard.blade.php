@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
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
            <h5>Selesai</h5>
            <h2>{{ $stats['completed_bookings'] }}</h2>
        </div>
    </div>
</div>

<!-- Quick Action -->
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Booking Baru
        </a>
    </div>
</div>

<!-- Booking List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar2-check"></i> Daftar Booking Saya
            </div>
            <div class="card-body">
                @if ($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tukang Cukur</th>
                                    <th>Layanan</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>
                                            <i class="bi bi-calendar"></i> 
                                            {{ $booking->getFormattedDate() }}
                                        </td>
                                        <td>
                                            <strong>{{ $booking->barber->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $booking->barber->getStatusLabel() }}</small>
                                        </td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>
                                            <strong>{{ $booking->service->getPriceFormatted() }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $booking->status }}">
                                                {{ $booking->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->payment)
                                                <span class="badge badge-{{ $booking->payment->status }}">
                                                    {{ $booking->payment->getStatusLabel() }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('customer.bookings.show', $booking) }}" 
                                                   class="btn btn-info" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                @if ($booking->status === 'pending' || $booking->status === 'approved')
                                                    <form action="{{ route('customer.bookings.cancel', $booking) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" 
                                                                onclick="return confirm('Yakin ingin membatalkan?')"
                                                                title="Batalkan">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($booking->payment && $booking->payment->status === 'pending' && $booking->status === 'approved')
                                                    <a href="{{ route('customer.payments.confirmation', $booking) }}" 
                                                       class="btn btn-warning" title="Bayar">
                                                        <i class="bi bi-credit-card"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $bookings->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> Anda belum membuat booking. 
                        <a href="{{ route('customer.bookings.create') }}" class="alert-link">Buat booking sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
