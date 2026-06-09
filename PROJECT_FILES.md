# 📋 Project Files Summary

Complete file listing dan deskripsi untuk BarberShop Booking System.

## 📚 Documentation Files

| File | Description |
|------|-------------|
| [README.md](README.md) | Project overview, features, tech stack, quick start |
| [QUICKSTART.md](QUICKSTART.md) | 5-minute setup guide |
| [INSTALLATION.md](INSTALLATION.md) | Detailed installation for Windows/Linux/macOS/Docker |
| [DOCUMENTATION.md](DOCUMENTATION.md) | Comprehensive technical documentation |
| [FEATURES.md](FEATURES.md) | Detailed feature descriptions & workflows |
| [CUSTOMIZATION.md](CUSTOMIZATION.md) | Customization guide for branding & features |
| [API_DOCUMENTATION.md](API_DOCUMENTATION.md) | API endpoints reference & examples |
| [FEATURES.md](FEATURES.md) | Feature descriptions |

---

## 🏗️ Application Files

### Core Configuration
```
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
├── package.json              # Node.js dependencies
├── vite.config.js            # Asset bundler config
├── phpunit.xml               # Testing configuration
├── artisan                   # Laravel CLI
```

### Bootstrap & Setup
```
bootstrap/
├── app.php                   # Application bootstrap
├── providers.php             # Service provider register
└── cache/
    ├── packages.php
    └── services.php
```

### Configuration
```
config/
├── app.php                   # Application config
├── auth.php                  # Authentication config
├── cache.php                 # Cache config
├── database.php              # Database config
├── filesystems.php           # File storage config
├── logging.php               # Logging config
├── mail.php                  # Email config
├── queue.php                 # Queue config
├── services.php              # Third-party services
└── session.php               # Session config
```

---

## 🎯 Application Code

### Models (Database Models)
```
app/Models/
├── User.php                  # User model (Auth)
├── Barber.php                # Barber model
├── Service.php               # Service model
├── Booking.php               # Booking model
└── Payment.php               # Payment model
```

**Key Methods by Model:**

**User.php**
- `bookings()` - HasMany relationship
- `isAdmin()` - Check if admin
- `isCustomer()` - Check if customer

**Barber.php**
- `bookings()` - HasMany relationship
- `getStatusLabel()` - Indonesian status text
- `getStatusColor()` - Badge color class

**Service.php**
- `bookings()` - HasMany relationship
- `getPriceFormatted()` - Formatted price

**Booking.php**
- `customer()` - BelongsTo User
- `barber()` - BelongsTo Barber
- `service()` - BelongsTo Service
- `payment()` - HasOne Payment
- `getStatusLabel()` - Status badge text
- `getStatusColor()` - Badge color

**Payment.php**
- `booking()` - BelongsTo Booking
- `getStatusLabel()` - Payment status text
- `getStatusColor()` - Badge color
- `getAmountFormatted()` - Formatted amount

### Controllers (Business Logic)
```
app/Http/Controllers/
├── AuthController.php
│   ├── showLogin()
│   ├── login()
│   ├── showRegister()
│   ├── register()
│   └── logout()
│
├── BookingController.php
│   ├── create()
│   ├── store()
│   ├── show()
│   ├── cancel()
│   ├── getAvailableSlots()      [AJAX]
│   └── isTimeSlotBooked()
│
├── DashboardController.php
│   └── index()                  [Customer Dashboard]
│
├── AdminDashboardController.php
│   ├── index()                  [Admin Dashboard]
│   ├── bookings()
│   ├── showBooking()
│   ├── approveBooking()
│   ├── rejectBooking()
│   ├── completeBooking()
│   ├── barbers()
│   ├── createBarber()
│   ├── storeBarber()
│   ├── editBarber()
│   ├── updateBarber()
│   ├── deleteBarber()
│   ├── services()
│   ├── createService()
│   ├── storeService()
│   ├── editService()
│   ├── updateService()
│   ├── deleteService()
│   ├── payments()
│   └── updatePaymentStatus()
│
└── PaymentController.php
    ├── show()                   [Customer]
    ├── showConfirmation()       [Customer]
    ├── submitPayment()          [Customer]
    └── markAsX()                [Admin]
```

### Middleware (Access Control)
```
app/Http/Middleware/
├── IsAdmin.php                 # Admin-only routes
├── IsCustomer.php              # Customer-only routes
└── (Laravel default middleware)
```

### Providers
```
app/Providers/
└── AppServiceProvider.php      # Service provider
```

---

## 🎨 Views (Frontend Templates)

### Layouts
```
resources/views/layouts/
└── app.blade.php              # Master layout template
    ├── Navbar (conditional links)
    ├── Alert messages
    ├── Content slot
    ├── Footer
    └── Bootstrap 5 + Custom CSS
```

### Authentication Views
```
resources/views/auth/
├── login.blade.php
│   ├── Role selector (Customer/Admin)
│   ├── Email & password inputs
│   └── Remember me checkbox
│
├── register.blade.php
│   ├── Name, email, password inputs
│   ├── Password strength indicator
│   └── Validation error display
│
└── forgot-password.blade.php  [Future]
```

### Customer Views
```
resources/views/customer/
├── dashboard.blade.php
│   ├── Stats cards (4 total, pending, approved, completed)
│   ├── Recent bookings table
│   └── Action buttons
│
resources/views/bookings/
├── create.blade.php            # 4-step wizard
│   ├── Step 1: Service selection
│   ├── Step 2: Barber selection
│   ├── Step 3: Date & time picker
│   ├── Step 4: Confirmation
│   └── JavaScript navigation
│
└── show.blade.php              # Booking detail
    ├── Booking info
    ├── Service & barber details
    ├── Status timeline
    ├── Payment section
    └── Action buttons

resources/views/payments/
├── confirmation.blade.php       # Payment form
│   ├── Payment method selector
│   ├── Bank details display
│   ├── Transaction ID input
│   └── Notes field
│
└── show.blade.php              # Payment status
    ├── Payment details
    ├── Status timeline
    └── Action buttons
```

### Admin Views
```
resources/views/admin/
│
├── dashboard.blade.php
│   ├── 7 stat cards
│   ├── Quick action buttons
│   └── Recent bookings table
│
├── bookings/
│   ├── index.blade.php         # Booking list with filters
│   └── show.blade.php          # Booking detail + actions
│
├── barbers/
│   ├── index.blade.php         # Barber list (card layout)
│   ├── create.blade.php        # Add barber form
│   └── edit.blade.php          # Edit barber form
│
├── services/
│   ├── index.blade.php         # Service list (table)
│   ├── create.blade.php        # Add service form
│   └── edit.blade.php          # Edit service form
│
└── payments/
    └── index.blade.php         # Payment list with actions
```

### Public Views
```
resources/views/
└── welcome.blade.php           # Homepage
    ├── Fixed navbar
    ├── Hero section
    ├── Features section (6 cards)
    └── CTA section
```

---

## 🗄️ Database Files

### Migrations (Database Schema)
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2026_05_02_000001_add_role_to_users_table.php
├── 2026_05_02_000002_create_barbers_table.php
├── 2026_05_02_000003_create_services_table.php
├── 2026_05_02_000004_create_bookings_table.php
└── 2026_05_02_000005_create_payments_table.php
```

### Seeders (Sample Data)
```
database/seeders/
├── DatabaseSeeder.php          # Main seeder
│   └── Creates:
│       ├── 1 admin user
│       ├── 2 customer users
│       ├── 3 barbers
│       ├── 4 services
│       ├── 6 bookings
│       └── 6 payments
│
└── UserFactory.php             # User factory
```

---

## 🛣️ Routes

### Route File
```
routes/
└── web.php                     # All web routes
    ├── Public routes (/, /login, /register)
    ├── Customer routes (prefix: /customer)
    │   ├── /dashboard
    │   ├── /bookings (CRUD)
    │   ├── /bookings/slots/available [AJAX]
    │   └── /payments/{id}
    │
    └── Admin routes (prefix: /admin)
        ├── /dashboard
        ├── /bookings (list, show, approve, reject, complete)
        ├── /barbers (full CRUD)
        ├── /services (full CRUD)
        └── /payments (list, update status)
```

---

## 📦 Assets

### CSS
```
resources/css/
└── app.css                     # Main stylesheet
    ├── Bootstrap 5 import
    ├── Custom variables
    └── Component styles
```

### JavaScript
```
resources/js/
├── app.js                      # Main app entry
├── bootstrap.js                # Bootstrap setup
│
Other Scripts (inline in Blade):
├── Booking wizard navigation
├── Password strength indicator
├── Time slot AJAX loading
└── Payment method toggle
```

### Build Output
```
public/build/
├── manifest.json               # Vite manifest
├── assets/
│   ├── app-XXXX.js
│   └── app-XXXX.css
```

---

## 🔑 Environment Files

```
.env.example                    # Template
.env                            # Local (not in git)

Required .env variables:
├── APP_NAME                    # Application name
├── APP_ENV                     # local/production
├── APP_KEY                     # Generated by artisan
├── APP_URL                     # Application URL
├── DB_CONNECTION               # mysql
├── DB_HOST                     # localhost
├── DB_PORT                     # 3306
├── DB_DATABASE                 # barbershop
├── DB_USERNAME                 # root
├── DB_PASSWORD                 # (if any)
└── Other optional configs
```

---

## 📁 Directory Structure

```
barbershop-app/
├── app/                        # Application code
├── bootstrap/                  # Framework bootstrap
├── config/                     # Configuration files
├── database/                   # Migrations & seeders
├── public/                     # Web root
├── resources/                  # Views & assets
├── routes/                     # Route definitions
├── storage/                    # Logs & cache
├── tests/                      # Unit/Feature tests
├── vendor/                     # Composer packages
└── (config files)
```

---

## 🧪 Testing Files (Optional)

```
tests/
├── TestCase.php                # Base test case
├── Feature/
│   └── ExampleTest.php
└── Unit/
    └── ExampleTest.php
```

---

## 🚀 Setup Automation

```
setup.sh                        # Automated setup script
                               # Runs:
                               # 1. Copies .env
                               # 2. Composer install
                               # 3. npm install
                               # 4. Generates key
                               # 5. Runs migrations
                               # 6. Seeds database
                               # 7. Builds assets
```

---

## 📊 File Statistics

| Category | Count | Description |
|----------|-------|-------------|
| Models | 5 | Database models |
| Controllers | 5 | Business logic controllers |
| Migrations | 8 | Database schema files |
| Views | 18+ | Blade templates |
| Routes | 40+ | Web routes |
| Documentation | 8 | MD documentation files |
| Config Files | 10 | Laravel config |

---

## 🔗 Key Relationships

### Model Relationships
```
User (1) ─→ (∞) Booking
User (1) ─→ (∞) Payment (through Booking)

Barber (1) ─→ (∞) Booking
Service (1) ─→ (∞) Booking

Booking (1) ─→ (1) Payment
```

### Route Groups
```
Public Routes
├── /
├── /login
└── /register

Customer Routes (middleware: auth, customer)
├── /customer/dashboard
├── /customer/bookings/*
└── /customer/payments/*

Admin Routes (middleware: auth, admin)
├── /admin/dashboard
├── /admin/bookings/*
├── /admin/barbers/*
├── /admin/services/*
└── /admin/payments/*
```

---

## 🔐 Security Files

### Middleware
```
IsAdmin.php         # Admin role check
IsCustomer.php      # Customer role check
(+ Laravel defaults)
```

### CSRF Protection
```
Applied to: All POST, PUT, DELETE requests
Token generated: Per session
```

---

## 📝 Configuration Summary

| File | Purpose |
|------|---------|
| config/app.php | App settings, providers |
| config/database.php | Database connection |
| config/auth.php | Authentication settings |
| config/cache.php | Cache driver |
| bootstrap/app.php | Middleware & aliases |

---

## 🎯 Entry Points

### Web Entry
```
public/index.php → routes/web.php → Controllers
```

### CLI Entry
```
artisan → Laravel commands
```

### Testing
```
phpunit.xml → tests/ → phpunit
```

---

## 📦 Dependencies Summary

### Composer (PHP)
- laravel/framework (11.x)
- laravel/tinker
- (auto-installed with laravel)

### NPM (JavaScript)
- vite
- @vitejs/plugin-laravel
- bootstrap 5
- bootstrap-icons

---

**Total Project Files:** 100+  
**Total Documentation:** 8 files  
**Total Lines of Code:** 5000+  
**Documentation:** 1000+ lines  

---

Last Updated: May 2, 2026  
Version: 1.0.0
