# 🎨 Customization Guide

Panduan untuk customize BarberShop Booking System sesuai kebutuhan bisnis Anda.

## 🏪 Customize Brand & Name

### 1. Ubah Nama Aplikasi
File: `.env`
```env
APP_NAME="Nama Barbershop Anda"
```

### 2. Ubah Logo & Brand
File: `resources/views/layouts/app.blade.php`
```blade
<a href="{{ route('home') }}" class="navbar-brand">
    <i class="bi bi-scissors"></i> Nama Brand Anda
</a>
```

### 3. Ubah Warna (Color Scheme)
File: `resources/views/layouts/app.blade.php` dan component-lain
```css
/* Dari */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Menjadi */
background: linear-gradient(135deg, #YOUR_COLOR_1 0%, #YOUR_COLOR_2 100%);
```

Rekomendasi kombinasi warna:
- **Blue & Teal**: `#0066CC` → `#00B4DB`
- **Red & Orange**: `#FF6B6B` → `#FF9966`
- **Green & Blue**: `#11998E` → `#38EF7D`

## 💰 Customize Pricing & Services

### 1. Tambah Service Baru
1. Login sebagai Admin
2. Pergi ke **Admin Panel** → **Manage Services**
3. Klik **Add Service**
4. Isi nama, deskripsi, harga (dalam Rupiah), durasi

Contoh:
- Potong Biasa: Rp 30.000 | 30 menit
- Potong Modern: Rp 50.000 | 45 menit
- Cukur Kumis: Rp 35.000 | 20 menit
- Paket Lengkap: Rp 75.000 | 60 menit

### 2. Ubah Format Mata Uang
File: `app/Models/Service.php` dan `app/Models/Payment.php`
```php
public function getPriceFormatted()
{
    // Dari
    return 'Rp ' . number_format($this->price, 0, ',', '.');
    
    // Menjadi (jika ingin USD)
    return '$' . number_format($this->price, 2);
}
```

## 👨‍💼 Tambah Barber

### Langkah Admin Panel
1. Login sebagai Admin
2. Pergi ke **Admin Dashboard** → **Manage Barbers**
3. Klik **Add Barber**
4. Isi informasi:
   - Nama
   - Nomor Telepon
   - Bio
   - Pengalaman (tahun)
   - Status (Tersedia/Sedang Melayani/Istirahat)

### Database Insert (Manual)
```sql
INSERT INTO barbers (name, phone, bio, experience_years, status, created_at, updated_at)
VALUES ('Nama Barber', '0812345678', 'Bio singkat', 10, 'available', NOW(), NOW());
```

## ⏰ Customize Jadwal Operasional

File: `app/Http/Controllers/BookingController.php`
```php
private function getAvailableSlots($barber_id, $booking_date)
{
    // Ganti waktu jam 9 dan 17 dengan jam operasional Anda
    $start_hour = 9;   // Jam buka
    $end_hour = 17;    // Jam tutup
    
    // Contoh:
    // $start_hour = 10;  // Buka jam 10 pagi
    // $end_hour = 19;    // Tutup jam 7 malam
}
```

## 🎁 Customize Booking Flow

### 1. Ubah Durasi Slot Default
File: `database/migrations/2026_05_02_000003_create_services_table.php`
```php
// Ganti 30 dengan durasi baru (dalam menit)
$table->integer('duration_minutes')->default(30);
```

### 2. Ubah Minimum Gap antara Booking
File: `app/Http/Controllers/BookingController.php`
```php
private function isTimeSlotBooked($barber_id, $booking_date, $booking_time)
{
    // Ganti 1800 (30 menit) dengan nilai baru dalam detik
    $gap = 1800; // 30 menit
    
    // Contoh:
    // $gap = 900;  // 15 menit
    // $gap = 3600; // 60 menit
}
```

## 📧 Customize Email Notifications

### Setup Email (Optional)
File: `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
```

### Buat Email Notification
```bash
php artisan make:mailable BookingApproved
```

File: `app/Mail/BookingApproved.php`
```php
public function envelope()
{
    return new Envelope(
        subject: 'Booking Anda Telah Disetujui!',
    );
}
```

## 🏪 Customize Admin Dashboard Stats

File: `app/Http/Controllers/AdminDashboardController.php`
```php
public function index()
{
    // Tambah stat baru
    $stats = [
        'total_bookings' => Booking::count(),
        'pending_bookings' => Booking::where('status', 'pending')->count(),
        // Tambah di sini
        'today_bookings' => Booking::whereDate('booking_date', today())->count(),
    ];
}
```

## 🎯 Customize Payment Methods

File: `resources/views/payments/confirmation.blade.php`
```html
<!-- Tambah method pembayaran baru -->
<div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" 
           id="e_wallet" value="e_wallet" required>
    <label class="form-check-label" for="e_wallet">
        <i class="bi bi-wallet2"></i> E-Wallet / GCash
    </label>
</div>
```

File: `app/Http/Controllers/PaymentController.php`
```php
// Handle e_wallet payment
if ($payment_method == 'e_wallet') {
    $instructions = "Kirim ke GCash: 09XX XXXX XXX";
}
```

## 🔔 Customize Notifications

### SMS Notification (Optional)
Install Twilio:
```bash
composer require twilio/sdk
```

File: `app/Http/Controllers/AdminDashboardController.php`
```php
use Twilio\Rest\Client;

public function approveBooking(Booking $booking)
{
    // Send SMS to customer
    $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    $client->messages->create(
        $booking->customer->phone,
        ['from' => env('TWILIO_PHONE_NUMBER'),
         'body' => 'Booking Anda telah disetujui!']
    );
}
```

## 🎨 Customize Views & Templates

### Tambah Custom CSS
File: `resources/css/app.css`
```css
/* Custom styles */
.custom-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.custom-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
```

### Ubah Blade Layout
File: `resources/views/layouts/app.blade.php`
- Edit navbar
- Edit footer
- Edit sidebar
- Add custom sections

## 🚀 Performance Optimization

### 1. Enable Caching
File: `.env`
```env
CACHE_DRIVER=redis
```

### 2. Optimize Database Queries
File: `app/Http/Controllers/AdminDashboardController.php`
```php
// Use eager loading
$bookings = Booking::with(['customer', 'barber', 'service', 'payment'])->latest()->take(10)->get();
```

### 3. Minify CSS/JS
```bash
npm run build
```

## 🔒 Security Customization

### 1. Enable HTTPS
File: `app/Providers/AppServiceProvider.php`
```php
public function boot()
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

### 2. Custom Rate Limiting
File: `app/Http/Middleware/...`
```php
protected $routeMiddleware = [
    'throttle' => 'throttle:60,1',  // 60 requests per minute
];
```

## 📊 Add Custom Reports

File: `app/Http/Controllers/ReportController.php` (New)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;

class ReportController extends Controller
{
    public function revenue()
    {
        $revenue = Payment::where('status', 'paid')
                          ->sum('amount');
        return view('reports.revenue', compact('revenue'));
    }
    
    public function barberPerformance()
    {
        $barbers = Barber::withCount('bookings')->get();
        return view('reports.barber-performance', compact('barbers'));
    }
}
```

## 🌍 Multi-Language Support

### 1. Buat Language Files
```bash
mkdir -p resources/lang/id
mkdir -p resources/lang/en
```

File: `resources/lang/id/messages.php`
```php
return [
    'booking_title' => 'Pemesanan Barbershop',
    'book_now' => 'Pesan Sekarang',
];
```

### 2. Use in Views
```blade
{{ __('messages.booking_title') }}
```

## 💾 Database Backup

### Automatic Backup
```bash
php artisan backup:run
```

### Manual Backup
```bash
php artisan tinker
>>> Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
```

## 🧪 Testing

### Create Tests
```bash
php artisan make:test BookingTest
```

### Run Tests
```bash
php artisan test
```

---

**Untuk pertanyaan, hubungi support atau check dokumentasi lengkap di DOCUMENTATION.md**
