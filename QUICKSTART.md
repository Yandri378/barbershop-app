# ⚡ Quick Start Guide

Mulai dalam 5 menit! Panduan cepat untuk setup dan menjalankan BarberShop Booking System.

## 📦 Prerequisites Check

Pastikan Anda sudah install:
- [ ] PHP 8.2+ (`php -v`)
- [ ] Composer (`composer --version`)
- [ ] MySQL/MariaDB running
- [ ] Node.js & npm (`node -v`, `npm -v`)
- [ ] Git (`git --version`)

## 🚀 5-Minute Setup

### Option 1: Automated Setup (Recommended)

#### Windows (PowerShell/CMD)
```powershell
# Clone repository
git clone <repository-url>
cd barbershop-app

# Run setup script (if you have bash/WSL)
bash setup.sh

# If no bash, run commands manually (see Option 2)
```

#### Linux/macOS (Terminal)
```bash
# Clone repository
git clone <repository-url>
cd barbershop-app

# Run setup
chmod +x setup.sh
./setup.sh
```

Done! Server runs at `http://localhost:8000`

---

### Option 2: Manual Setup

#### Step 1: Clone & Enter Directory
```bash
git clone <repository-url>
cd barbershop-app
```

#### Step 2: Copy Environment File
```bash
# Windows
copy .env.example .env

# Linux/macOS
cp .env.example .env
```

#### Step 3: Generate Key
```bash
php artisan key:generate
```

#### Step 4: Update `.env` Database Config
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=
```

#### Step 5: Install Dependencies
```bash
composer install
npm install
```

#### Step 6: Create Database
```bash
# MySQL CLI
mysql -u root -p
CREATE DATABASE barbershop;
EXIT;

# Or use phpMyAdmin to create database
```

#### Step 7: Run Migrations & Seeding
```bash
php artisan migrate:fresh --seed
```

#### Step 8: Build Assets
```bash
npm run build
```

#### Step 9: Start Server
```bash
php artisan serve
```

✅ Done! Visit `http://localhost:8000`

---

## 👤 Login Credentials

After successful setup, use these credentials:

### Admin Account
```
Email: admin@barbershop.com
Password: password123
```

### Customer Account 1
```
Email: john@example.com
Password: password123
```

### Customer Account 2
```
Email: jane@example.com
Password: password123
```

---

## 🎯 What to Try First

### 1. **Admin Login & Explore**
1. Go to `http://localhost:8000`
2. Click **Login** → Select **Admin**
3. Enter: `admin@barbershop.com` / `password123`
4. Explore admin dashboard:
   - View statistics
   - Check pending bookings
   - Manage barbers & services
   - View payments

### 2. **Customer Booking**
1. Click **Logout**
2. Go to home page
3. Click **Register** or **Login** as customer
4. If registering: Fill name, email, password
5. If logging in: `john@example.com` / `password123`
6. Click **Booking Baru** (New Booking)
7. Follow 4-step wizard:
   - Step 1: Select service
   - Step 2: Select barber
   - Step 3: Select date & time
   - Step 4: Confirm & submit
8. See booking in customer dashboard

### 3. **Admin Approval**
1. Login as admin
2. Go to **Manage Bookings**
3. Find the booking you just created
4. Click **View Detail**
5. Click **Approve**
6. Booking status changes to **Approved**

### 4. **Customer Payment**
1. Login as customer
2. Go to customer dashboard
3. Click **Pay** on approved booking
4. Select payment method (Transfer or Cash)
5. Submit payment
6. Go back to admin → **Payments**
7. Admin marks as **Paid**

---

## 📁 Project Structure (Quick Reference)

```
barbershop-app/
├── app/Models/                  # Database models
├── app/Http/Controllers/        # Business logic
├── resources/views/             # HTML templates
├── routes/web.php              # All routes
├── database/migrations/         # Database structure
├── database/seeders/            # Sample data
└── public/                      # Static files
```

---

## 🔧 Common Commands

### Development
```bash
# Start server
php artisan serve

# Build assets (during development)
npm run dev

# Run tests
php artisan test
```

### Database
```bash
# Create tables
php artisan migrate

# Rollback all
php artisan migrate:reset

# Rollback & re-run
php artisan migrate:fresh

# Seed with data
php artisan migrate:fresh --seed
```

### Maintenance
```bash
# Clear cache
php artisan cache:clear

# Clear config cache
php artisan config:cache

# Clear route cache
php artisan route:cache

# Restart tinker
php artisan tinker
```

---

## 🐛 Quick Troubleshooting

### "SQLSTATE[HY000]: General error"
```bash
php artisan migrate:fresh --seed
```

### "Class not found" Error
```bash
composer dump-autoload
```

### Assets not loading (404)
```bash
npm run build
```

### Permission denied (Linux)
```bash
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

### Can't connect to database
1. Check MySQL is running
2. Verify `.env` database credentials
3. Check database exists
4. Run: `php artisan migrate`

### Port 8000 already in use
```bash
# Use different port
php artisan serve --port=8001
```

---

## 📚 Next Steps

After quick start:

1. **Read Documentation**
   - [README.md](README.md) - Project overview
   - [FEATURES.md](FEATURES.md) - All features explained
   - [DOCUMENTATION.md](DOCUMENTATION.md) - Comprehensive guide

2. **Customize for Your Business**
   - See [CUSTOMIZATION.md](CUSTOMIZATION.md)
   - Change brand name, colors, services
   - Add your barbershop info

3. **Deploy to Production**
   - See [INSTALLATION.md](INSTALLATION.md) - Production section
   - Setup SSL/HTTPS
   - Configure email notifications

4. **API Integration**
   - See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
   - For mobile app or external integration

---

## 🆘 Stuck? Get Help

### Check These Files
- `INSTALLATION.md` - Full installation guide
- `DOCUMENTATION.md` - Comprehensive documentation
- `API_DOCUMENTATION.md` - API endpoints

### Debug Mode
```bash
# Check logs
tail -f storage/logs/laravel.log

# Or in Windows
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

### Database Check
```bash
php artisan tinker
>>> User::all();           # Check users
>>> Booking::all();        # Check bookings
>>> Service::all();        # Check services
>>> exit;
```

---

## ✅ Verification Checklist

After setup, verify everything works:

- [ ] Homepage loads (http://localhost:8000)
- [ ] Can register new customer account
- [ ] Can login as admin
- [ ] Admin dashboard shows statistics
- [ ] Can create new booking as customer
- [ ] Available time slots load dynamically
- [ ] Can approve booking as admin
- [ ] Can submit payment as customer
- [ ] Admin can view payment
- [ ] Database seeded with 6 sample bookings

---

## 🎉 Congratulations!

Your BarberShop Booking System is ready! 

**Next:** Start customizing for your barbershop business. See [CUSTOMIZATION.md](CUSTOMIZATION.md).

---

## 📝 Notes

- **Development mode:** Leave `APP_DEBUG=true` in `.env`
- **Production mode:** Set `APP_DEBUG=false` before deploying
- **Database backup:** Make backups regularly
- **Security:** Never commit `.env` to git

---

**Version:** 1.0.0  
**Last Updated:** May 2, 2026  

Happy coding! 🚀
