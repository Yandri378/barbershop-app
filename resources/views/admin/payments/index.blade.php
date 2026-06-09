@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-credit-card"></i> Kelola Pembayaran</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>
    </nav>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table"></i> Daftar Pembayaran
    </div>
    <div class="card-body">
        @if ($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Booking</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>#{{ str_pad($payment->booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <strong>{{ $payment->booking->customer->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $payment->booking->customer->email }}</small>
                                </td>
                                <td>{{ $payment->booking->service->name }}</td>
                                <td>
                                    <h5 class="text-primary">{{ $payment->getAmountFormatted() }}</h5>
                                </td>
                                <td>{{ $payment->payment_method ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $payment->status }}">
                                        {{ $payment->getStatusLabel() }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="btn btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if ($payment->status === 'pending')
                                            <form action="{{ route('admin.payments.mark-paid', $payment) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success" title="Tandai Sudah Dibayar">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.payments.mark-failed', $payment) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" title="Tandai Gagal">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada pembayaran.
            </div>
        @endif
    </div>
</div>
@endsection
