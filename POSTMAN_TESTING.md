# Postman Testing Documentation
## Sistem Perizinan - API Endpoints Testing

### Base URL
- **Local:** `http://localhost` atau `http://127.0.0.1`
- **Production:** `https://perizinan.dpmptsp-surabaya.my.id`

---

## 🔐 Authentication

### 1. Login (Get Session Cookie)
**POST** `/login`

**Headers:**
```
Content-Type: application/x-www-form-urlencoded
Accept: text/html,application/xhtml+xml
```

**Body (form-data):**
```
email: admin@dpmptsp.surabaya.go.id
password: Admin@2025
_token: [CSRF Token dari halaman login]
```

**Note:** 
- Setelah login, copy `laravel_session` cookie dari response
- Gunakan cookie ini untuk request berikutnya

---

## 📋 API Endpoints

### 1. Get Notifications
**GET** `/api/notifications`

**Headers:**
```
Cookie: laravel_session=[SESSION_COOKIE]
Accept: application/json
```

**Authorization Required:**
- Role: `dpmptsp` atau `admin`
- Must be authenticated

**Response (200 OK):**
```json
{
  "notifications": [
    {
      "id": 1,
      "no_permohonan": "PERM-001",
      "nama_usaha": "PT Contoh",
      "status": "Dikembalikan",
      "tanggal_pengembalian": "15 Desember 2024",
      "keterangan": "Berkas dikembalikan untuk perbaikan",
      "menghubungi": "2024-12-16",
      "keterangan_menghubungi": null,
      "url": "http://localhost/permohonan/1",
      "created_at": "2 hours ago"
    }
  ],
  "count": 1
}
```

**Test Cases:**
- ✅ Test dengan user `dpmptsp` → Should return notifications
- ✅ Test dengan user `admin` → Should return notifications
- ✅ Test dengan user `pd_teknis` → Should return empty array
- ✅ Test tanpa authentication → Should return empty array

---

### 2. Update Notification Status
**POST** `/api/notifications/{id}/update`

**Headers:**
```
Cookie: laravel_session=[SESSION_COOKIE]
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: [CSRF_TOKEN]
```

**Body (JSON):**
```json
{
  "status": "Menunggu",
  "menghubungi": "2024-12-20",
  "keterangan_menghubungi": "Sudah dihubungi via telepon"
}
```

**Authorization Required:**
- Role: `dpmptsp` atau `admin`
- Must be authenticated

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Status dan data menghubungi berhasil diperbarui",
  "permohonan": {
    "id": 1,
    "status": "Menunggu",
    "menghubungi": "2024-12-20",
    "keterangan_menghubungi": "Sudah dihubungi via telepon"
  }
}
```

**Validation Rules:**
- `status`: required, must be one of: `Menunggu`, `Dikembalikan`, `Diterima`, `Ditolak`
- `menghubungi`: nullable, must be valid date format (Y-m-d)
- `keterangan_menghubungi`: nullable, string

**Test Cases:**
- ✅ Test dengan valid data → Should return success
- ✅ Test dengan invalid status → Should return 422 validation error
- ✅ Test dengan invalid date format → Should return 422 validation error
- ✅ Test tanpa authentication → Should return 403 Unauthorized
- ✅ Test dengan role `pd_teknis` → Should return 403 Unauthorized

---

## 🧪 Testing Checklist

### API Notifications
- [ ] GET `/api/notifications` - With dpmptsp user
- [ ] GET `/api/notifications` - With admin user
- [ ] GET `/api/notifications` - With pd_teknis user (should return empty)
- [ ] GET `/api/notifications` - Without authentication (should return empty)
- [ ] POST `/api/notifications/1/update` - Valid data
- [ ] POST `/api/notifications/1/update` - Invalid status
- [ ] POST `/api/notifications/1/update` - Invalid date format
- [ ] POST `/api/notifications/1/update` - Without authentication (403)
- [ ] POST `/api/notifications/1/update` - With unauthorized role (403)

### Security Tests
- [ ] XSS Protection - Test dengan script tags di input
- [ ] CSRF Protection - Test tanpa CSRF token
- [ ] Authorization - Test dengan role yang tidak authorized
- [ ] SQL Injection - Test dengan SQL injection attempts

---

## 📝 Postman Collection Setup

### Environment Variables
Create a Postman Environment with:
```
base_url: http://localhost
session_cookie: [Will be set after login]
csrf_token: [Will be set after login]
```

### Pre-request Script (for authenticated requests)
```javascript
// Get CSRF token from cookie
const cookies = pm.cookies.all();
const csrfCookie = cookies.find(c => c.name === 'XSRF-TOKEN');
if (csrfCookie) {
    pm.environment.set('csrf_token', decodeURIComponent(csrfCookie.value));
}

// Set CSRF token in header
pm.request.headers.add({
    key: 'X-CSRF-TOKEN',
    value: pm.environment.get('csrf_token')
});
```

---

## 🔍 Manual Testing Steps

### Step 1: Login and Get Session
1. Open browser, go to `/login`
2. Login with credentials
3. Open Developer Tools → Application → Cookies
4. Copy `laravel_session` cookie value
5. Use this in Postman as cookie header

### Step 2: Get CSRF Token
1. After login, go to any page (e.g., `/dashboard`)
2. View page source, find `<meta name="csrf-token" content="...">`
3. Copy the token value
4. Use this in Postman as `X-CSRF-TOKEN` header

### Step 3: Test API Endpoints
1. Set cookie header: `Cookie: laravel_session=[VALUE]`
2. Set CSRF header: `X-CSRF-TOKEN: [VALUE]`
3. Test GET `/api/notifications`
4. Test POST `/api/notifications/{id}/update`

---

## ✅ Expected Results

### All Tests Should Pass:
- ✅ API returns JSON format
- ✅ Authentication works correctly
- ✅ Authorization checks work (role-based)
- ✅ Validation works (invalid data rejected)
- ✅ XSS protection works (script tags stripped)
- ✅ CSRF protection works
- ✅ Error handling works (proper error messages)

---

## 🐛 Troubleshooting

### Issue: 419 CSRF Token Mismatch
**Solution:** 
- Make sure you include `X-CSRF-TOKEN` header
- Get fresh token from page source after login

### Issue: 403 Unauthorized
**Solution:**
- Check user role (must be `dpmptsp` or `admin` for notifications API)
- Make sure session cookie is valid
- Re-login if session expired

### Issue: Empty Notifications Array
**Solution:**
- Check if there are permohonan with status `Dikembalikan`
- Check if permohonan is not created by `penerbitan_berkas` role
- Verify user has correct role

---

## 📊 Test Results Template

```
Date: [DATE]
Tester: [NAME]
Environment: [Local/Production]

API Endpoints:
- GET /api/notifications: ✅ PASS / ❌ FAIL
- POST /api/notifications/{id}/update: ✅ PASS / ❌ FAIL

Security Tests:
- XSS Protection: ✅ PASS / ❌ FAIL
- CSRF Protection: ✅ PASS / ❌ FAIL
- Authorization: ✅ PASS / ❌ FAIL

Notes:
[Any issues or observations]
```

