@extends('layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-scissors"></i> Kelola Layanan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Layanan</li>
        </ol>
    </nav>
</div>

<!-- Add Button -->
<div class="mb-3">
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Layanan
    </a>
</div>

<!-- Services Table -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table"></i> Daftar Layanan
    </div>
    <div class="card-body">
        @if ($services->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Layanan</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th>Total Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>
                                    <strong>{{ $service->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                </td>
                                <td>
                                    <h5 class="text-primary">{{ $service->getPriceFormatted() }}</h5>
                                </td>
                                <td>{{ $service->duration_minutes }} menit</td>
                                <td>{{ $service->bookings->count() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.services.delete', $service) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $services->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada layanan. 
                <a href="{{ route('admin.services.create') }}" class="alert-link">Tambah yang baru</a>
            </div>
        @endif
    </div>
</div>
@endsection
