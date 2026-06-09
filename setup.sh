#!/bin/bash

echo "================================"
echo "Barbershop Booking System Setup"
echo "================================"
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "📋 Membuat file .env..."
    cp .env.example .env
else
    echo "✓ File .env sudah ada"
fi

echo ""
echo "📦 Install dependencies..."
composer install
npm install

echo ""
echo "🔑 Generate application key..."
php artisan key:generate

echo ""
echo "🗄️ Setup database..."
php artisan migrate:fresh --seed

echo ""
echo "🔨 Build assets..."
npm run build

echo ""
echo "================================"
echo "✅ Setup Selesai!"
echo "================================"
echo ""
echo "📋 Akun Default:"
echo "  Admin:"
echo "    Email: admin@barbershop.com"
echo "    Password: password123"
echo ""
echo "  Customer 1:"
echo "    Email: john@example.com"
echo "    Password: password123"
echo ""
echo "  Customer 2:"
echo "    Email: jane@example.com"
echo "    Password: password123"
echo ""
echo "🚀 Jalankan server dengan:"
echo "  php artisan serve"
echo ""
echo "Server akan berjalan di: http://localhost:8000"
echo ""
