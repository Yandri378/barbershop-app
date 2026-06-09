@extends('layouts.app')

@section('title', 'Home - Barbershop Elite')

@section('extra-styles')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: #d4af37;
        padding: 180px 0 120px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(30px); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        animation: fadeInDown 0.8s ease;
    }

    .hero h1 {
        font-size: 4rem;
        margin-bottom: 20px;
        font-weight: 900;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        letter-spacing: 2px;
    }

    .hero .subtitle {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #f0f0f0;
        opacity: 0.9;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 40px;
        color: rgba(240, 240, 240, 0.8);
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 50px;
        animation: fadeInUp 0.8s ease 0.3s both;
    }

    .hero-buttons .btn {
        padding: 16px 40px;
        font-size: 1.1rem;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .hero-buttons .btn-light {
        background: #d4af37;
        color: #1a1a1a;
        border: none;
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
    }

    .hero-buttons .btn-light:hover {
        background: #ffd700;
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.5);
    }

    .hero-buttons .btn-outline-light {
        border: 2px solid #d4af37;
        color: #d4af37;
        background: transparent;
    }

    .hero-buttons .btn-outline-light:hover {
        background: #d4af37;
        color: #1a1a1a;
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.5);
    }

    /* Features Section */
    .features {
        padding: 120px 0;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
    }

    .features h2 {
        font-size: 3rem;
        color: #d4af37;
        margin-bottom: 20px;
        font-weight: 900;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    .features-description {
        font-size: 1.1rem;
        color: #bbb;
        margin-bottom: 60px;
        text-align: center;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
        padding: 40px 30px;
        border-radius: 15px;
        text-align: center;
        border-left: 4px solid #d4af37;
        transition: all 0.4s ease;
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.15);
        animation: fadeInUp 0.6s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        border-left-color: #ffd700;
        background: linear-gradient(135deg, #3a3a3a 0%, #2d2d2d 100%);
    }

    .feature-card i {
        font-size: 3.5rem;
        color: #d4af37;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .feature-card:hover i {
        transform: scale(1.2) rotate(10deg);
        color: #ffd700;
    }

    .feature-card h3 {
        font-size: 1.4rem;
        color: #d4af37;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .feature-card p {
        color: #aaa;
        line-height: 1.6;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #d4af37 0%, #c19a2a 100%);
        padding: 80px 0;
        text-align: center;
        color: #1a1a1a;
        margin: 80px 0;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(212, 175, 55, 0.4);
        animation: fadeInUp 0.8s ease;
    }

    .cta-section h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        font-weight: 900;
    }

    .cta-section p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        opacity: 0.95;
    }

    .cta-section .btn {
        padding: 14px 40px;
        font-size: 1rem;
        border-radius: 10px;
        font-weight: bold;
        background: #1a1a1a;
        color: #d4af37;
        border: none;
        transition: all 0.3s ease;
    }

    .cta-section .btn:hover {
        background: #2d2d2d;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    /* Testimonials */
    .testimonials {
        padding: 120px 0;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
    }

    .testimonials h2 {
        font-size: 3rem;
        color: #d4af37;
        margin-bottom: 60px;
        font-weight: 900;
        text-align: center;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
        padding: 30px;
        border-radius: 15px;
        border-top: 3px solid #d4af37;
        transition: all 0.4s ease;
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.15);
        animation: fadeInUp 0.6s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
    }

    .testimonial-stars {
        color: #d4af37;
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .testimonial-text {
        color: #aaa;
        font-style: italic;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .testimonial-author {
        color: #d4af37;
        font-weight: bold;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .features h2, .testimonials h2 {
            font-size: 2rem;
        }

        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }

        .hero-buttons .btn {
            width: 100%;
            max-width: 300px;
        }
    }

    .hero {
        min-height: calc(100vh - 74px);
        display: grid;
        align-items: center;
        padding: 90px 0 70px;
        text-align: left;
        background:
            linear-gradient(110deg, rgba(10, 12, 16, 0.94) 0%, rgba(14, 16, 22, 0.78) 48%, rgba(10, 12, 16, 0.94) 100%),
            repeating-linear-gradient(135deg, rgba(214, 52, 71, 0.16) 0 18px, rgba(247, 239, 225, 0.06) 18px 36px, rgba(31, 138, 192, 0.16) 36px 54px);
        background-size: auto, 240px 240px;
        animation: barberStripe 18s linear infinite;
    }

    .hero::before,
    .hero::after {
        display: none;
    }

    .hero-shell {
        width: min(1180px, calc(100% - 32px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(340px, 520px);
        gap: clamp(28px, 5vw, 72px);
        align-items: center;
    }

    .hero-content {
        animation: fadeInLeft 0.8s ease both;
    }

    .hero h1 {
        font-size: clamp(3rem, 7vw, 6.4rem);
        line-height: 0.94;
        letter-spacing: 0;
        margin-bottom: 24px;
    }

    .hero .subtitle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border-radius: 999px;
        border: 1px solid rgba(212, 175, 55, 0.34);
        background: rgba(17, 19, 24, 0.58);
        color: #f7d779;
        font-size: 0.95rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .hero p:not(.subtitle) {
        max-width: 560px;
        font-size: 1.15rem;
        color: rgba(247, 239, 225, 0.78);
    }

    .hero-buttons {
        justify-content: flex-start;
        margin-top: 36px;
    }

    .hero-stage {
        min-height: 520px;
        position: relative;
        border-radius: 8px;
        border: 1px solid rgba(212, 175, 55, 0.28);
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent 42%),
            radial-gradient(circle at 50% 18%, rgba(212, 175, 55, 0.16), transparent 32%),
            linear-gradient(145deg, rgba(39, 42, 49, 0.92), rgba(14, 16, 22, 0.92));
        box-shadow: 0 28px 80px rgba(0, 0, 0, 0.42);
        overflow: hidden;
        animation: fadeInUp 0.8s ease 0.12s both;
    }

    .hero-stage::before {
        content: '';
        position: absolute;
        inset: auto 0 0;
        height: 34%;
        background:
            linear-gradient(90deg, rgba(212, 175, 55, 0.16), transparent 22%, transparent 78%, rgba(31, 138, 192, 0.12)),
            repeating-linear-gradient(90deg, rgba(247, 239, 225, 0.08) 0 1px, transparent 1px 44px);
    }

    .shop-mirror {
        position: absolute;
        top: 42px;
        left: 50%;
        width: 58%;
        height: 230px;
        transform: translateX(-50%);
        border: 10px solid rgba(212, 175, 55, 0.36);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, 0.16), rgba(255, 255, 255, 0.02)),
            linear-gradient(135deg, rgba(31, 138, 192, 0.18), rgba(214, 52, 71, 0.1));
        box-shadow: inset 0 0 40px rgba(255, 255, 255, 0.12), 0 22px 46px rgba(0, 0, 0, 0.3);
    }

    .shop-mirror::after {
        content: '';
        position: absolute;
        inset: 18px auto auto 28px;
        width: 42%;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(-25deg);
        box-shadow: 34px 54px 0 rgba(255, 255, 255, 0.18);
    }

    .shop-light {
        position: absolute;
        top: 20px;
        left: 50%;
        width: 90px;
        height: 18px;
        transform: translateX(-50%);
        border-radius: 999px;
        background: #ffdf76;
        box-shadow: 0 0 28px rgba(255, 223, 118, 0.55), 0 70px 120px rgba(255, 223, 118, 0.24);
        animation: lightPulse 3.8s ease-in-out infinite;
    }

    .shop-pole {
        position: absolute;
        top: 86px;
        right: 48px;
        width: 58px;
        height: 238px;
        border-radius: 32px;
        border: 2px solid rgba(247, 239, 225, 0.5);
        background: repeating-linear-gradient(135deg, var(--barber-red) 0 16px, var(--barber-cream) 16px 32px, var(--barber-blue) 32px 48px);
        background-size: 100% 150px;
        box-shadow: inset 0 0 16px rgba(255, 255, 255, 0.24), 0 20px 44px rgba(0, 0, 0, 0.35);
        animation: poleRoll 3s linear infinite;
    }

    .shop-chair {
        position: absolute;
        left: 50%;
        bottom: 74px;
        width: 230px;
        height: 168px;
        transform: translateX(-50%);
        animation: chairFloat 4.8s ease-in-out infinite;
    }

    .chair-back {
        position: absolute;
        left: 44px;
        top: 0;
        width: 142px;
        height: 110px;
        border-radius: 22px 22px 8px 8px;
        background: linear-gradient(135deg, #2f333d, #111318);
        border: 1px solid rgba(212, 175, 55, 0.32);
    }

    .chair-seat {
        position: absolute;
        left: 18px;
        top: 86px;
        width: 194px;
        height: 58px;
        border-radius: 18px 18px 12px 12px;
        background: linear-gradient(135deg, #3a3f49, #151820);
        border: 1px solid rgba(212, 175, 55, 0.32);
    }

    .chair-base {
        position: absolute;
        left: 104px;
        top: 138px;
        width: 22px;
        height: 58px;
        background: linear-gradient(180deg, #d4af37, #765d1d);
        box-shadow: 0 40px 0 18px rgba(17, 19, 24, 0.9);
    }

    .shop-tools {
        position: absolute;
        left: 42px;
        top: 126px;
        display: grid;
        gap: 20px;
        color: rgba(212, 175, 55, 0.65);
        font-size: 2rem;
    }

    .shop-tools i {
        animation: toolFloat 7s ease-in-out infinite;
    }

    .shop-tools i:nth-child(2) {
        color: rgba(31, 138, 192, 0.62);
        animation-delay: -2s;
    }

    @keyframes lightPulse {
        0%, 100% { opacity: 0.8; filter: brightness(1); }
        50% { opacity: 1; filter: brightness(1.22); }
    }

    @keyframes chairFloat {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-8px); }
    }

    @media (max-width: 992px) {
        .hero-shell {
            grid-template-columns: 1fr;
        }

        .hero-stage {
            min-height: 420px;
        }
    }

    @media (max-width: 768px) {
        .hero {
            min-height: auto;
            text-align: center;
            padding: 54px 0 44px;
        }

        .hero-buttons {
            justify-content: center;
        }

        .hero-stage {
            min-height: 360px;
        }

        .shop-pole {
            right: 26px;
            transform: scale(0.82);
            transform-origin: top right;
        }

        .shop-tools {
            left: 26px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="hero-shell">
        <div class="hero-content">
            <p class="subtitle"><i class="bi bi-stars"></i> Pengalaman Potong Rambut Premium</p>
            <h1><i class="bi bi-scissors"></i> Barbershop Elite</h1>
            <p>Reservasi mudah, tukang cukur profesional, dan suasana shop yang siap membuat Anda tampil lebih segar.</p>
            <div class="hero-buttons">
                @auth
                    @if (Auth::user()->isCustomer())
                        <a href="{{ route('customer.bookings.create') }}" class="btn btn-light">
                            <i class="bi bi-calendar-plus"></i> Booking Sekarang
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-light">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>

        <div class="hero-stage" aria-hidden="true">
            <span class="shop-light"></span>
            <span class="shop-mirror"></span>
            <span class="shop-pole"></span>
            <span class="shop-chair">
                <span class="chair-back"></span>
                <span class="chair-seat"></span>
                <span class="chair-base"></span>
            </span>
            <span class="shop-tools">
                <i class="bi bi-scissors"></i>
                <i class="bi bi-list"></i>
            </span>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features">
    <div class="container">
        <h2>Mengapa Memilih Kami?</h2>
        <p class="features-description">Layanan terbaik dengan standar internasional</p>
        
        <div class="feature-grid">
            <div class="feature-card">
                <i class="bi bi-calendar-check"></i>
                <h3>Booking Mudah</h3>
                <p>Reservasi online dalam hitungan detik. Pilih tukang cukur, tanggal, dan jam yang Anda inginkan.</p>
            </div>
            
            <div class="feature-card">
                <i class="bi bi-person-check"></i>
                <h3>Tukang Cukur Profesional</h3>
                <p>Tim berpengalaman dengan sertifikasi internasional siap memberikan layanan terbaik.</p>
            </div>
            
            <div class="feature-card">
                <i class="bi bi-star"></i>
                <h3>Rating & Review</h3>
                <p>Baca review pelanggan dan lihat rating untuk memilih tukang cukur terbaik sesuai preferensi Anda.</p>
            </div>
            
            <div class="feature-card">
                <i class="bi bi-clock"></i>
                <h3>Hemat Waktu</h3>
                <p>Tidak ada antrian. Datang tepat waktu sesuai jadwal booking Anda.</p>
            </div>
            
            <div class="feature-card">
                <i class="bi bi-cash-coin"></i>
                <h3>Harga Terjangkau</h3>
                <p>Berbagai pilihan layanan dengan harga yang kompetitif dan transparan.</p>
            </div>
            
            <div class="feature-card">
                <i class="bi bi-shield-check"></i>
                <h3>Aman & Higienis</h3>
                <p>Standar kebersihan internasional dan peralatan steril untuk kenyamanan Anda.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="container">
    <div class="cta-section">
        <h2>Siap Tampil Maksimal?</h2>
        <p>Dapatkan potongan rambut impian Anda dengan tukang cukur profesional kami</p>
        @auth
            @if (Auth::user()->isCustomer())
                <a href="{{ route('customer.bookings.create') }}" class="btn">
                    <i class="bi bi-calendar-plus"></i> Booking Sekarang
                </a>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn">
                <i class="bi bi-person-plus"></i> Daftar & Booking
            </a>
        @endauth
    </div>
</div>

<!-- Testimonials -->
<div class="testimonials">
    <div class="container">
        <h2>Testimoni Pelanggan</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"Layanan luar biasa! Tukang cukurnya sangat profesional dan hasilnya sempurna. Saya pasti akan kembali lagi."</p>
                <p class="testimonial-author">- Rinto Wijaya</p>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"Proses booking online sangat mudah dan tidak ada antrian. Waktu saya sangat berharga dan mereka menghargainya."</p>
                <p class="testimonial-author">- Bambang Suryanto</p>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"Tempat yang bersih, harga bersahabat, dan hasil yang memuaskan. Rekomendasi terbaik untuk teman dan keluarga."</p>
                <p class="testimonial-author">- Irfan Maulana</p>
            </div>
        </div>
    </div>
</div>
@endsection
