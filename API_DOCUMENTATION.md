# 📚 API Documentation

Dokumentasi API BarberShop Booking System untuk frontend integration dan development.

## 🌐 Base URL
```
http://localhost:8000
```

## 🔐 Authentication

Semua request dilakukan melalui session-based authentication (Laravel Session).

### Login
```http
POST /login
Content-Type: application/x-www-form-urlencoded

email=user@example.com&password=password123&is_admin=0
```

**Response:** 201 (Redirect ke dashboard)

### Logout
```http
POST /logout
```

---

## 👨‍💼 Barber Management (Admin Only)

### Get All Barbers
```http
GET /admin/barbers
```

**Response:** 200
```json
{
  "data": [
    {
      "id": 1,
      "name": "Rudi Hermawan",
      "phone": "0812345678",
      "bio": "Barber berpengalaman 10 tahun",
      "photo": null,
      "status": "available",
      "experience_years": 10,
      "created_at": "2026-05-02T12:00:00Z",
      "updated_at": "2026-05-02T12:00:00Z"
    }
  ]
}
```

### Create Barber
```http
POST /admin/barbers
Content-Type: application/json

{
  "name": "Ahmad Supriadi",
  "phone": "0898765432",
  "bio": "Barber profesional",
  "experience_years": 8,
  "status": "available"
}
```

**Response:** 201
```json
{
  "id": 4,
  "name": "Ahmad Supriadi",
  "status": "available"
}
```

### Update Barber
```http
PUT /admin/barbers/{id}
Content-Type: application/json

{
  "name": "Ahmad Supriadi",
  "phone": "0898765432",
  "bio": "Barber profesional berpengalaman",
  "status": "busy",
  "experience_years": 9
}
```

**Response:** 200

### Delete Barber
```http
DELETE /admin/barbers/{id}
```

**Response:** 200

---

## 🔪 Service Management (Admin Only)

### Get All Services
```http
GET /admin/services
```

**Response:** 200
```json
{
  "data": [
    {
      "id": 1,
      "name": "Potong Biasa",
      "description": "Potong rambut dengan model standar",
      "price": 30000,
      "duration_minutes": 30,
      "created_at": "2026-05-02T12:00:00Z"
    }
  ]
}
```

### Create Service
```http
POST /admin/services
Content-Type: application/json

{
  "name": "Potong Premium",
  "description": "Potong premium dengan konsultasi",
  "price": 75000,
  "duration_minutes": 60
}
```

**Response:** 201

### Update Service
```http
PUT /admin/services/{id}
Content-Type: application/json

{
  "name": "Potong Premium Plus",
  "description": "Potong premium dengan treatment",
  "price": 85000,
  "duration_minutes": 75
}
```

**Response:** 200

### Delete Service
```http
DELETE /admin/services/{id}
```

**Response:** 200

---

## 📅 Booking Management

### Create Booking (Customer)
```http
POST /customer/bookings
Content-Type: application/json

{
  "service_id": 1,
  "barber_id": 1,
  "booking_date": "2026-05-15 14:00"
}
```

**Response:** 201
```json
{
  "id": 1,
  "customer_id": 2,
  "barber_id": 1,
  "service_id": 1,
  "booking_date": "2026-05-15 14:00:00",
  "status": "pending",
  "created_at": "2026-05-02T12:00:00Z"
}
```

### Get Available Time Slots (AJAX)
```http
GET /customer/bookings/slots/available
?barber_id=1&booking_date=2026-05-15
```

**Response:** 200
```json
{
  "slots": [
    {
      "time": "09:00",
      "available": true
    },
    {
      "time": "09:30",
      "available": false
    },
    {
      "time": "10:00",
      "available": true
    }
  ]
}
```

### Get Booking Detail (Customer)
```http
GET /customer/bookings/{id}
```

**Response:** 200
```json
{
  "id": 1,
  "customer_id": 2,
  "barber_id": 1,
  "service_id": 1,
  "booking_date": "2026-05-15 14:00:00",
  "status": "pending",
  "notes": null,
  "customer": {
    "id": 2,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "barber": {
    "id": 1,
    "name": "Rudi Hermawan",
    "status": "available"
  },
  "service": {
    "id": 1,
    "name": "Potong Biasa",
    "price": 30000
  }
}
```

### Cancel Booking (Customer)
```http
POST /customer/bookings/{id}/cancel
```

**Response:** 200

### Get All Bookings (Admin)
```http
GET /admin/bookings
?status=pending&search=john
```

**Query Parameters:**
- `status`: pending, approved, rejected, completed, cancelled
- `search`: search by customer name/email
- `page`: pagination

**Response:** 200

### Approve Booking (Admin)
```http
POST /admin/bookings/{id}/approve
```

**Response:** 200

### Reject Booking (Admin)
```http
POST /admin/bookings/{id}/reject
Content-Type: application/json

{
  "reason": "Barber sedang cuti"
}
```

**Response:** 200

### Complete Booking (Admin)
```http
POST /admin/bookings/{id}/complete
```

**Response:** 200

---

## 💳 Payment Management

### Get Payment Info (Customer)
```http
GET /customer/payments/{id}
```

**Response:** 200
```json
{
  "id": 1,
  "booking_id": 1,
  "amount": 30000,
  "status": "pending",
  "payment_method": null,
  "transaction_id": null,
  "created_at": "2026-05-02T12:00:00Z"
}
```

### Submit Payment (Customer)
```http
POST /customer/payments/{id}
Content-Type: application/json

{
  "payment_method": "transfer",
  "transaction_id": "BCA20260502001",
  "notes": "Transfer via BCA ke 123456789"
}
```

**Payment Methods:**
- `transfer` - Bank transfer
- `cash` - Bayar tunai

**Response:** 200

### Get All Payments (Admin)
```http
GET /admin/payments
?status=pending
```

**Query Parameters:**
- `status`: pending, paid, failed

**Response:** 200

### Update Payment Status (Admin)
```http
PUT /admin/payments/{id}
Content-Type: application/json

{
  "status": "paid"
}
```

**Possible Status:**
- `pending` - Menunggu konfirmasi
- `paid` - Sudah dibayar
- `failed` - Pembayaran gagal

**Response:** 200

---

## 📊 Dashboard APIs

### Get Customer Dashboard Data
```http
GET /customer/dashboard
```

**Response:** 200
```json
{
  "stats": {
    "total_bookings": 5,
    "pending_bookings": 1,
    "approved_bookings": 2,
    "completed_bookings": 2
  },
  "bookings": [
    {
      "id": 1,
      "booking_date": "2026-05-15 14:00:00",
      "barber": "Rudi Hermawan",
      "service": "Potong Biasa",
      "status": "pending"
    }
  ]
}
```

### Get Admin Dashboard Data
```http
GET /admin/dashboard
```

**Response:** 200
```json
{
  "stats": {
    "total_bookings": 50,
    "pending_bookings": 5,
    "approved_bookings": 20,
    "total_revenue": 1500000,
    "pending_payments": 500000,
    "total_customers": 15,
    "total_barbers": 3
  },
  "recent_bookings": [...]
}
```

---

## ❌ Error Responses

### 400 Bad Request
```json
{
  "message": "Validation failed",
  "errors": {
    "email": ["Email field is required"],
    "password": ["Password must be at least 8 characters"]
  }
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "message": "This action is unauthorized"
}
```

### 404 Not Found
```json
{
  "message": "Resource not found"
}
```

### 500 Internal Server Error
```json
{
  "message": "Internal server error",
  "error": "Detailed error message"
}
```

---

## 🔄 Status Codes Reference

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created |
| 204 | No Content - Request successful, no content |
| 400 | Bad Request - Invalid data |
| 401 | Unauthorized - Not authenticated |
| 403 | Forbidden - Not authorized |
| 404 | Not Found - Resource not found |
| 409 | Conflict - Resource already exists |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error |

---

## 📋 Common Response Headers

```
Content-Type: application/json
X-CSRF-TOKEN: token_value
Set-Cookie: XSRF-TOKEN=...; laravel_session=...
```

---

## 🧪 Testing API with cURL

### Test Login
```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=john@example.com&password=password123"
```

### Test Get Barbers (Admin Only)
```bash
curl -X GET http://localhost:8000/admin/barbers \
  -H "Accept: application/json"
```

### Test Create Booking
```bash
curl -X POST http://localhost:8000/customer/bookings \
  -H "Content-Type: application/json" \
  -d '{
    "service_id": 1,
    "barber_id": 1,
    "booking_date": "2026-05-15 14:00"
  }'
```

### Test Get Available Slots
```bash
curl -X GET "http://localhost:8000/customer/bookings/slots/available?barber_id=1&booking_date=2026-05-15"
```

---

## 📝 Rate Limiting

Default Laravel rate limiting per route:
- Login: 60 requests per minute
- Other endpoints: Unlimited (can be customized)

---

## 🔐 CSRF Protection

Semua POST, PUT, DELETE requests memerlukan CSRF token:

```html
<!-- Di Blade Template -->
@csrf

<!-- Di AJAX -->
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

---

## 📚 Additional Resources

- [Laravel API Documentation](https://laravel.com/docs/11/eloquent)
- [RESTful API Best Practices](https://restfulapi.net/)
- See DOCUMENTATION.md for more details

---

**Last Updated:** May 2, 2026
**Version:** 1.0.0
