@extends('layouts.app')

@section('title', 'Login')

@section('extra-styles')
<style>
    .navbar,
    .footer {
        display: none !important;
    }

    .main-content {
        padding: 0;
    }

    .login-container {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(360px, 500px);
        align-items: stretch;
        position: relative;
        overflow: hidden;
    }

    .auth-showcase {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(32px, 7vw, 96px);
        color: var(--barber-cream);
        overflow: hidden;
        isolation: isolate;
    }

    .auth-showcase::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(115deg, rgba(12, 14, 18, 0.88), rgba(12, 14, 18, 0.45)),
            repeating-linear-gradient(125deg, rgba(214, 52, 71, 0.18) 0 18px, rgba(247, 239, 225, 0.08) 18px 36px, rgba(31, 138, 192, 0.18) 36px 54px);
        background-size: auto, 220px 220px;
        animation: barberStripe 16s linear infinite;
        z-index: -2;
    }

    .auth-showcase::after {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        right: 10%;
        top: 18%;
        border: 1px solid rgba(212, 175, 55, 0.28);
        border-radius: 50%;
        box-shadow: inset 0 0 80px rgba(212, 175, 55, 0.1);
        animation: slowSpin 22s linear infinite;
        z-index: -1;
    }

    .auth-brand {
        max-width: 640px;
        animation: riseIn 0.7s ease both;
    }

    .auth-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border: 1px solid rgba(212, 175, 55, 0.36);
        border-radius: 999px;
        background: rgba(17, 19, 24, 0.48);
        color: #f7d779;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .auth-brand h1 {
        font-size: clamp(2.6rem, 6vw, 5.8rem);
        line-height: 0.95;
        font-weight: 900;
        margin-bottom: 22px;
        text-shadow: 0 18px 46px rgba(0, 0, 0, 0.44);
    }

    .auth-brand p {
        max-width: 540px;
        color: rgba(247, 239, 225, 0.82);
        font-size: 1.08rem;
        line-height: 1.8;
        margin-bottom: 34px;
    }

    .shop-highlights {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        max-width: 620px;
    }

    .shop-highlight {
        padding: 16px;
        border-radius: 8px;
        background: rgba(12, 14, 18, 0.58);
        border: 1px solid rgba(247, 239, 225, 0.12);
        backdrop-filter: blur(12px);
        animation: riseIn 0.7s ease both;
    }

    .shop-highlight:nth-child(2) {
        animation-delay: 0.12s;
    }

    .shop-highlight:nth-child(3) {
        animation-delay: 0.24s;
    }

    .shop-highlight i {
        color: var(--secondary-color);
        font-size: 1.45rem;
        margin-bottom: 10px;
    }

    .shop-highlight strong {
        display: block;
        color: #fff;
        margin-bottom: 4px;
    }

    .shop-highlight span {
        display: block;
        color: rgba(247, 239, 225, 0.68);
        font-size: 0.88rem;
    }

    .login-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(20px, 4vw, 54px);
        background: rgba(10, 12, 16, 0.72);
        backdrop-filter: blur(22px);
        border-left: 1px solid rgba(212, 175, 55, 0.2);
    }

    .login-card {
        width: 100%;
        max-width: 460px;
        padding: clamp(26px, 4vw, 42px);
        border-radius: 8px;
        background: linear-gradient(145deg, rgba(35, 37, 44, 0.95), rgba(15, 17, 23, 0.95));
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 26px 70px rgba(0, 0, 0, 0.46);
        color: var(--light-text);
        animation: authCardIn 0.75s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }

    .login-header {
        margin-bottom: 28px;
    }

    .login-header h2 {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--secondary-color);
        font-weight: 900;
        margin-bottom: 8px;
    }

    .login-header h2 i {
        animation: scissorSnip 2.8s ease-in-out infinite;
    }

    .login-header p {
        color: rgba(240, 240, 240, 0.68);
        margin: 0;
    }

    .role-selector {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .role-btn {
        min-height: 58px;
        border: 1px solid rgba(247, 239, 225, 0.16);
        background: rgba(255, 255, 255, 0.04);
        color: rgba(240, 240, 240, 0.8);
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
    }

    .role-btn:hover {
        transform: translateY(-3px);
        border-color: rgba(212, 175, 55, 0.58);
        color: #fff;
    }

    .role-btn.active.customer-active {
        background: linear-gradient(135deg, var(--barber-blue), #68c1ee);
        color: #081018;
        border-color: transparent;
        box-shadow: 0 12px 28px rgba(31, 138, 192, 0.28);
    }

    .role-btn.active.admin-active {
        background: linear-gradient(135deg, var(--barber-red), #ff7b88);
        color: #19070a;
        border-color: transparent;
        box-shadow: 0 12px 28px rgba(214, 52, 71, 0.28);
    }

    .role-info {
        min-height: 126px;
        padding: 18px;
        margin-bottom: 22px;
        border-radius: 8px;
        border: 1px solid rgba(212, 175, 55, 0.24);
        background: rgba(247, 239, 225, 0.05);
        display: grid;
        grid-template-columns: 54px 1fr;
        gap: 14px;
        align-items: center;
        transition: all 0.3s ease;
    }

    .role-info.active-customer {
        border-color: rgba(31, 138, 192, 0.56);
        box-shadow: inset 0 0 36px rgba(31, 138, 192, 0.08);
    }

    .role-info.active-admin {
        border-color: rgba(214, 52, 71, 0.56);
        box-shadow: inset 0 0 36px rgba(214, 52, 71, 0.08);
    }

    .role-info-icon {
        width: 54px;
        height: 54px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        color: var(--secondary-color);
        background: rgba(212, 175, 55, 0.12);
        font-size: 1.55rem;
    }

    .role-info h3 {
        margin: 0 0 5px;
        font-size: 1.1rem;
        font-weight: 900;
        color: #fff;
    }

    .role-info p {
        margin: 0 0 10px;
        color: rgba(240, 240, 240, 0.65);
        font-size: 0.92rem;
    }

    .role-badge {
        display: none;
        width: fit-content;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 800;
        color: #101217;
    }

    .role-badge.customer-badge {
        background: #68c1ee;
    }

    .role-badge.admin-badge {
        background: #ff8d98;
    }

    .role-info.active-customer .customer-badge,
    .role-info.active-admin .admin-badge {
        display: inline-flex;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        color: rgba(240, 240, 240, 0.84);
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary-color);
        z-index: 2;
    }

    .input-icon input {
        padding-left: 42px;
        min-height: 48px;
    }

    .form-check-label {
        color: rgba(240, 240, 240, 0.72);
    }

    .btn-login {
        width: 100%;
        min-height: 50px;
        margin: 12px 0 18px;
        background: linear-gradient(135deg, var(--secondary-color), #ffdf76);
        border: 0;
        color: #111318;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 14px 32px rgba(212, 175, 55, 0.26);
        transition: all 0.25s ease;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 42px rgba(212, 175, 55, 0.36);
    }

    .register-link {
        text-align: center;
        color: rgba(240, 240, 240, 0.68);
    }

    .register-link a {
        color: var(--secondary-color);
        font-weight: 800;
        text-decoration: none;
    }

    .register-link a:hover {
        color: #ffdf76;
        text-decoration: underline;
    }

    @keyframes authCardIn {
        from { opacity: 0; transform: translateX(28px) scale(0.98); }
        to { opacity: 1; transform: translateX(0) scale(1); }
    }

    @keyframes slowSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @media (max-width: 992px) {
        .login-container {
            grid-template-columns: 1fr;
        }

        .auth-showcase {
            min-height: 42vh;
        }

        .login-panel {
            border-left: 0;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }
    }

    @media (max-width: 640px) {
        .auth-showcase {
            padding: 28px 20px;
        }

        .shop-highlights {
            grid-template-columns: 1fr;
        }

        .login-panel {
            padding: 18px;
        }

        .role-info {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .role-info-icon,
        .role-badge {
            margin-inline: auto;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <section class="auth-showcase">
        <div class="auth-brand">
            <div class="auth-kicker">
                <i class="bi bi-stars"></i>
                Booking barbershop premium
            </div>
            <h1>BarberShop Elite</h1>
            <p>Masuk untuk mengatur jadwal potong, memilih tukang cukur favorit, dan memantau pembayaran tanpa antre.</p>

            <div class="shop-highlights">
                <div class="shop-highlight">
                    <i class="bi bi-calendar2-check"></i>
                    <strong>Jadwal rapi</strong>
                    <span>Pilih slot tanpa menunggu.</span>
                </div>
                <div class="shop-highlight">
                    <i class="bi bi-scissors"></i>
                    <strong>Barber ahli</strong>
                    <span>Layanan sesuai gaya Anda.</span>
                </div>
                <div class="shop-highlight">
                    <i class="bi bi-credit-card"></i>
                    <strong>Pembayaran jelas</strong>
                    <span>Status transaksi terlihat.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="login-panel">
        <div class="login-card">
            <div class="login-header">
                <h2>
                    <i class="bi bi-scissors"></i>
                    Masuk Akun
                </h2>
                <p>Pilih akses Anda lalu lanjutkan ke dashboard.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="role-selector">
                    <button type="button" class="btn role-btn active customer-active" id="btnCustomer" data-role="customer">
                        <i class="bi bi-person"></i> Customer
                    </button>
                    <button type="button" class="btn role-btn" id="btnAdmin" data-role="admin">
                        <i class="bi bi-shield-lock"></i> Admin
                    </button>
                </div>

                <div class="role-info active-customer" id="roleInfo">
                    <div class="role-info-icon" id="roleIcon"><i class="bi bi-person"></i></div>
                    <div>
                        <h3 id="roleTitle">Login sebagai Customer</h3>
                        <p id="roleDescription">Akses dashboard customer dan pesan layanan barbershop.</p>
                        <span class="role-badge customer-badge">Login Pelanggan</span>
                        <span class="role-badge admin-badge">Login Administrator</span>
                    </div>
                </div>

                <input type="hidden" name="is_admin" id="isAdmin" value="0">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}"
                               placeholder="Masukkan email Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('extra-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnCustomer = document.getElementById('btnCustomer');
        const btnAdmin = document.getElementById('btnAdmin');
        const isAdminInput = document.getElementById('isAdmin');
        const roleInfo = document.getElementById('roleInfo');
        const roleTitle = document.getElementById('roleTitle');
        const roleDescription = document.getElementById('roleDescription');
        const roleIcon = document.getElementById('roleIcon');

        const roles = {
            customer: {
                title: 'Login sebagai Customer',
                description: 'Akses dashboard customer dan pesan layanan barbershop.',
                icon: '<i class="bi bi-person"></i>'
            },
            admin: {
                title: 'Login sebagai Admin',
                description: 'Kelola barber, layanan, booking, dan pembayaran.',
                icon: '<i class="bi bi-shield-lock"></i>'
            }
        };

        function updateRole(role) {
            if (role === 'customer') {
                btnCustomer.classList.add('active', 'customer-active');
                btnCustomer.classList.remove('admin-active');
                btnAdmin.classList.remove('active', 'admin-active');
                roleInfo.classList.remove('active-admin');
                roleInfo.classList.add('active-customer');
            } else {
                btnAdmin.classList.add('active', 'admin-active');
                btnAdmin.classList.remove('customer-active');
                btnCustomer.classList.remove('active', 'customer-active');
                roleInfo.classList.remove('active-customer');
                roleInfo.classList.add('active-admin');
            }

            roleIcon.innerHTML = roles[role].icon;
            roleTitle.textContent = roles[role].title;
            roleDescription.textContent = roles[role].description;
            isAdminInput.value = role === 'admin' ? '1' : '0';
        }

        btnCustomer.addEventListener('click', function(e) {
            e.preventDefault();
            updateRole('customer');
        });

        btnAdmin.addEventListener('click', function(e) {
            e.preventDefault();
            updateRole('admin');
        });

        updateRole('customer');
    });
</script>
@endsection
