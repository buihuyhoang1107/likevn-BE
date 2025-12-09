# API Documentation - Facebook Buff System

**Base URL:** `http://127.0.0.1:8000/api` (Local) hoặc `https://yourdomain.com/api` (Production)

---

## Mục lục

1. [Authentication](#authentication)
2. [Public APIs](#public-apis)
3. [Protected APIs](#protected-apis)
4. [Admin APIs](#admin-apis)
5. [Hướng dẫn Admin](#hướng-dẫn-admin)
6. [Hướng dẫn Features](#hướng-dẫn-features)
7. [Error Responses](#error-responses)
8. [Các giá trị Enum](#các-giá-trị-enum)

---

## Authentication

Tất cả các API cần authentication sẽ sử dụng Bearer Token trong header:
```
Authorization: Bearer {token}
```

Token được trả về khi đăng nhập hoặc đăng ký thành công.

---

## Public APIs

### 🔓 Authentication (Không cần đăng nhập)

#### Đăng ký
```http
POST /api/register
Content-Type: application/json

{
  "username": "testuser",
  "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
  "full_name": "Nguyễn Văn A",
  "phone": "0123456789",
    "ref_code": "REF123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Đăng ký thành công",
  "data": {
    "user": {
      "id": 1,
      "username": "testuser",
      "email": "test@example.com",
      ...
    },
    "token": "1|xxxxxxxxxxxxx"
  }
}
```

#### Đăng nhập
```http
POST /api/login
Content-Type: application/json

{
  "username": "testuser",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Đăng nhập thành công",
  "data": {
    "user": {...},
    "token": "1|xxxxxxxxxxxxx"
  }
}
```

### 🔓 Services (Dịch vụ - Không cần đăng nhập)

#### Lấy danh sách dịch vụ
```http
GET /api/services?search=keyword&category=like_post_speed
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, description
- `category` (optional): Lọc theo category (like_post_speed, like_post_vip, v.v.)

**Ví dụ:**
```http
GET /api/services?search=like&category=like_post_speed
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Like bài viết Speed",
      "slug": "like-post-speed",
      "category": "like_post_speed",
      "servers": [...]
    }
  ]
}
```

#### Lấy chi tiết dịch vụ
```http
GET /api/services/{id}
```

#### Lấy danh sách server của dịch vụ
```http
GET /api/services/{serviceId}/servers?search=keyword&status=active&min_price=10&max_price=100
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, code, description
- `status` (optional): Lọc theo trạng thái (active, slow, stopped)
- `min_price` (optional): Giá tối thiểu
- `max_price` (optional): Giá tối đa

**Ví dụ:**
```http
GET /api/services/1/servers?search=Server&status=active&min_price=10&max_price=50
```

#### Tính giá tiền
```http
POST /api/calculate-price
Content-Type: application/json

{
  "server_id": 1,
  "quantity": 100
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "price_per_unit": 26.2,
    "quantity": 100,
    "total_price": 2620.00
  }
}
```

---

## Protected APIs

### 🔒 Authentication (Cần đăng nhập)

#### Đăng xuất
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Lấy thông tin user hiện tại
```http
GET /api/me
Authorization: Bearer {token}
```

### 🔒 User (Người dùng)

#### Cập nhật thông tin cá nhân
```http
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "username": "newusername",
    "email": "newemail@example.com",
    "full_name": "Tên mới",
    "phone": "0987654321",
    "ref_code": "NEWREF",
    "password": "newpassword" // optional
}
```

#### Lấy số dư
```http
GET /api/balance
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "balance": 1000000.00,
        "monthly_deposit": 500000.00
    }
}
```

### 🔒 Orders (Đơn hàng)

#### Tạo đơn hàng
```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "service_id": 1,
  "server_id": 1,
  "uid": "https://facebook.com/post/123456",
  "account_name": "Tên tài khoản",
  "content": "Nội dung bình luận (cho dịch vụ tăng bình luận)",
  "note": "Ghi chú",
  "quantity": 100,
  "emotion": "like", // like, love, haha, wow, sad, angry
  "speed": "nhanh" // nhanh, cham, trung_binh
}
```

**Response:**
```json
{
  "success": true,
  "message": "Tạo đơn hàng thành công",
  "data": {
    "id": 1,
    "user_id": 1,
    "service_id": 1,
    "server_id": 1,
    "quantity": 100,
    "total_price": 2620.00,
    "status": "pending",
    ...
  }
}
```

#### Lấy danh sách đơn hàng của user
```http
GET /api/orders?page=1&search=keyword&status=pending&service_id=1&date_from=2024-01-01&date_to=2024-12-31
Authorization: Bearer {token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo uid, account_name, note
- `status` (optional): Lọc theo trạng thái (pending, processing, completed, cancelled, failed)
- `service_id` (optional): Lọc theo dịch vụ
- `date_from` (optional): Lọc từ ngày (format: YYYY-MM-DD)
- `date_to` (optional): Lọc đến ngày (format: YYYY-MM-DD)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
GET /api/orders?search=facebook.com&status=completed&date_from=2024-12-01
```

#### Lấy chi tiết đơn hàng
```http
GET /api/orders/{id}
Authorization: Bearer {token}
```

---

## Admin APIs

### 👑 Quản lý Users

Tất cả admin APIs cần user có quyền admin (id = 1 hoặc type = 'admin').

#### Lấy danh sách users
```http
GET /api/admin/users?page=1&search=keyword&type=user&is_active=true&is_verified=false
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo username, email, full_name
- `type` (optional): Lọc theo loại user (user, agent, collaborator, admin)
- `is_active` (optional): Lọc theo trạng thái active (true/false)
- `is_verified` (optional): Lọc theo trạng thái verified (true/false)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
GET /api/admin/users?search=admin&type=admin&is_active=true
```

#### Lấy chi tiết user
```http
GET /api/admin/users/{id}
Authorization: Bearer {admin_token}
```

#### Tạo user mới
```http
POST /api/admin/users
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "username": "newuser",
  "email": "user@example.com",
  "full_name": "Tên đầy đủ",
  "phone": "0123456789",
  "ref_code": "REF123",
  "password": "password123",
  "type": "user", // user, agent, collaborator
  "balance": 0,
  "is_verified": false,
  "is_active": true
}
```

#### Cập nhật user
```http
PUT /api/admin/users/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "username": "newusername",
  "email": "newemail@example.com",
  "type": "agent",
  "balance": 1000000,
  "monthly_deposit": 500000,
  "level": 2,
  "is_verified": true,
  "is_active": true
}
```

**Lưu ý:** Tất cả fields đều optional, chỉ cần gửi field muốn cập nhật.

#### Xóa user
```http
DELETE /api/admin/users/{id}
Authorization: Bearer {admin_token}
```

### 👑 Quản lý Orders

#### Lấy danh sách đơn hàng
```http
GET /api/admin/orders?page=1&search=keyword&status=pending&user_id=1&service_id=1&date_from=2024-01-01&date_to=2024-12-31
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo uid, account_name, note, admin_note
- `status` (optional): Lọc theo trạng thái (pending, processing, completed, cancelled, failed)
- `user_id` (optional): Lọc theo user
- `service_id` (optional): Lọc theo dịch vụ
- `server_id` (optional): Lọc theo server
- `date_from` (optional): Lọc từ ngày (format: YYYY-MM-DD)
- `date_to` (optional): Lọc đến ngày (format: YYYY-MM-DD)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
GET /api/admin/orders?search=facebook.com&status=completed&date_from=2024-12-01
```

#### Lấy chi tiết đơn hàng
```http
GET /api/admin/orders/{id}
Authorization: Bearer {admin_token}
```

#### Cập nhật đơn hàng
```http
PUT /api/admin/orders/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "status": "processing", // pending, processing, completed, cancelled, failed
  "admin_note": "Ghi chú của admin",
  "ran": 50 // Số lượng đã chạy
}
```

#### Xóa đơn hàng
```http
DELETE /api/admin/orders/{id}
Authorization: Bearer {admin_token}
```

### 👑 Quản lý Services

#### Lấy danh sách dịch vụ (bao gồm inactive)
```http
GET /api/admin/services?page=1&search=keyword&category=like_post_speed&is_active=true
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, description
- `category` (optional): Lọc theo category (like_post_speed, like_post_vip, v.v.)
- `is_active` (optional): Lọc theo trạng thái active (true/false)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
GET /api/admin/services?search=like&category=like_post_speed&is_active=true
```

#### Lấy chi tiết dịch vụ
```http
GET /api/admin/services/{id}
Authorization: Bearer {admin_token}
```

#### Tạo dịch vụ mới
```http
POST /api/admin/services
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Dịch vụ mới",
    "description": "Mô tả dịch vụ",
    "category": "like_post_speed", // like_post_speed, like_post_vip, sub_personal_fanpage, like_fanpage, like_comment, increase_comment, share_post
    "is_active": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Tạo dịch vụ thành công",
    "data": {
        "id": 8,
        "name": "Dịch vụ mới",
        "slug": "dich-vu-moi",
        "description": "Mô tả dịch vụ",
        "category": "like_post_speed",
        "is_active": true,
        "servers": []
    }
}
```

#### Cập nhật dịch vụ
```http
PUT /api/admin/services/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Tên mới",
    "description": "Mô tả mới",
    "category": "like_post_vip",
    "is_active": false
}
```

**Lưu ý:** Các trường đều optional, chỉ cần gửi trường muốn cập nhật.

#### Xóa dịch vụ
```http
DELETE /api/admin/services/{id}
Authorization: Bearer {admin_token}
```

**Lưu ý:** 
- Chỉ có thể xóa dịch vụ chưa có đơn hàng nào
- Chỉ có thể xóa dịch vụ chưa có server nào
- Nếu dịch vụ đã có đơn hàng/server, nên vô hiệu hóa (`is_active = false`) thay vì xóa

### 👑 Quản lý Servers

#### Lấy danh sách server
```http
GET /api/admin/servers?service_id=1&search=keyword&status=active&is_active=true
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, code, description
- `service_id` (optional): Lọc server theo service
- `status` (optional): Lọc theo trạng thái (active, slow, stopped)
- `is_active` (optional): Lọc theo trạng thái active (true/false)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
GET /api/admin/servers?search=Server&service_id=1&status=active&is_active=true
```

#### Lấy chi tiết server
```http
GET /api/admin/servers/{id}
Authorization: Bearer {admin_token}
```

#### Tạo server mới
```http
POST /api/admin/servers
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Server Like Speed 2",
    "code": "LS2",
    "service_id": 1,
    "description": "Mô tả server",
    "price_per_unit": 150.00,
    "status": "active", // active, slow, stopped
    "min_quantity": 10,
    "max_quantity": 5000,
    "is_active": true,
    
    // Features - Có thể dùng các field riêng lẻ (dễ sử dụng):
    "support_batch": true,           // Hỗ trợ xử lý theo lô
    "support_livestream": false,     // Hỗ trợ livestream
    "quality": "high",                // Chất lượng: high, medium, low
    "warranty_days": 7,               // Số ngày bảo hành
    "country": "vietnam",            // Quốc gia
    "account_type": "verified"       // Loại tài khoản
    
    // HOẶC gửi features dạng object (nếu muốn):
    // "features": {
    //     "support_batch": true,
    //     "quality": "high",
    //     "warranty_days": 7
    // }
}
```

**Response:**
```json
{
    "success": true,
    "message": "Tạo server thành công",
    "data": {
        "id": 8,
        "name": "Server Like Speed 2",
        "code": "LS2",
        "service_id": 1,
        "price_per_unit": "150.00",
        "status": "active",
        "min_quantity": 10,
        "max_quantity": 5000,
        "is_active": true,
        "service": {...}
    }
}
```

#### Cập nhật server
```http
PUT /api/admin/servers/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Server Like Speed 2 Updated",
    "description": "Mô tả mới cho server",
    "price_per_unit": 200.00,
    "status": "slow",
    "min_quantity": 20,
    "max_quantity": 10000,
    "is_active": false,
    
    // Cập nhật features - Dùng các field riêng lẻ (dễ nhất):
    "support_batch": true,
    "support_livestream": false,
    "quality": "high",
    "warranty_days": 7,
    "country": "vietnam",
    "account_type": "verified"
    
    // HOẶC gửi features object để override tất cả:
    // "features": {
    //     "support_batch": true,
    //     "quality": "high"
    // }
    
    // HOẶC xóa features:
    // "features": null
}
```

**Lưu ý:** 
- Các trường đều optional, chỉ cần gửi trường muốn cập nhật
- `description` có thể cập nhật hoặc set về null
- **Features - Cách dễ nhất:** Dùng các field riêng lẻ như `support_batch`, `quality`, v.v. (không cần hiểu JSON)
- **Features - Cách nâng cao:** Gửi `features` dạng object để override tất cả
- Các field features riêng lẻ sẽ merge với features hiện có, còn `features` object sẽ replace hoàn toàn

#### Xóa server
```http
DELETE /api/admin/servers/{id}
Authorization: Bearer {admin_token}
```

**Lưu ý:** 
- Chỉ có thể xóa server chưa có đơn hàng nào
- Nếu server đã có đơn hàng, nên vô hiệu hóa (`is_active = false`) thay vì xóa

### 👑 Quản lý Settings

#### Lấy cài đặt hệ thống
```http
GET /api/admin/settings
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "enable_balance_check": false
    }
}
```

#### Cập nhật cài đặt hệ thống
```http
PUT /api/admin/settings
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "enable_balance_check": true  // true = bật kiểm tra số dư, false = tắt
}
```

**Response:**
```json
{
    "success": true,
    "message": "Đã bật kiểm tra số dư", // hoặc "Đã tắt kiểm tra số dư"
    "data": {
        "enable_balance_check": true
    }
}
```

---

## Hướng dẫn Admin

### Ai là Admin?

Theo logic trong code (`app/Models/User.php`), một user được coi là **admin** nếu:

1. **User có `id = 1`** (User đầu tiên được tạo trong hệ thống)
   - User đầu tiên đăng ký sẽ tự động có quyền admin

2. **HOẶC** User có `type = 'admin'` trong database
   - Có thể set thủ công trong database

### Cách kiểm tra user nào là admin

#### Cách 1: Kiểm tra trong Database (phpMyAdmin)

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Chọn database `likewebapp`
3. Vào bảng `users`
4. Kiểm tra:
   - User có `id = 1` → Là admin
   - User có `type = 'admin'` → Là admin

#### Cách 2: Kiểm tra qua API

Đăng nhập và thử truy cập API admin:
```http
GET http://127.0.0.1:8000/api/admin/settings
Authorization: Bearer {token}
```

- Nếu thành công → User này là admin
- Nếu lỗi 403 "Không có quyền truy cập" → User này không phải admin

### Tạo tài khoản Admin đầu tiên

#### Cách 1: Đăng ký user đầu tiên (Khuyến nghị)

User đầu tiên được tạo sẽ tự động có quyền admin (id = 1):

```http
POST http://127.0.0.1:8000/api/register
Content-Type: application/json

{
    "username": "admin",
    "email": "admin@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "full_name": "Admin User"
}
```

#### Cách 2: Set type = 'admin' trong database

1. Mở phpMyAdmin
2. Vào bảng `users`
3. Tìm user muốn set làm admin
4. Sửa cột `type` thành `admin`
5. Lưu lại

### Quyền của Admin

Admin có thể truy cập tất cả các API trong phần [Admin APIs](#admin-apis) ở trên.

---

## Hướng dẫn Features

### Features là gì?

`features` là các **tính năng đặc biệt** của server như hỗ trợ batch, chất lượng, bảo hành, v.v.

### Cách sử dụng ĐƠN GIẢN NHẤT (Khuyến nghị)

Bạn không cần hiểu JSON! Chỉ cần gửi các field riêng lẻ:

#### Tạo server với features
```http
POST /api/admin/servers
Content-Type: application/json

{
    "name": "Server Like Comment",
    "code": "LC_S3",
    "service_id": 5,
    "price_per_unit": 50.4,
    "description": "Server tốt",
    
    // Features - Chỉ cần gửi các field này:
    "support_batch": true,           // true/false - Hỗ trợ xử lý theo lô
    "support_livestream": false,      // true/false - Hỗ trợ livestream
    "quality": "high",                // "high", "medium", "low" - Chất lượng
    "warranty_days": 7,               // Số ngày bảo hành
    "country": "vietnam",            // Quốc gia
    "account_type": "verified"       // Loại tài khoản
}
```

#### Cập nhật features
```http
PUT /api/admin/servers/{id}
Content-Type: application/json

{
    // Chỉ cần gửi field muốn cập nhật:
    "support_batch": true,
    "quality": "high",
    "warranty_days": 7
}
```

**Lưu ý:** Các field features sẽ tự động merge với features hiện có, không cần gửi tất cả.

### Các field Features có sẵn

| Field | Kiểu | Mô tả | Ví dụ |
|-------|------|-------|-------|
| `support_batch` | boolean | Hỗ trợ xử lý theo lô | `true`, `false` |
| `support_livestream` | boolean | Hỗ trợ livestream | `true`, `false` |
| `quality` | string | Chất lượng | `"high"`, `"medium"`, `"low"` |
| `warranty_days` | integer | Số ngày bảo hành | `7`, `30`, `0` |
| `country` | string | Quốc gia | `"vietnam"`, `"international"` |
| `account_type` | string | Loại tài khoản | `"verified"`, `"normal"` |

### Cách sử dụng NÂNG CAO (Tùy chọn)

Nếu bạn muốn gửi features dạng object:

```http
POST /api/admin/servers
Content-Type: application/json

{
    "name": "Server Like Comment",
    "code": "LC_S3",
    "service_id": 5,
    "price_per_unit": 50.4,
    "features": {
        "support_batch": true,
        "quality": "high",
        "warranty_days": 7,
        "custom_field": "giá trị tùy chỉnh"
    }
}
```

**Lưu ý:** Nếu gửi `features` object, nó sẽ override tất cả features hiện có.

### Xóa features
```http
PUT /api/admin/servers/{id}
Content-Type: application/json

{
    "features": null
}
```

### Lưu ý quan trọng

1. **Features là optional**: Không bắt buộc phải có, có thể bỏ qua hoàn toàn
2. **Cách dễ nhất**: Dùng các field riêng lẻ như `support_batch`, `quality`, v.v.
3. **Tự động merge**: Khi update, các field riêng lẻ sẽ merge với features hiện có
4. **Override**: Nếu gửi `features` object, nó sẽ thay thế hoàn toàn features cũ
5. **Không cần hiểu JSON**: Bạn chỉ cần gửi các field đơn giản như `true`, `false`, `"high"`, `7`

---

## Error Responses

Tất cả các lỗi sẽ trả về format:
```json
{
  "success": false,
  "message": "Thông báo lỗi"
}
```

**HTTP Status Codes:**
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 409: Conflict
- 500: Internal Server Error

---

## Các giá trị Enum

### Loại dịch vụ (category)
- `like_post_speed` - Like bài viết Speed
- `like_post_vip` - Like bài viết VIP
- `sub_personal_fanpage` - Sub cá nhân & Sub fanpage
- `like_fanpage` - Like fanpage
- `like_comment` - Like cho bình luận
- `increase_comment` - Tăng bình luận
- `share_post` - Chia sẻ bài viết

### Loại cảm xúc (emotion)
- `like` - Like
- `love` - Tim
- `haha` - Haha
- `wow` - Wow
- `sad` - Buồn
- `angry` - Tức giận

### Tốc độ (speed)
- `nhanh` - Nhanh
- `cham` - Chậm
- `trung_binh` - Trung bình

### Trạng thái đơn hàng (status)
- `pending` - Đang chờ
- `processing` - Đang xử lý
- `completed` - Hoàn thành
- `cancelled` - Đã hủy
- `failed` - Thất bại

### Trạng thái server (status)
- `active` - Hoạt động bình thường
- `slow` - Chậm
- `stopped` - Dừng

### Loại user (type)
- `user` - Người dùng thường
- `agent` - Đại lý
- `collaborator` - Cộng tác viên
- `admin` - Quản trị viên (set trong database)

### Chất lượng (quality)
- `high` - Cao
- `medium` - Trung bình
- `low` - Thấp

---

## Tính năng Tìm kiếm và Lọc

Tất cả các API lấy danh sách đều hỗ trợ tìm kiếm và lọc dữ liệu. Bạn có thể kết hợp nhiều tham số cùng lúc.

### 📊 Bảng tổng hợp tính năng tìm kiếm

| API | Endpoint | Tìm kiếm (search) | Các filter hỗ trợ |
|-----|----------|-------------------|-------------------|
| **Public Services** | `GET /api/services` | name, description | `category` |
| **Public Servers** | `GET /api/services/{id}/servers` | name, code, description | `status`, `min_price`, `max_price` |
| **User Orders** | `GET /api/orders` | uid, account_name, note | `status`, `service_id`, `date_from`, `date_to` |
| **Admin Users** | `GET /api/admin/users` | username, email, full_name | `type`, `is_active`, `is_verified` |
| **Admin Orders** | `GET /api/admin/orders` | uid, account_name, note, admin_note | `status`, `user_id`, `service_id`, `server_id`, `date_from`, `date_to` |
| **Admin Services** | `GET /api/admin/services` | name, description | `category`, `is_active` |
| **Admin Servers** | `GET /api/admin/servers` | name, code, description | `service_id`, `status`, `is_active` |

### 🔍 Chi tiết từng API

#### Public APIs

##### Services (`GET /api/services`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, description
- **Lọc:** `?category=like_post_speed`
- **Ví dụ:** `GET /api/services?search=like&category=like_post_speed`

##### Servers (`GET /api/services/{serviceId}/servers`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, code, description
- **Lọc:** `?status=active&min_price=10&max_price=100`
- **Ví dụ:** `GET /api/services/1/servers?search=Server&status=active&min_price=10&max_price=50`

#### User APIs

##### Orders (`GET /api/orders`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo uid, account_name, note
- **Lọc:** `?status=completed&service_id=1&date_from=2024-01-01&date_to=2024-12-31`
- **Ví dụ:** `GET /api/orders?search=facebook.com&status=completed&date_from=2024-12-01`

#### Admin APIs

##### Users (`GET /api/admin/users`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo username, email, full_name
- **Lọc:** `?type=user&is_active=true&is_verified=false`
- **Ví dụ:** `GET /api/admin/users?search=admin&type=admin&is_active=true`

##### Orders (`GET /api/admin/orders`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo uid, account_name, note, admin_note
- **Lọc:** `?status=completed&user_id=1&service_id=1&date_from=2024-01-01&date_to=2024-12-31`
- **Ví dụ:** `GET /api/admin/orders?search=facebook.com&status=completed&date_from=2024-12-01`

##### Services (`GET /api/admin/services`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, description
- **Lọc:** `?category=like_post_speed&is_active=true`
- **Ví dụ:** `GET /api/admin/services?search=like&category=like_post_speed&is_active=true`

##### Servers (`GET /api/admin/servers`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, code, description
- **Lọc:** `?service_id=1&status=active&is_active=true`
- **Ví dụ:** `GET /api/admin/servers?search=Server&service_id=1&status=active&is_active=true`

### 💡 Ví dụ sử dụng

#### Tìm kiếm đơn giản
```http
# Tìm user có username chứa "admin"
GET /api/admin/users?search=admin

# Tìm dịch vụ có tên chứa "like"
GET /api/services?search=like

# Tìm server có code chứa "S1"
GET /api/services/1/servers?search=S1
```

#### Kết hợp nhiều filter
```http
# Tìm đơn hàng có uid chứa "facebook.com", status = completed, từ ngày 1/12/2024
GET /api/admin/orders?search=facebook.com&status=completed&date_from=2024-12-01

# Tìm server có name chứa "Speed", status = active, giá từ 10-50
GET /api/services/1/servers?search=Speed&status=active&min_price=10&max_price=50

# Tìm user admin đang active
GET /api/admin/users?search=admin&type=admin&is_active=true

# Lọc đơn hàng của user cụ thể trong tháng 12
GET /api/admin/orders?user_id=1&date_from=2024-12-01&date_to=2024-12-31
```

#### Lưu ý
- Tất cả các tham số đều **optional** (không bắt buộc)
- Có thể kết hợp nhiều filter cùng lúc
- Tìm kiếm không phân biệt hoa thường
- Tìm kiếm hỗ trợ tìm một phần của từ (LIKE query)

---

## Tổng kết API

- **Public APIs:** 6 endpoints
- **Protected APIs (User):** 5 endpoints
- **Admin APIs:** 20 endpoints (Users: 5, Orders: 4, Services: 5, Servers: 5, Settings: 2)
- **Tổng cộng:** 31 API endpoints
- **Tất cả API danh sách đều hỗ trợ tìm kiếm và lọc**

---

## Test nhanh với cURL

### Test đăng ký:
```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"username":"test","email":"test@test.com","password":"password123","password_confirmation":"password123","full_name":"Test User"}'
```

### Test lấy danh sách services:
```bash
curl http://127.0.0.1:8000/api/services
```

### Test đăng nhập:
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"test","password":"password123"}'
```

---

**Lưu ý:** User đầu tiên được tạo (id = 1) sẽ tự động có quyền admin.
