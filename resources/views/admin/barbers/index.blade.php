@extends('layouts.app')

@section('title', 'Kelola Tukang Cukur')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person"></i> Kelola Tukang Cukur</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tukang Cukur</li>
        </ol>
    </nav>
</div>

<!-- Add Button -->
<div class="mb-3">
    <a href="{{ route('admin.barbers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Tukang Cukur
    </a>
</div>

<!-- Barbers List -->
<div class="row">
    @forelse ($barbers as $barber)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; margin: 0 auto 15px;">
                        <i class="bi bi-person"></i>
                    </div>
                    <h5 class="card-title text-center">{{ $barber->name }}</h5>
                    
                    <p class="text-center mb-2">
                        <span class="badge" style="background-color: {{ $barber->status === 'available' ? '#28a745' : ($barber->status === 'busy' ? '#dc3545' : '#ffc107') }};">
                            {{ $barber->getStatusLabel() }}
                        </span>
                    </p>

                    <div class="small text-muted">
                        <p><strong>Pengalaman:</strong> {{ $barber->experience_years }} tahun</p>
                        @if ($barber->phone)
                            <p><strong>Telepon:</strong> {{ $barber->phone }}</p>
                        @endif
                        @if ($barber->bio)
                            <p><strong>Bio:</strong> {{ Str::limit($barber->bio, 50) }}</p>
                        @endif
                        <p><strong>Total Booking:</strong> {{ $barber->bookings->count() }}</p>
                    </div>

                    <div class="btn-group w-100 mt-3" role="group">
                        <a href="{{ route('admin.barbers.edit', $barber) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.barbers.delete', $barber) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Tidak ada tukang cukur. 
                <a href="{{ route('admin.barbers.create') }}" class="alert-link">Tambah yang baru</a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if ($barbers->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $barbers->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
