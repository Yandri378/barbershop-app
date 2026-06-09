# Barbershop Booking System

Website booking barbershop online yang lengkap dengan fitur customer dan admin dashboard.

## Fitur Utama

### Fitur Customer
- ✅ Registrasi dan Login
- ✅ Lihat daftar tukang cukur dan layanan
- ✅ Cek ketersediaan tukang cukur (available/busy/break)
- ✅ Booking dengan pilihan:
  - Pilih layanan (potong rambut, cukur kumis, dll)
  - Pilih tukang cukur
  - Pilih tanggal dan jam
- ✅ Lihat status booking (pending/approved/rejected/completed)
- ✅ Pembayaran dengan metode:
  - Transfer Bank
  - Tunai (saat kunjungan)
- ✅ Dashboard dengan statistik booking
- ✅ Batalkan booking

### Fitur Admin
- ✅ Dashboard dengan statistik lengkap
- ✅ Kelola Booking:
  - Lihat semua booking
  - Setujui/Tolak booking
  - Tandai booking selesai
  - Filter dan cari booking
- ✅ Kelola Tukang Cukur:
  - Tambah/Edit/Hapus tukang cukur
  - Atur status (available/busy/break)
- ✅ Kelola Layanan:
  - Tambah/Edit/Hapus layanan
  - Atur harga dan durasi
- ✅ Kelola Pembayaran:
  - Lihat semua pembayaran
  - Konfirmasi pembayaran
  - Tandai pembayaran gagal

## Instalasi & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd barbershop-app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database
```bash
# Jalankan migrations
php artisan migrate

# Jalankan seeders (untuk data sample)
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## Akun Default (Dari Seeder)

### Admin
- Email: `admin@barbershop.com`
- Password: `password123`

### Customer 1
- Email: `john@example.com`
- Password: `password123`

### Customer 2
- Email: `jane@example.com`
- Password: `password123`

## Struktur Database

### Users Table
- id, name, email, password, role (admin/customer), timestamps

### Barbers Table
- id, name, phone, bio, photo, status (available/busy/break), experience_years, timestamps

### Services Table
- id, name, description, price, duration_minutes, timestamps

### Bookings Table
- id, customer_id, barber_id, service_id, booking_date
- status (pending/approved/rejected/completed/cancelled)
- notes, timestamps

### Payments Table
- id, booking_id, amount, status (pending/paid/failed)
- payment_method (transfer/cash), transaction_id, notes, timestamps

## Routes

### Public Routes
- `GET /` - Home
- `GET /login` - Login page
- `POST /login` - Process login
- `GET /register` - Register page
- `POST /register` - Process registration

### Customer Routes (Protected)
- `GET /customer/dashboard` - Dashboard customer
- `GET /customer/bookings/create` - Form booking
- `POST /customer/bookings` - Proses booking
- `GET /customer/bookings/{booking}` - Detail booking
- `POST /customer/bookings/{booking}/cancel` - Batalkan booking
- `GET /customer/bookings/slots/available` - AJAX get available slots
- `GET /customer/payments/{booking}` - Info pembayaran
- `GET /customer/payments/{booking}/confirmation` - Form pembayaran
- `POST /customer/payments/{booking}/submit` - Proses pembayaran

### Admin Routes (Protected)
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/bookings` - Kelola booking
- `GET /admin/bookings/{booking}` - Detail booking
- `POST /admin/bookings/{booking}/approve` - Setujui booking
- `POST /admin/bookings/{booking}/reject` - Tolak booking
- `POST /admin/bookings/{booking}/complete` - Tandai selesai
- `GET /admin/barbers` - Kelola tukang cukur
- `GET /admin/barbers/create` - Form tambah
- `POST /admin/barbers` - Proses tambah
- `GET /admin/barbers/{barber}/edit` - Form edit
- `PUT /admin/barbers/{barber}` - Proses edit
- `DELETE /admin/barbers/{barber}` - Hapus
- `GET /admin/services` - Kelola layanan
- `GET /admin/services/create` - Form tambah
- `POST /admin/services` - Proses tambah
- `GET /admin/services/{service}/edit` - Form edit
- `PUT /admin/services/{service}` - Proses edit
- `DELETE /admin/services/{service}` - Hapus
- `GET /admin/payments` - Kelola pembayaran
- `POST /admin/payments/{payment}/mark-as-paid` - Konfirmasi bayar
- `POST /admin/payments/{payment}/mark-as-failed` - Tandai gagal

## Teknologi

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates
- **CSS Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons
- **JavaScript**: Vanilla JS + jQuery
- **Build Tool**: Vite

## Fitur Booking

1. **Customer** memilih:
   - Layanan (dengan harga dan durasi)
   - Tukang cukur (dengan status ketersediaan)
   - Tanggal (7 hari ke depan)
   - Jam (slot yang tersedia)

2. **System** cek ketersediaan jam berdasarkan:
   - Booking yang sudah ada untuk tukang cukur itu
   - Durasi layanan yang dipilih
   - Gap 30 menit antar booking

3. **Admin** bisa:
   - Melihat semua booking
   - Setujui/tolak booking
   - Lihat detail booking dan customer

4. **Payment Flow**:
   - Customer pilih metode pembayaran
   - Untuk transfer: customer lihat data rekening admin
   - Admin konfirmasi pembayaran
   - Customer lihat status pembayaran

5. **Status Booking**:
   - `pending` - Menunggu konfirmasi admin
   - `approved` - Sudah disetujui admin
   - `rejected` - Ditolak admin
   - `completed` - Sudah selesai
   - `cancelled` - Dibatalkan customer

## Styling & UI

- Modern gradient colors (purple & blue)
- Responsive design (mobile-friendly)
- Card-based layout
- Interactive forms dengan validasi
- Bootstrap alerts & modals
- Smooth transitions & animations
- Status badges dengan warna berbeda
- Timeline untuk history

## Middleware & Authorization

- `auth` - Login check
- `customer` - Customer role check
- `admin` - Admin role check
- Authorization checks di controller

## Validasi

- Email unique untuk registration
- Validasi form di server side
- Validasi tanggal & jam booking
- Cek ketersediaan slot sebelum booking
- CSRF protection di semua form

## Cara Menggunakan

### Sebagai Customer:
1. Register dengan email baru
2. Login dengan email & password
3. Klik "Booking Baru"
4. Ikuti wizard (4 step)
5. Konfirmasi booking
6. Pilih metode pembayaran
7. Tunggu konfirmasi admin

### Sebagai Admin:
1. Login dengan akun admin
2. Lihat dashboard (statistik & summary)
3. Kelola booking: approve/reject/complete
4. Kelola tukang cukur: tambah/edit/hapus
5. Kelola layanan: tambah/edit/hapus
6. Kelola pembayaran: konfirmasi/reject

## Customization

### Mengubah Data Rekening Bank
Edit file: `resources/views/payments/confirmation.blade.php`

Cari section "Petunjuk Transfer" dan update dengan data rekening Anda.

### Mengubah Jam Operasional
Edit method `getAvailableSlots` di `BookingController.php`

Ubah jam start dan end sesuai kebutuhan.

### Mengubah Gap Antar Booking
Edit method `isTimeSlotBooked` di `BookingController.php`

Ubah nilai `1800` (30 menit) ke durasi yang diinginkan.

## Tips & Trik

1. **Testing Payment**: Gunakan metode cash untuk testing tanpa transfer
2. **Tambah Data**: Gunakan seeder atau admin panel
3. **Hapus Data**: Bisa langsung di database atau via admin panel
4. **Export Data**: Database bisa di-export untuk backup

## Support & Contact

Untuk pertanyaan atau bantuan, silakan hubungi admin barbershop.

---

**Happy Booking! 💇‍♂️**
