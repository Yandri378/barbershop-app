@extends('layouts.app')

@section('title', 'Buat Booking')

@section('extra-styles')
<style>
    .booking-wizard {
        background: rgba(45, 45, 45, 0.95);
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(212, 175, 55, 0.2);
        border: 1px solid rgba(212, 175, 55, 0.3);
        backdrop-filter: blur(10px);
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
        position: relative;
        overflow: hidden;
    }

    .booking-wizard::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23d4af37" fill-opacity="0.05"><path d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg>'),
            linear-gradient(135deg, rgba(26, 26, 26, 0.8), rgba(45, 45, 45, 0.8));
        pointer-events: none;
        z-index: 0;
    }

    .booking-wizard > * {
        position: relative;
        z-index: 1;
    }

    .wizard-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
        padding: 25px;
        border-radius: 12px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .wizard-step {
        flex: 1;
        text-align: center;
        position: relative;
        padding: 0 20px;
    }

    .wizard-step::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 3px;
        background: rgba(212, 175, 55, 0.2);
        z-index: -1;
    }

    .wizard-step:first-child::before {
        display: none;
    }

    .wizard-step.active::before,
    .wizard-step.completed::before {
        background: linear-gradient(90deg, var(--secondary-color) 0%, #ffd700 100%);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .wizard-step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.1);
        color: var(--light-text);
        font-weight: bold;
        margin-bottom: 10px;
        border: 2px solid rgba(212, 175, 55, 0.3);
        transition: all 0.3s ease;
    }

    .wizard-step.active .wizard-step-number,
    .wizard-step.completed .wizard-step-number {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
        color: var(--primary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        transform: scale(1.1);
    }

    .wizard-step-title {
        font-size: 14px;
        color: var(--light-text);
        margin-top: 10px;
        font-weight: 500;
    }

    .wizard-step.active .wizard-step-title {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .form-section {
        display: none;
        animation: fadeInUp 0.5s ease;
    }

    .form-section.active {
        display: block;
    }

    .form-section h4 {
        color: var(--secondary-color);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 25px;
        text-shadow: 0 2px 4px rgba(212, 175, 55, 0.2);
    }

    .service-card, .barber-card, .time-slot {
        border: 2px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        background: rgba(45, 45, 45, 0.6);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        position: relative;
    }

    .service-card:hover, .barber-card:hover, .time-slot:hover {
        border-color: var(--secondary-color);
        background: rgba(212, 175, 55, 0.05);
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
    }

    .service-card.selected, .barber-card.selected, .time-slot.selected {
        border-color: var(--secondary-color);
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.08) 100%);
        box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.2), 0 0 20px rgba(212, 175, 55, 0.3);
        transform: scale(1.02);
    }

    .service-card.selected::before {
        content: '✓';
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: var(--secondary-color);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .barber-card.selected::before {
        content: '✓';
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: var(--secondary-color);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .service-card input, .barber-card input, .time-slot input {
        display: none;
    }

    .barber-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 40px;
        margin-bottom: 15px;
    }

    .time-slot {
        flex: 0 1 calc(20% - 10px);
        min-height: 80px;
    }

    .availability-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
        animation: pulse 2s ease-in-out infinite;
    }

    .date-picker {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .date-option {
        flex: 0 1 calc(14.28% - 10px);
        min-width: 80px;
        border: 2px solid rgba(212, 175, 55, 0.3);
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(45, 45, 45, 0.6);
    }

    .date-option:hover {
        border-color: var(--secondary-color);
        background: rgba(212, 175, 55, 0.08);
        transform: translateY(-3px);
    }

    .date-option.selected {
        border-color: var(--secondary-color);
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.08) 100%);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
    }

    .date-option.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .date-day {
        font-size: 11px;
        color: #999;
        font-weight: 500;
    }

    .date-date {
        font-weight: bold;
        font-size: 18px;
        color: var(--secondary-color);
        margin-top: 5px;
    }

    .wizard-nav {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid rgba(212, 175, 55, 0.2);
    }

    .btn-nav {
        padding: 12px 30px;
        font-weight: 700;
        border-radius: 10px;
        transition: all 0.3s ease;
        flex: 1;
    }

    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 30px;
        color: var(--light-text);
    }

    .time-slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(85px, 1fr));
        gap: 12px;
        margin-top: 20px;
    }

    .confirmation-card {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
        border: 2px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .confirmation-card p {
        margin: 10px 0;
        color: var(--light-text);
    }

    .confirmation-card strong {
        color: var(--secondary-color);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
        border: none;
        color: var(--primary-color);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #ffd700 0%, var(--secondary-color) 100%);
        color: var(--primary-color);
    }

    .btn-secondary {
        background: rgba(212, 175, 55, 0.2);
        border: 1px solid rgba(212, 175, 55, 0.4);
        color: var(--light-text);
    }

    .btn-secondary:hover {
        background: rgba(212, 175, 55, 0.3);
        border-color: var(--secondary-color);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-calendar-plus"></i> Buat Booking Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Booking Baru</li>
        </ol>
    </nav>
</div>

<div class="booking-wizard">
    <!-- Wizard Steps -->
    <div class="wizard-steps">
        <div class="wizard-step active" data-step="1">
            <div class="wizard-step-number">1</div>
            <div class="wizard-step-title">Pilih Layanan</div>
        </div>
        <div class="wizard-step" data-step="2">
            <div class="wizard-step-number">2</div>
            <div class="wizard-step-title">Pilih Tukang Cukur</div>
        </div>
        <div class="wizard-step" data-step="3">
            <div class="wizard-step-number">3</div>
            <div class="wizard-step-title">Pilih Tanggal & Jam</div>
        </div>
        <div class="wizard-step" data-step="4">
            <div class="wizard-step-number">4</div>
            <div class="wizard-step-title">Konfirmasi</div>
        </div>
    </div>

    <form id="bookingForm" action="{{ route('customer.bookings.store') }}" method="POST">
        @csrf

        <!-- Step 1: Select Service -->
        <div class="form-section active" data-section="1">
            <h4><i class="bi bi-scissors"></i> Pilih Layanan</h4>
            <div class="row">
                @foreach ($services as $service)
                    <div class="col-12 col-md-8 offset-md-2">
                        <label class="service-card" style="cursor: pointer;" data-service-id="{{ $service->id }}" data-service-price="{{ $service->price }}" data-service-name="{{ $service->name }}">
                            <input type="radio" name="service_id" value="{{ $service->id }}" required {{ $loop->first ? 'checked' : '' }}>
                            <div style="font-size: 48px; color: var(--secondary-color); margin-bottom: 15px;">✨</div>
                            <h5 style="color: var(--secondary-color); font-weight: 700; font-size: 1.4rem;">{{ $service->name }}</h5>
                            <p class="text-muted" style="margin: 15px 0; font-size: 0.95rem;">{{ $service->description }}</p>
                            <div style="margin-top: 15px; padding: 15px; background: rgba(212, 175, 55, 0.1); border-radius: 8px;">
                                <strong class="text-primary" style="color: var(--secondary-color); font-size: 1.3rem;">{{ $service->getPriceFormatted() }}</strong>
                                <br>
                                <small class="text-muted">⏱️ {{ $service->duration_minutes }} menit</small>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Step 2: Select Barber -->
        <div class="form-section" data-section="2">
            <h4><i class="bi bi-person-badge"></i> Pilih Tukang Cukur</h4>
            <div class="row">
                @foreach ($barbers as $barber)
                    @php
                        $avgRating = $barber->getAverageRating();
                        $reviewCount = $barber->getReviewCount();
                    @endphp
                    <div class="col-md-4 mb-3">
                        <label class="barber-card">
                            <input type="radio" name="barber_id" value="{{ $barber->id }}" required>
                            <div class="barber-photo">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h5 style="color: var(--secondary-color); font-weight: 700;">{{ $barber->name }}</h5>
                            <p class="mb-2 text-muted">{{ $barber->experience_years }} tahun pengalaman</p>
                            
                            <!-- Rating Display -->
                            <div class="mb-2" style="font-size: 0.9rem;">
                                @if ($reviewCount > 0)
                                    <div style="color: var(--secondary-color); margin-bottom: 5px;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($avgRating))
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <small style="color: var(--secondary-color);">{{ round($avgRating, 1) }}/5 
                                        <span style="color: #999;">({{ $reviewCount }})</span>
                                    </small>
                                @else
                                    <small style="color: #999;">⭐ Belum ada review</small>
                                @endif
                            </div>

                            <div style="margin-top: 10px; font-size: 0.85rem;">
                                <span class="availability-indicator" style="background-color: {{ $barber->status === 'available' ? '#28a745' : ($barber->status === 'busy' ? '#dc3545' : '#ffc107') }};"></span>
                                <small style="color: {{ $barber->status === 'available' ? '#28a745' : '#ffc107' }};">{{ $barber->getStatusLabel() }}</small>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Step 3: Select Date & Time -->
        <div class="form-section" data-section="3">
            <h4><i class="bi bi-calendar2"></i> Pilih Tanggal & Jam</h4>

            <!-- Date Selection -->
            <div class="mb-4">
                <label class="form-label fw-bold" style="color: var(--light-text);">Tanggal Booking</label>
                <div class="date-picker" id="datePicker">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $date = now()->addDays($i);
                            $isToday = $i === 0;
                        @endphp
                        <div class="date-option {{ $isToday ? 'selected' : '' }}" data-date="{{ $date->format('Y-m-d') }}">
                            <div class="date-day">{{ $date->format('D') }}</div>
                            <div class="date-date">{{ $date->format('d') }}</div>
                        </div>
                    @endfor
                </div>
                <input type="hidden" id="selectedDate" name="booking_date" value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <!-- Time Selection -->
            <div>
                <label class="form-label fw-bold" style="color: var(--light-text);">Jam Booking</label>
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p style="margin-top: 10px;">Memuat jam tersedia...</p>
                </div>
                <div class="time-slots-grid" id="timeSlots">
                    <!-- Time slots will be loaded here -->
                </div>
            </div>
        </div>

        <!-- Step 4: Confirmation -->
        <div class="form-section" data-section="4">
            <h4><i class="bi bi-check-circle"></i> Konfirmasi Booking</h4>
            <div class="confirmation-card">
                <p><strong>📋 Layanan:</strong><br><span id="confirmService">-</span></p>
                <p><strong>💇 Tukang Cukur:</strong><br><span id="confirmBarber">-</span></p>
                <p><strong>📅 Tanggal & Jam:</strong><br><span id="confirmDateTime">-</span></p>
                <p><strong>💰 Harga:</strong><br><span id="confirmPrice" style="color: var(--secondary-color); font-size: 1.2rem;">-</span></p>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="wizard-nav">
            <button type="button" class="btn btn-secondary btn-nav" id="prevBtn" style="display: none;">
                <i class="bi bi-arrow-left"></i> Sebelumnya
            </button>
            <button type="button" class="btn btn-primary btn-nav" id="nextBtn">
                <i class="bi bi-arrow-right"></i> Selanjutnya
            </button>
            <button type="submit" class="btn btn-success btn-nav" id="submitBtn" style="display: none;">
                <i class="bi bi-check-circle"></i> Konfirmasi Booking
            </button>
        </div>
    </form>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    document.addEventListener('DOMContentLoaded', initializeForm);

    function initializeForm() {
        // Service card selection
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function() {
                const input = this.querySelector('input[type="radio"]');
                input.checked = true;
                document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
            const input = card.querySelector('input[type="radio"]');
            input.addEventListener('change', function() {
                document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
                if (this.checked) card.classList.add('selected');
            });
        });

        // Barber card selection
        document.querySelectorAll('.barber-card').forEach(card => {
            card.addEventListener('click', function() {
                const input = this.querySelector('input[type="radio"]');
                input.checked = true;
                document.querySelectorAll('.barber-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
            const input = card.querySelector('input[type="radio"]');
            input.addEventListener('change', function() {
                document.querySelectorAll('.barber-card').forEach(c => c.classList.remove('selected'));
                if (this.checked) {
                    card.classList.add('selected');
                    if (currentStep === 3) loadTimeSlots();
                }
            });
        });

        // Date selection
        document.querySelectorAll('.date-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.date-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selectedDate').value = this.dataset.date;
                if (currentStep === 3) loadTimeSlots();
            });
        });

        // Time slot selection
        document.addEventListener('change', function(e) {
            if (e.target.name === 'time') {
                document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
                if (e.target.checked) e.target.closest('.time-slot').classList.add('selected');
            }
        });

        // Navigation
        document.getElementById('nextBtn').addEventListener('click', handleNext);
        document.getElementById('prevBtn').addEventListener('click', handlePrevious);
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            if (currentStep !== totalSteps) {
                e.preventDefault();
                handleNext();
            }
        });

        // Set first service as selected
        const firstService = document.querySelector('.service-card input[type="radio"]');
        if (firstService) {
            firstService.checked = true;
            firstService.closest('.service-card').classList.add('selected');
        }

        updateForm();
    }

    function loadTimeSlots() {
        const barberId = document.querySelector('input[name="barber_id"]:checked');
        const date = document.getElementById('selectedDate').value;

        if (!barberId || !date) {
            document.getElementById('timeSlots').innerHTML = '<p class="text-muted">Pilih tukang cukur terlebih dahulu</p>';
            return;
        }

        document.getElementById('loadingSpinner').style.display = 'block';
        document.getElementById('timeSlots').innerHTML = '';

        fetch(`{{ route('customer.bookings.slots') }}?barber_id=${barberId.value}&date=${date}`)
            .then(response => response.ok ? response.json() : Promise.reject('Gagal memuat jam'))
            .then(slots => {
                document.getElementById('loadingSpinner').style.display = 'none';
                if (!slots || slots.length === 0) {
                    document.getElementById('timeSlots').innerHTML = '<p class="text-muted">Tidak ada jam tersedia</p>';
                    return;
                }
                document.getElementById('timeSlots').innerHTML = slots.map(slot => `
                    <label class="time-slot" ${!slot.available ? 'style="opacity: 0.5;"' : ''}>
                        <input type="radio" name="time" value="${slot.time}" ${!slot.available ? 'disabled' : ''} required>
                        <span style="font-weight: 600;">${slot.time}</span>
                        ${!slot.available ? '<span style="font-size: 0.8rem; color: #999;">Terpesan</span>' : ''}
                    </label>
                `).join('');
            })
            .catch(error => {
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('timeSlots').innerHTML = '<p class="text-danger">Gagal memuat jam tersedia</p>';
            });
    }

    function handleNext() {
        if (!validateStep(currentStep)) {
            alert(getValidationMessage(currentStep));
            return;
        }

        if (currentStep < totalSteps) {
            currentStep++;
            if (currentStep === 3) loadTimeSlots();
            if (currentStep === totalSteps) updateConfirmation();
            updateForm();
        }
    }

    function handlePrevious() {
        if (currentStep > 1) {
            currentStep--;
            updateForm();
        }
    }

    function validateStep(step) {
        const checks = {
            1: () => document.querySelector('input[name="service_id"]:checked'),
            2: () => document.querySelector('input[name="barber_id"]:checked'),
            3: () => document.querySelector('input[name="booking_date"]').value && document.querySelector('input[name="time"]:checked')
        };
        return checks[step]?.() ? true : false;
    }

    function getValidationMessage(step) {
        const messages = { 1: 'Pilih layanan', 2: 'Pilih tukang cukur', 3: 'Pilih tanggal dan jam' };
        return messages[step] || 'Lengkapi form';
    }

    function updateConfirmation() {
        const serviceCard = document.querySelector('input[name="service_id"]:checked')?.closest('.service-card');
        const barberCard = document.querySelector('input[name="barber_id"]:checked')?.closest('.barber-card');
        
        const serviceName = serviceCard?.getAttribute('data-service-name') || '-';
        const servicePrice = serviceCard?.getAttribute('data-service-price') || '0';
        const barberName = barberCard?.querySelector('h5')?.textContent || '-';
        const date = document.getElementById('selectedDate').value;
        const time = document.querySelector('input[name="time"]:checked')?.value || '-';

        document.getElementById('confirmService').textContent = serviceName;
        document.getElementById('confirmBarber').textContent = barberName;
        document.getElementById('confirmDateTime').textContent = new Date(date).toLocaleDateString('id-ID', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}) + ' - ' + time;
        
        // Format the price
        const priceNum = parseInt(servicePrice);
        const formattedPrice = 'Rp ' + priceNum.toLocaleString('id-ID');
        document.getElementById('confirmPrice').textContent = formattedPrice;
    }

    function updateForm() {
        document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
        document.querySelector(`.form-section[data-section="${currentStep}"]`).classList.add('active');

        document.querySelectorAll('.wizard-step').forEach((step, i) => {
            step.classList.remove('active', 'completed');
            const stepNum = i + 1;
            if (stepNum === currentStep) step.classList.add('active');
            else if (stepNum < currentStep) step.classList.add('completed');
        });

        document.getElementById('prevBtn').style.display = currentStep > 1 ? 'block' : 'none';
        document.getElementById('nextBtn').style.display = currentStep < totalSteps ? 'block' : 'none';
        document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'block' : 'none';
    }
</script>
@endsection
