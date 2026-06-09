# 💇‍♂️ BarberShop Booking System

Sistem Pemesanan Barbershop Online Terpadu dengan fitur lengkap untuk customer dan admin. Dibangun dengan Laravel 11 dan Bootstrap 5.

## ✨ Fitur Utama

### Untuk Customer
- ✅ **Registrasi & Login** - Email dan password dengan validasi
- ✅ **Booking Wizard** - 4 langkah (Pilih Layanan → Pilih Barber → Pilih Jadwal → Konfirmasi)
- ✅ **Pilih Barber** - Lihat foto, bio, pengalaman, dan status ketersediaan
- ✅ **Pilih Jadwal** - Calendar dan time-slot otomatis (30 menit per booking)
- ✅ **Dashboard Customer** - Riwayat booking dan statistik
- ✅ **Pembayaran Fleksibel** - Transfer bank atau tunai
- ✅ **Tracking Booking** - Status real-time (pending → approved → completed)
- ✅ **Manajemen Booking** - View, cancel booking

### Untuk Admin
- ✅ **Dashboard Admin** - Statistik dan ringkasan
- ✅ **Manajemen Booking** - Approve, reject, complete booking
- ✅ **Manajemen Barber** - Create, read, update, delete barber
- ✅ **Manajemen Layanan** - Manage services dengan harga dan durasi
- ✅ **Manajemen Pembayaran** - Konfirmasi dan update status pembayaran
- ✅ **Filter & Search** - Cari booking berdasarkan status, customer, dll

## 🛠️ Tech Stack

| Technology | Purpose |
|-----------|---------|
| **Laravel 11** | Web Framework |
| **PHP 8.2+** | Backend Language |
| **MySQL** | Database |
| **Bootstrap 5** | Frontend Framework |
| **Blade** | Templating Engine |
| **Eloquent ORM** | Database ORM |

## 📋 Database Schema

### Tabel: Users
- id, name, email, password, role (admin/customer), timestamps

### Tabel: Barbers
- id, name, phone, bio, photo, status (available/busy/break), experience_years, timestamps

### Tabel: Services
- id, name, description, price, duration_minutes, timestamps

### Tabel: Bookings
- id, customer_id, barber_id, service_id, booking_date, status, notes, timestamps

### Tabel: Payments
- id, booking_id, amount, status, payment_method, transaction_id, notes, timestamps

## 🚀 Quick Start

### Langkah 1: Clone Repository
```bash
git clone <repository-url>
cd barbershop-app
```

### Langkah 2: Setup dengan Script (Recommended)
```bash
chmod +x setup.sh
./setup.sh
```

### Atau Setup Manual

#### Install Dependencies
```bash
composer install
npm install
```

#### Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

#### Database Setup
```bash
php artisan migrate:fresh --seed
```

#### Build Assets
```bash
npm run build
```

#### Jalankan Server
```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

## 👤 Akun Default

### Admin
- Email: `admin@barbershop.com`
- Password: `password123`

### Customer 1
- Email: `john@example.com`
- Password: `password123`

### Customer 2
- Email: `jane@example.com`
- Password: `password123`

## 📁 Project Structure

```
barbershop-app/
├── app/
│   ├── Models/              # Eloquent Models
│   │   ├── User.php
│   │   ├── Barber.php
│   │   ├── Service.php
│   │   ├── Booking.php
│   │   └── Payment.php
│   └── Http/
│       ├── Controllers/     # Business Logic
│       │   ├── AuthController.php
│       │   ├── BookingController.php
│       │   ├── DashboardController.php
│       │   ├── AdminDashboardController.php
│       │   └── PaymentController.php
│       └── Middleware/      # Role-based Access
│           ├── IsAdmin.php
│           └── IsCustomer.php
├── resources/views/         # Blade Templates
│   ├── layouts/app.blade.php
│   ├── auth/
│   ├── customer/
│   ├── admin/
│   ├── bookings/
│   └── payments/
├── routes/
│   ├── web.php             # All Routes
├── database/
│   ├── migrations/         # Database Migrations
│   ├── seeders/            # Sample Data
│   └── factories/
└── public/                 # Static Files
```

## 🔐 Authentication & Authorization

### Middleware
- `IsCustomer` - Hanya customer yang bisa akses
- `IsAdmin` - Hanya admin yang bisa akses

### Login Role
- Customer login → Redirect ke customer dashboard
- Admin login → Redirect ke admin dashboard

## 📱 Routes Overview

### Public Routes
- `GET /` - Home page
- `GET/POST /login` - Customer & Admin login
- `GET/POST /register` - Customer registration

### Customer Routes (prefix: `/customer`)
- `GET /dashboard` - Dashboard
- `GET/POST /bookings` - Booking CRUD
- `GET /bookings/{id}` - Booking detail
- `POST /bookings/{id}/cancel` - Cancel booking
- `GET/POST /payments/{id}` - Payment management

### Admin Routes (prefix: `/admin`)
- `GET /dashboard` - Admin dashboard
- `GET /bookings` - Booking list
- `POST /bookings/{id}/approve` - Approve booking
- `POST /bookings/{id}/reject` - Reject booking
- `POST /bookings/{id}/complete` - Complete booking
- `GET /barbers` - Barber list
- `POST /barbers` - Create barber
- `PUT /barbers/{id}` - Update barber
- `DELETE /barbers/{id}` - Delete barber
- `GET /services` - Service list
- `POST /services` - Create service
- `PUT /services/{id}` - Update service
- `DELETE /services/{id}` - Delete service
- `GET /payments` - Payment list
- `PUT /payments/{id}` - Update payment status

## 🎯 Workflow

### Customer Booking Flow
1. Customer login
2. Klik "Booking Baru"
3. Step 1: Pilih layanan (haircut type & price)
4. Step 2: Pilih barber (lihat foto & pengalaman)
5. Step 3: Pilih tanggal & waktu (dengan availability check)
6. Step 4: Review & submit booking
7. Booking status: **Pending** (menunggu approval admin)
8. Admin approve → Status: **Approved**
9. Customer submit pembayaran
10. Admin confirm pembayaran
11. Booking selesai → Status: **Completed**

### Admin Approval Flow
1. Admin login
2. View pending bookings di dashboard
3. Check booking detail
4. Approve atau Reject
5. Manage payment status (Paid/Failed)
6. Monitor barber availability

## 🔧 API Endpoints

### AJAX Endpoints
- `GET /customer/bookings/slots/available` - Get available time slots
  - Query params: `barber_id`, `booking_date`
  - Returns: JSON array dengan available time slots

## 📊 Booking Status Flow

```
Pending → Approved → Completed
       ↘
        Rejected/Cancelled
```

## 💳 Payment Status

```
Pending → Paid
       ↘ Failed (can retry)
```

## 🎨 Styling

- **Bootstrap 5** - Responsive grid & components
- **Bootstrap Icons** - UI icons
- **Custom CSS** - Gradient backgrounds, animations
- **Color Scheme** - Purple (#667eea) to Violet (#764ba2)

## 📝 Notes

### Time Slot Logic
- Working hours: 09:00 - 17:00
- Slot interval: 30 minutes
- Minimum gap between bookings: 30 minutes
- Prevents overbooking per barber

### Payment Methods
1. **Transfer Bank** - Provide bank details to customer
2. **Cash** - On-site payment at barbershop

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Update .env file
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=
```

### Migration Error
```bash
php artisan migrate:fresh --seed
```

### Assets Not Loading
```bash
npm run build
```

## 📖 Additional Documentation

Lihat file `DOCUMENTATION.md` untuk dokumentasi lengkap termasuk:
- Database schema detail
- Controller methods documentation
- View file descriptions
- Seeder configuration
- Customization guide

## 👨‍💻 Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

## 📄 License

Proprietary. All rights reserved.

## 🤝 Support

Untuk pertanyaan atau bug report, silakan buat issue di repository ini.

---

**Selamat menggunakan BarberShop Booking System! 🎉**
