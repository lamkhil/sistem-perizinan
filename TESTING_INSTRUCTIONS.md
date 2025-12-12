# 📋 Instruksi Testing dengan Postman

## 🚀 Quick Start

### 1. Import Postman Collection
1. Buka Postman
2. Klik **Import** → **File**
3. Pilih file `POSTMAN_COLLECTION.json`
4. Collection akan muncul di sidebar

### 2. Setup Environment
1. Klik **Environments** di sidebar
2. Buat environment baru: **Sistem Perizinan Local**
3. Tambahkan variables:
   - `base_url`: `http://127.0.0.1:8000`
   - `session_cookie`: (akan diisi setelah login)
   - `csrf_token`: (akan diisi setelah login)

### 3. Get Session Cookie & CSRF Token

#### Via Browser (Recommended):
1. Buka browser, akses: `http://127.0.0.1:8000/login`
2. Login dengan credentials:
   - Email: `admin@dpmptsp.surabaya.go.id`
   - Password: `Admin@2025`
3. Setelah login, buka **Developer Tools** (F12)
4. **Application** tab → **Cookies** → Copy value `laravel_session`
5. **Elements** tab → Cari `<meta name="csrf-token">` → Copy value `content`
6. Paste ke Postman environment variables

#### Via Postman (Alternative):
1. Gunakan request "Login (Get Session)" di collection
2. Check **Tests** tab untuk auto-extract cookie
3. Manual: Copy cookie dari response headers

### 4. Run Tests

#### Test 1: Get Notifications
- Request: **GET** `/api/notifications`
- Expected: Status 200, JSON dengan `notifications` array dan `count`

#### Test 2: Update Notification
- Request: **POST** `/api/notifications/1/update`
- Body:
  ```json
  {
    "status": "Menunggu",
    "menghubungi": "2024-12-20",
    "keterangan_menghubungi": "Sudah dihubungi"
  }
  ```
- Expected: Status 200, `success: true`

#### Test 3: Invalid Data (Should Fail)
- Request: **POST** `/api/notifications/1/update`
- Body:
  ```json
  {
    "status": "InvalidStatus"
  }
  ```
- Expected: Status 422 (Validation Error)

---

## ✅ Testing Checklist

### API Endpoints
- [ ] GET `/api/notifications` - Returns 200 with notifications array
- [ ] GET `/api/notifications` - Returns empty array for unauthorized users
- [ ] POST `/api/notifications/{id}/update` - Updates successfully with valid data
- [ ] POST `/api/notifications/{id}/update` - Returns 422 with invalid status
- [ ] POST `/api/notifications/{id}/update` - Returns 403 without authentication

### Security Tests
- [ ] CSRF Protection - Request without CSRF token returns 419
- [ ] Authentication - Request without session returns empty array
- [ ] Authorization - Request with wrong role returns empty array
- [ ] XSS Protection - Script tags in input are stripped

---

## 🔧 Troubleshooting

### Problem: 419 CSRF Token Mismatch
**Solution:**
1. Get fresh CSRF token from page source
2. Make sure `X-CSRF-TOKEN` header is set correctly
3. Token harus match dengan session

### Problem: Empty Notifications Array
**Solution:**
1. Check if there are permohonan with status `Dikembalikan`
2. Verify user role is `dpmptsp` or `admin`
3. Check database: `SELECT * FROM permohonans WHERE status = 'Dikembalikan'`

### Problem: 403 Unauthorized
**Solution:**
1. Check user role in database
2. Make sure session cookie is valid
3. Re-login if session expired

---

## 📊 Test Results Template

```
Date: _______________
Tester: _______________
Environment: Local / Production

API Tests:
✅ GET /api/notifications
✅ POST /api/notifications/{id}/update (Valid)
✅ POST /api/notifications/{id}/update (Invalid)

Security Tests:
✅ CSRF Protection
✅ Authentication
✅ Authorization
✅ XSS Protection

Notes:
_______________________________________
```

---

## 🎯 Expected Results

### All Tests Should:
- ✅ Return proper HTTP status codes
- ✅ Return JSON format
- ✅ Have proper error messages
- ✅ Respect authorization rules
- ✅ Validate input data
- ✅ Protect against XSS
- ✅ Protect against CSRF

---

## 📝 Notes

- Server harus running: `php artisan serve`
- Database harus ada data untuk testing
- User harus sudah login untuk authenticated requests
- CSRF token harus di-update jika session expired

