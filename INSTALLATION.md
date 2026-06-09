# 🚀 Installation Guide - BarberShop Booking System

Panduan lengkap untuk instalasi BarberShop Booking System pada berbagai sistem operasi.

## ✅ Requirements

- **PHP**: 8.2 atau lebih tinggi
- **Composer**: Latest version
- **Node.js**: v16 atau lebih tinggi
- **npm**: v8 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Git**: Latest version

## 🖥️ Install pada Windows

### Step 1: Install Prerequisites
1. Download dan install [PHP 8.2](https://windows.php.net/download/)
2. Download dan install [MySQL 8.0](https://dev.mysql.com/downloads/mysql/)
3. Download dan install [Composer](https://getcomposer.org/download/)
4. Download dan install [Node.js](https://nodejs.org/)
5. Download dan install [Git](https://git-scm.com/download/win)

### Step 2: Clone Repository
```bash
git clone <repository-url>
cd barbershop-app
```

### Step 3: Setup Environment
```bash
# Copy .env file
copy .env.example .env

# Generate Application Key
php artisan key:generate
```

### Step 4: Update Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=  # Masukkan password MySQL Anda jika ada
```

### Step 5: Install Dependencies
```bash
composer install
npm install
```

### Step 6: Create Database
```bash
# Buka MySQL Command Line atau phpMyAdmin
# Buat database baru
CREATE DATABASE barbershop;
```

### Step 7: Run Migrations & Seeding
```bash
php artisan migrate:fresh --seed
```

### Step 8: Build Assets
```bash
npm run build
```

### Step 9: Start Development Server
```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## 🐧 Install pada Linux (Ubuntu/Debian)

### Step 1: Update System
```bash
sudo apt update
sudo apt upgrade -y
```

### Step 2: Install PHP & Extensions
```bash
sudo apt install php8.2 php8.2-mysql php8.2-xml php8.2-mbstring \
                 php8.2-bcmath php8.2-curl php8.2-zip -y
```

### Step 3: Install MySQL
```bash
sudo apt install mysql-server -y
```

### Step 4: Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Step 5: Install Node.js & npm
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

### Step 6: Clone Repository
```bash
git clone <repository-url>
cd barbershop-app
```

### Step 7: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 8: Update Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=  # Masukkan password MySQL Anda
```

### Step 9: Create Database
```bash
sudo mysql -u root -p
```

Di MySQL prompt:
```sql
CREATE DATABASE barbershop;
EXIT;
```

### Step 10: Install Dependencies
```bash
composer install
npm install
```

### Step 11: Run Migrations
```bash
php artisan migrate:fresh --seed
```

### Step 12: Build Assets
```bash
npm run build
```

### Step 13: Start Server
```bash
php artisan serve
```

---

## 🍎 Install pada macOS

### Step 1: Install Homebrew (jika belum)
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Step 2: Install PHP
```bash
brew install php@8.2
brew link php@8.2
```

### Step 3: Install MySQL
```bash
brew install mysql
brew services start mysql
```

### Step 4: Install Composer
```bash
brew install composer
```

### Step 5: Install Node.js
```bash
brew install node
```

### Step 6: Clone Repository
```bash
git clone <repository-url>
cd barbershop-app
```

### Step 7: Setup (sama seperti Linux)
```bash
cp .env.example .env
php artisan key:generate
```

### Step 8: Update `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=
```

### Step 9: Create Database
```bash
mysql -u root
```

Di MySQL:
```sql
CREATE DATABASE barbershop;
EXIT;
```

### Step 10: Dependencies & Migration
```bash
composer install
npm install
php artisan migrate:fresh --seed
npm run build
```

### Step 11: Start Server
```bash
php artisan serve
```

---

## 🐳 Docker Installation (Optional)

### Step 1: Install Docker
- [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Step 2: Create docker-compose.yml
```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: barbershop
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8000:8000"
    environment:
      DB_HOST: mysql
      DB_PASSWORD: root
    depends_on:
      - mysql
    volumes:
      - .:/app

volumes:
  mysql_data:
```

### Step 3: Build & Run
```bash
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 🔧 Troubleshooting

### Error: "database connection refused"
**Solusi:**
```bash
# Check MySQL running
sudo systemctl status mysql

# Restart MySQL
sudo systemctl restart mysql

# Or verify credentials in .env
```

### Error: "SQLSTATE[HY000]: General error"
**Solusi:**
```bash
# Clear cache
php artisan cache:clear

# Migrate again
php artisan migrate:fresh --seed
```

### Error: "Class 'PDO' not found"
**Solusi:**
```bash
# Windows
# Uncomment di php.ini: extension=pdo_mysql

# Linux/Mac
sudo apt install php8.2-mysql  # Linux
brew install php-pdo-mysql     # Mac
```

### Error: "npm install fails"
**Solusi:**
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules
rm -rf node_modules

# Reinstall
npm install
```

### Assets Not Loading (404)
**Solusi:**
```bash
# Rebuild assets
npm run build

# Or in development
npm run dev
```

### Permission Denied Error (Linux)
**Solusi:**
```bash
# Give permissions to storage and bootstrap
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

---

## ✅ Verification

Setelah instalasi selesai, verify dengan:

### 1. Check PHP Version
```bash
php -v
```
Output harus: `PHP 8.2.x` atau lebih tinggi

### 2. Check Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo()
```
Jika berhasil, tidak ada error

### 3. Check Routes
```bash
php artisan route:list
```

### 4. Access Application
Buka browser: `http://localhost:8000`

Anda seharusnya melihat halaman welcome BarberShop

### 5. Test Login
- Admin: `admin@barbershop.com` / `password123`
- Customer: `john@example.com` / `password123`

---

## 🚀 Production Deployment

### Deploy ke Server (Recommended: Hosting dengan cPanel/Plesk)

#### Step 1: Upload Files
Gunakan FTP atau Git:
```bash
git clone <repository-url> public_html/barbershop
```

#### Step 2: Update .env
```env
APP_ENV=production
APP_DEBUG=false
DB_HOST=localhost
DB_DATABASE=barbershop_prod
DB_USERNAME=barbershop_user
DB_PASSWORD=strong_password_here
```

#### Step 3: Run on Server
```bash
cd public_html/barbershop
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

#### Step 4: Set Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Step 5: Setup HTTPS (SSL)
- Use cPanel AutoSSL
- Or Let's Encrypt:
  ```bash
  sudo apt install certbot python3-certbot-apache
  sudo certbot --apache -d yourdomain.com
  ```

---

## 📝 Important Notes

1. **Always use `.env` for sensitive data** - Never commit `.env` to git
2. **Keep dependencies updated** - Regularly run `composer update` dan `npm update`
3. **Backup database regularly** - Automated backups recommended
4. **Monitor logs** - Check `storage/logs/laravel.log` for errors
5. **Use strong passwords** - For database dan admin account

---

## 🆘 Need Help?

1. Check [Laravel Documentation](https://laravel.com/docs)
2. See [MySQL Documentation](https://dev.mysql.com/doc/)
3. Review DOCUMENTATION.md in project
4. Contact support or create GitHub issue

---

**Happy Coding! 🎉**
