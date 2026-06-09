@extends('layouts.app')

@section('title', 'Kelola Booking')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-calendar2-check"></i> Kelola Booking</h1>
</div>

<!-- Filter & Search -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/email customer..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table"></i> Daftar Booking
    </div>
    <div class="card-body">
        @if ($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
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
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
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
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada booking.
            </div>
        @endif
    </div>
</div>
@endsection
