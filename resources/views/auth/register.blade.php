@extends('layouts.app')

@section('title', 'Daftar')

@section('extra-styles')
<style>
    .navbar,
    .footer {
        display: none !important;
    }

    .main-content {
        padding: 0;
    }

    .register-container {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(360px, 520px) minmax(0, 1fr);
        align-items: stretch;
        overflow: hidden;
    }

    .register-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: clamp(20px, 4vw, 54px);
        background: rgba(10, 12, 16, 0.74);
        backdrop-filter: blur(22px);
        border-right: 1px solid rgba(212, 175, 55, 0.2);
    }

    .register-card {
        width: 100%;
        max-width: 470px;
        padding: clamp(26px, 4vw, 42px);
        border-radius: 8px;
        background: linear-gradient(145deg, rgba(35, 37, 44, 0.96), rgba(15, 17, 23, 0.96));
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--light-text);
        box-shadow: 0 26px 70px rgba(0, 0, 0, 0.46);
        animation: registerCardIn 0.75s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }

    .register-header {
        margin-bottom: 28px;
    }

    .register-header h1 {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--secondary-color);
        font-weight: 900;
        margin-bottom: 8px;
    }

    .register-header h1 i {
        animation: scissorSnip 2.8s ease-in-out infinite;
    }

    .register-header p {
        color: rgba(240, 240, 240, 0.68);
        margin: 0;
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

    .password-strength {
        height: 7px;
        background-color: rgba(247, 239, 225, 0.12);
        border-radius: 999px;
        margin-top: 9px;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
    }

    .password-strength-bar.weak {
        width: 33%;
        background: linear-gradient(90deg, #d63447, #ff7b88);
    }

    .password-strength-bar.medium {
        width: 66%;
        background: linear-gradient(90deg, #d4af37, #ffdf76);
    }

    .password-strength-bar.strong {
        width: 100%;
        background: linear-gradient(90deg, #1f8ac0, #66d09f);
    }

    .btn-register {
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

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 42px rgba(212, 175, 55, 0.36);
        color: #111318;
    }

    .login-link {
        text-align: center;
        color: rgba(240, 240, 240, 0.68);
    }

    .login-link a {
        color: var(--secondary-color);
        font-weight: 800;
        text-decoration: none;
    }

    .login-link a:hover {
        color: #ffdf76;
        text-decoration: underline;
    }

    .register-showcase {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(32px, 7vw, 96px);
        color: var(--barber-cream);
        overflow: hidden;
        isolation: isolate;
    }

    .register-showcase::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(105deg, rgba(12, 14, 18, 0.48), rgba(12, 14, 18, 0.9)),
            repeating-linear-gradient(135deg, rgba(31, 138, 192, 0.18) 0 18px, rgba(247, 239, 225, 0.08) 18px 36px, rgba(214, 52, 71, 0.18) 36px 54px);
        background-size: auto, 220px 220px;
        animation: barberStripe 16s linear infinite reverse;
        z-index: -2;
    }

    .register-showcase::after {
        content: '';
        position: absolute;
        width: 360px;
        height: 360px;
        left: 14%;
        bottom: 12%;
        border: 1px solid rgba(212, 175, 55, 0.28);
        border-radius: 50%;
        box-shadow: inset 0 0 80px rgba(212, 175, 55, 0.1);
        animation: slowSpin 24s linear infinite reverse;
        z-index: -1;
    }

    .register-copy {
        max-width: 650px;
        animation: riseIn 0.7s ease both;
    }

    .register-copy .auth-kicker {
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

    .register-copy h2 {
        font-size: clamp(2.4rem, 5vw, 5rem);
        line-height: 1;
        font-weight: 900;
        margin-bottom: 22px;
        text-shadow: 0 18px 46px rgba(0, 0, 0, 0.44);
    }

    .register-copy p {
        max-width: 560px;
        color: rgba(247, 239, 225, 0.82);
        font-size: 1.08rem;
        line-height: 1.8;
        margin-bottom: 34px;
    }

    .register-steps {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .register-step {
        padding: 16px;
        border-radius: 8px;
        background: rgba(12, 14, 18, 0.58);
        border: 1px solid rgba(247, 239, 225, 0.12);
        backdrop-filter: blur(12px);
        animation: riseIn 0.7s ease both;
    }

    .register-step:nth-child(2) {
        animation-delay: 0.12s;
    }

    .register-step:nth-child(3) {
        animation-delay: 0.24s;
    }

    .register-step i {
        color: var(--secondary-color);
        font-size: 1.45rem;
        margin-bottom: 10px;
    }

    .register-step strong {
        display: block;
        color: #fff;
        margin-bottom: 4px;
    }

    .register-step span {
        display: block;
        color: rgba(247, 239, 225, 0.68);
        font-size: 0.88rem;
    }

    @keyframes registerCardIn {
        from { opacity: 0; transform: translateX(-28px) scale(0.98); }
        to { opacity: 1; transform: translateX(0) scale(1); }
    }

    @keyframes slowSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @media (max-width: 992px) {
        .register-container {
            grid-template-columns: 1fr;
        }

        .register-panel {
            order: 2;
            border-right: 0;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }

        .register-showcase {
            min-height: 40vh;
        }
    }

    @media (max-width: 640px) {
        .register-panel,
        .register-showcase {
            padding: 20px;
        }

        .register-steps {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <section class="register-panel">
        <div class="register-card">
            <div class="register-header">
                <h1><i class="bi bi-scissors"></i> Buat Akun</h1>
                <p>Daftar sebagai customer dan mulai booking layanan favorit.</p>
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

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-icon">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
                    </div>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Buat password yang kuat" required>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="bi bi-person-plus"></i> Daftar
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </form>
        </div>
    </section>

    <section class="register-showcase">
        <div class="register-copy">
            <div class="auth-kicker">
                <i class="bi bi-gem"></i>
                Mulai pengalaman baru
            </div>
            <h2>Booking cepat, hasil lebih rapi.</h2>
            <p>Akun customer memberi Anda akses ke layanan, jadwal barber, pembayaran, dan riwayat booking dalam satu tempat.</p>

            <div class="register-steps">
                <div class="register-step">
                    <i class="bi bi-person-plus"></i>
                    <strong>Daftar</strong>
                    <span>Isi data singkat.</span>
                </div>
                <div class="register-step">
                    <i class="bi bi-calendar-plus"></i>
                    <strong>Pilih jadwal</strong>
                    <span>Tentukan waktu terbaik.</span>
                </div>
                <div class="register-step">
                    <i class="bi bi-stars"></i>
                    <strong>Tampil fresh</strong>
                    <span>Datang tanpa antre panjang.</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('extra-scripts')
<script>
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('strengthBar');
        let strength = 0;

        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[!@#$%^&*]/.test(password)) strength += 1;

        strengthBar.classList.remove('weak', 'medium', 'strong');

        if (strength <= 2) {
            strengthBar.classList.add('weak');
        } else if (strength <= 4) {
            strengthBar.classList.add('medium');
        } else {
            strengthBar.classList.add('strong');
        }
    });
</script>
@endsection
