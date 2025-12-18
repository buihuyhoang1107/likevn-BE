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
- `category` (optional): Lọc theo category cụ thể (like_post_speed, like_post_vip, v.v.)

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

#### Lấy danh sách các platform (để chia tab/bảng)
```http
GET /api/admin/platforms
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "facebook",
      "name": "Facebook",
      "label": "Quản lý dịch vụ Facebook",
      "total_services": 19,
      "active_services": 18,
      "inactive_services": 1
    },
    {
      "id": "instagram",
      "name": "Instagram",
      "label": "Quản lý dịch vụ Instagram",
      "total_services": 7,
      "active_services": 7,
      "inactive_services": 0
    },
    {
      "id": "youtube",
      "name": "YouTube",
      "label": "Quản lý dịch vụ YouTube",
      "total_services": 8,
      "active_services": 8,
      "inactive_services": 0
    }
    // ... các platform khác
  ]
}
```

**Cách sử dụng:**
- Gọi API này để lấy danh sách các platform
- Dùng `id` của platform để filter khi gọi `/api/admin/services?platform=facebook`
- Frontend có thể tạo các tab/bảng dựa trên danh sách này

#### Lấy danh sách dịch vụ (bao gồm inactive)
```http
GET /api/admin/services?page=1&search=keyword&category=like_post_speed&platform=facebook&is_active=true
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, description
- `category` (optional): Lọc theo category cụ thể (like_post_speed, like_post_vip, v.v.)
- `platform` (optional): Lọc theo nhóm dịch vụ (facebook, instagram, threads, tiktok, shopee, telegram, youtube, twitter, lazada, google)
- `is_active` (optional): Lọc theo trạng thái active (true/false)
- `page` (optional): Số trang (mặc định: 1)

**Ví dụ:**
```http
# Lấy tất cả dịch vụ Facebook (bao gồm inactive)
GET /api/admin/services?platform=facebook

# Lấy tất cả dịch vụ YouTube đang active
GET /api/admin/services?platform=youtube&is_active=true

# Lấy tất cả dịch vụ TikTok (bao gồm inactive)
GET /api/admin/services?platform=tiktok

# Tìm kiếm và lọc category cụ thể
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
    "category": "like_post_speed", // like_post_speed, like_post_vip, sub_personal_fanpage, like_fanpage, like_comment, increase_comment, share_post, member_group, review_fanpage, checkin_fanpage, event_facebook, vip_like_monthly, vip_like_group_monthly, vip_comment_monthly, vip_eye_monthly, vip_view_monthly, vip_share_monthly, eye_live_view_video, friend_cleanup, instagram_like, instagram_comment, instagram_follow, instagram_view, instagram_live_eye, instagram_vip_like, instagram_vip_comment, threads_like, threads_follow, tiktok_like, tiktok_like_comment, tiktok_follow, tiktok_view, tiktok_comment, tiktok_share, tiktok_save, tiktok_live_like, tiktok_live_share, tiktok_live_comment, tiktok_live_eye, tiktok_live_pk, tiktok_vip_like, tiktok_vip_view, shopee_follow, shopee_love, shopee_like_review, shopee_live_eye, telegram_member_sub, telegram_post_view, telegram_post_reaction, youtube_like, youtube_view, youtube_view_400h, youtube_live_stream, youtube_like_400h, youtube_comment, youtube_like_comment, youtube_subscribe, twitter_like, twitter_follow, twitter_view, twitter_retweet, twitter_comment, twitter_live_stream, twitter_vip_like, twitter_vip_view, lazada_sub, google_map_create, google_map_rip, google_map_review
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
GET /api/admin/servers?platform=facebook&search=keyword&status=active&is_active=true&page=1&per_page=10
Authorization: Bearer {admin_token}
```

**Query Parameters:**
- `search` (optional): Tìm kiếm theo name, code, description
- `service_id` (optional): Lọc server theo service - **Ưu tiên cao nhất**
- `platform` (optional): Lọc theo **nhóm dịch vụ** (platform), **không phải category**.  
  - Giá trị hợp lệ: `facebook`, `instagram`, `threads`, `tiktok`, `shopee`, `telegram`, `youtube`, `twitter`, `lazada`, `google`  
  - Ví dụ đúng: `platform=google` (sẽ lấy tất cả servers của các dịch vụ `google_map_create`, `google_map_rip`, `google_map_review`)  
  - Ví dụ sai: `platform=google_map` (không tồn tại platform này nên trả về mảng rỗng)
- `status` (optional): Lọc theo trạng thái (active, slow, stopped)
- `is_active` (optional): Lọc theo trạng thái active (true/false)
- `page` (optional): Số trang (mặc định: 1)
- `per_page` (optional): Số items mỗi trang (mặc định: 20)

**Ví dụ:**
```http
# Lấy tất cả servers của platform Facebook
GET /api/admin/servers?platform=facebook&page=1&per_page=10

# Lấy tất cả servers của platform YouTube
GET /api/admin/servers?platform=youtube&page=1&per_page=10

# Lấy tất cả servers của platform Google (Google Maps)
GET /api/admin/servers?platform=google&page=1&per_page=10

# Lấy servers theo service_id (như cũ)
GET /api/admin/servers?service_id=18&page=1&per_page=10

# Kết hợp platform với các filter khác
GET /api/admin/servers?platform=facebook&status=active&is_active=true&page=1&per_page=10

# Tìm kiếm trong platform
GET /api/admin/servers?platform=facebook&search=Server&status=active
```

**Lưu ý:**
- Nếu truyền cả `service_id` và `platform`, sẽ ưu tiên `service_id` (lấy servers của service cụ thể)
- Nếu chỉ truyền `platform` (không có `service_id`), sẽ lấy tất cả servers của tất cả services thuộc platform đó
- Nếu chỉ truyền `service_id`, sẽ lấy servers của service đó như cũ
- Các platform hỗ trợ: `facebook`, `instagram`, `threads`, `tiktok`, `shopee`, `telegram`, `youtube`, `twitter`, `lazada`, `google`

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
    "notes": "Ghi chú riêng cho server này\n- Được phép dồn số lượng\n- Không hỗ trợ like group\n- Nick like có avatar random",
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

**Lưu ý về field `notes`:**
- `notes` là field text riêng để lưu ghi chú cho từng server
- Mỗi server có thể có ghi chú riêng, không dùng chung
- Frontend có thể hiển thị `notes` khi user chọn server
- Có thể dùng `\n` để xuống dòng trong notes
- Có thể set `null` để xóa notes

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
        "description": "Mô tả server",
        "notes": "Ghi chú riêng cho server này\n- Được phép dồn số lượng\n- Không hỗ trợ like group",
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
    "notes": "Ghi chú riêng cho server này\n- Được phép dồn số lượng\n- Không hỗ trợ like group\n- Nick like có avatar random",
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
    
    // Để xóa notes, gửi:
    // "notes": null
}
```

**Lưu ý về field `notes`:**
- `notes` là field text riêng để lưu ghi chú cho từng server
- Mỗi server có thể có ghi chú riêng, không dùng chung
- Frontend có thể hiển thị `notes` khi user chọn server
- Có thể dùng `\n` để xuống dòng trong notes
- Có thể set `null` để xóa notes
- Khi update, chỉ cần gửi field `notes` để cập nhật, các field khác không cần gửi

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

### Field Notes (Ghi chú riêng cho từng Server)

**Field `notes` là một field text riêng biệt để lưu ghi chú cho từng server.**

**Đặc điểm:**
- Mỗi server có thể có ghi chú riêng, không dùng chung
- Frontend có thể hiển thị `notes` khi user chọn server
- Có thể dùng `\n` để xuống dòng trong notes
- Có thể set `null` để xóa notes

**Ví dụ cập nhật notes:**
```http
PUT /api/admin/servers/{id}
Content-Type: application/json

{
    "notes": "Ghi chú riêng cho server này\n- Được phép dồn số lượng\n- Không hỗ trợ like group\n- Nick like có avatar random"
}
```

**Response khi lấy server:**
```json
{
    "id": 1,
    "name": "Server 6",
    "code": "S6",
    "description": "Like Việt. Ngừng nhận đơn",
    "notes": "Ghi chú riêng cho server này\n- Được phép dồn số lượng\n- Không hỗ trợ like group",
    "price_per_unit": "30.10",
    ...
}
```

**Frontend có thể hiển thị:**
- Khi user chọn server, hiển thị `notes` trong một box riêng
- Có thể format `\n` thành `<br>` hoặc dùng `<pre>` để hiển thị đúng format
- Nếu `notes` là `null` hoặc rỗng, có thể ẩn phần hiển thị notes

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
- `member_group` - Tăng member group
- `review_fanpage` - Đánh giá 5* fanpage
- `checkin_fanpage` - Check-in fanpage
- `event_facebook` - Sự kiện Facebook
- `vip_like_monthly` - VIP Like theo tháng
- `vip_like_group_monthly` - VIP Like group theo tháng
- `vip_comment_monthly` - VIP Comment theo tháng
- `vip_eye_monthly` - VIP Mắt theo tháng
- `vip_view_monthly` - VIP View theo tháng
- `vip_share_monthly` - VIP Share theo tháng
- `eye_live_view_video` - Mắt lives - View video
- `friend_cleanup` - Lọc bạn bè không tương tác
- `instagram_like` - Like Instagram
- `instagram_comment` - Comment Instagram
- `instagram_follow` - Follow Instagram
- `instagram_view` - View Instagram
- `instagram_live_eye` - Mắt livestream Instagram
- `instagram_vip_like` - VIP Like Instagram
- `instagram_vip_comment` - VIP Comment Instagram
- `threads_like` - Like Threads
- `threads_follow` - Follow Threads
- `tiktok_like` - Like TikTok
- `tiktok_like_comment` - Like Comment TikTok
- `tiktok_follow` - Follow TikTok
- `tiktok_view` - View TikTok
- `tiktok_comment` - Comment TikTok
- `tiktok_share` - Share TikTok
- `tiktok_save` - Save (Yêu thích) TikTok
- `tiktok_live_like` - Tim Livestream TikTok
- `tiktok_live_share` - Share Livestream TikTok
- `tiktok_live_comment` - Comment Livestream TikTok
- `tiktok_live_eye` - Mắt Livestream TikTok
- `tiktok_live_pk` - PK Livestream TikTok
- `tiktok_vip_like` - VIP Love TikTok (theo tháng)
- `tiktok_vip_view` - VIP View TikTok (theo tháng)
- `shopee_follow` - Follow Shopee
- `shopee_love` - Love Shopee
- `shopee_like_review` - Like Review Shopee
- `shopee_live_eye` - Mắt livestream Shopee
- `telegram_member_sub` - Member & Sub Telegram
- `telegram_post_view` - View bài viết Telegram
- `telegram_post_reaction` - Cảm xúc bài viết Telegram
- `youtube_like` - Like Youtube
- `youtube_view` - View Youtube
- `youtube_view_400h` - View Youtube (400H)
- `youtube_live_stream` - Live Stream Youtube
- `youtube_like_400h` - Like Youtube (400H)
- `youtube_comment` - Comment Youtube
- `youtube_like_comment` - Like Comment Youtube
- `youtube_subscribe` - Subscribe Youtube
- `twitter_like` - Like Twitter
- `twitter_follow` - Follow Twitter
- `twitter_view` - View Twitter
- `twitter_retweet` - ReTweet Twitter
- `twitter_comment` - Comment Twitter
- `twitter_live_stream` - Livestream Twitter
- `twitter_vip_like` - VIP Like Twitter
- `twitter_vip_view` - VIP View Twitter
- `lazada_sub` - Sub Lazada
- `google_map_create` - Tạo Google Maps
- `google_map_rip` - RIP Google Maps
- `google_map_review` - Review 5* Google Maps
- `unlock_facebook` - Dịch vụ mở khóa Facebook
- `fanpage_rename` - Đổi tên Fanpage
- `fanpage_appeal` - Kháng gậy Fanpage
- `fanpage_care` - Nuôi thuê Fanpage
- `fanpage_big_like` - Tăng Like Fanpage số lượng lớn

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

## Danh sách dịch vụ & server (chi tiết cho Frontend)

Dưới đây là dữ liệu tham chiếu để FE hiển thị lựa chọn dịch vụ/server, giá và min/max. Giá đã seed sẵn trong DB (đơn vị: ₫/mỗi tương tác).

### I. DV MỞ KHÓA MXH (Menu cấp 1)

#### 1. Mở khóa FB (Menu cấp 2)

- Service: **Mở khóa FB** (`unlock_facebook`, slug: `unlock-facebook`) – thuộc platform `facebook`.
- Có thể lấy qua:
  - Public: `GET /api/services?category=unlock_facebook`
  - Admin services: `GET /api/admin/services?category=unlock_facebook`
  - Admin servers: `GET /api/admin/servers?service_id={id_service_mo_khoa_fb}`

- Trường cần nhập chung cho tất cả server:
  - `uid` (Link Facebook bị hack/khoá) *
  - `old_account` (Tài khoản và mật khẩu cũ - nếu có)
  - `old_gmail` (Gmail và mật khẩu cũ - nếu có)
  - `cccd_front` (Link ảnh CCCD mặt trước hoặc gửi qua Zalo)
  - `zalo_phone` (Số điện thoại Zalo liên hệ)
  - `note` (Ghi chú)
- **Lưu ý chung:**
  - Cần thiết bị chính chủ (thiết bị thường xuyên đăng nhập Facebook nếu có)
  - Giá có thể thay đổi tuỳ theo từng trường hợp; mọi thay đổi về giá sẽ cần sự đồng ý của bạn trước khi tiến hành

**Servers:**

- **Check pass lấy lại mật khẩu**
  - Giá: **840.000 ₫** – Hoạt động  
  - Mô tả: Check pass, lấy lại mật khẩu tài khoản Facebook  
  - Demo: `https://s3.ap-northeast-1.amazonaws.com/h.files/images/1740813399560_cbjjBXyhK6.jpeg`

- **Đi cổng support kéo ALL dạng FAQ**
  - Giá: **26.400.000 ₫** – Hoạt động  
  - Mô tả: Đi cổng support, kéo ALL dạng FAQ (trường hợp phức tạp, cao cấp)  
  - Demo: `https://s3.ap-northeast-1.amazonaws.com/h.files/images/1712734073388_XOMDcyN5Xz.jpg`

- **Gỡ mail lạ Auth Meta liên kết FB**
  - Giá: **1.200.000 ₫** – Bảo trì  
  - Mô tả: Gỡ mail lạ/Auth Meta đang liên kết với tài khoản Facebook  
  - Demo: (chưa có hoặc cập nhật sau)

- **Tắt khiên bảo vệ tài khoản**
  - Giá: **1.200.000 ₫** – Hoạt động  
  - Mô tả: Tắt khiên bảo vệ (shield) của tài khoản Facebook  
  - Demo: `https://s3.ap-northeast-1.amazonaws.com/h.files/images/1740813732394_OVbY5FHY8H.jpg`

- **Phá trình tạo mã 2FA**
  - Giá: **480.000 ₫** – Hoạt động  
  - Mô tả: Phá/truy cập lại khi bị chặn bởi trình tạo mã 2FA  
  - Demo: `https://s3.ap-northeast-1.amazonaws.com/h.files/images/1740813892004_nBQo96SxrO.jpg`

- **Mở khoá FB khoá dạng 282**
  - Giá: **1.800.000 ₫** – Hoạt động  
  - Mô tả: Xử lý các tài khoản bị khoá dạng 282  

### II. Dịch vụ Fanpage

#### 2.1 Đổi tên Fanpage

- Service: **Đổi tên Fanpage** (`fanpage_rename`, slug: `fanpage-rename`) – thuộc platform `facebook`.
- Có thể lấy qua:
  - Public: `GET /api/services?category=fanpage_rename`
  - Admin services: `GET /api/admin/services?category=fanpage_rename`
  - Admin servers: `GET /api/admin/servers?service_id={id_service_doi_ten_fanpage}`

- Trường cần nhập:
  - `uid` (Link Fanpage) *
  - `old_name` (Tên cũ) *
  - `new_name` (Tên mới) *
  - `zalo_phone` (SDT Zalo liên hệ)
  - `note` (Ghi chú)

- **Yêu cầu:**
  - Fanpage chưa spam
  - Không được đổi tên trong vòng 60 ngày gần nhất
  - Cần thêm Quản trị viên Fanpage cho nick phụ: `https://www.facebook.com/setpagesieudiinh` (tên: **Syed Zainullah**)

- Servers:
  - **FANPAGE_RENAME_S1** – 240.000 ₫, `status=active`  
    - Đổi tên Fanpage theo yêu cầu, thời gian xử lý khoảng 5 phút nếu đủ điều kiện.

#### 2.2 Kháng gậy Fanpage

- Service: **Kháng gậy Fanpage** (`fanpage_appeal`, slug: `fanpage-appeal`)
- Trường cần nhập:
  - `uid` (Link Fanpage)
  - `contact_info` (Thông tin liên hệ)
  - `zalo_phone` (SDT Zalo liên hệ)
  - `note` (Ghi chú)

- Servers:
  - **FANPAGE_APPEAL_META** – 21.600.000 ₫, `status=active`  
    - Kháng Fanpage bị gậy (đi cổng Meta)  
    - Cần set QTV BM để đi cổng  
    - Tỉ lệ xanh page 100%

  - **FANPAGE_APPEAL_BRAND_FAKE** – 4.800.000 ₫, `status=stopped` (Bảo trì)  
    - Kháng Fanpage bị gậy thương hiệu và hàng giả

  - **FANPAGE_APPEAL_IMPERSONATION** – 600.000 ₫, `status=active`  
    - Kháng Fanpage bị mạo danh  
    - Cần acc quản trị viên, tỉ lệ về ~90%  
    - Nếu fanpage đã bấm và treo, giá sẽ được điều chỉnh và thông báo lại.

#### 2.3 Dv Nuôi Thuê Fanpage

- Service: **Nuôi thuê Fanpage** (`fanpage_care`, slug: `fanpage-care`)
- Trường cần nhập:
  - `uid` (Link Fanpage) *
  - `duration_months` (Thời gian cần mua – số tháng)
  - `zalo_phone` (SDT Zalo liên hệ)
  - `note` (Ghi chú)

- Gói dịch vụ (servers):
  - **FANPAGE_CARE_16** – 600.000 ₫, `status=active`  
    - 16 bài viết + hình ảnh/tháng  
    - Đăng bài đều đặn (4 bài/tuần)  
    - Thiết kế hình ảnh sản phẩm  
    - Tối ưu Fanpage cơ bản

  - **FANPAGE_CARE_32** – 1.200.000 ₫, `status=active`  
    - 32 bài viết + hình ảnh/tháng  
    - Đăng bài đều đặn (8 bài/tuần)  
    - Thiết kế hình ảnh sản phẩm  
    - Tối ưu Fanpage cơ bản

  - **FANPAGE_CARE_60** – 2.280.000 ₫, `status=active`  
    - 60 bài viết + hình ảnh/tháng  
    - Đăng bài đều đặn tuỳ ý khách  
    - Thiết kế hình ảnh cơ bản  
    - Tối ưu Fanpage

#### 2.4 Tăng Like page SL lớn

- Service: **Tăng Like Fanpage SL lớn** (`fanpage_big_like`, slug: `fanpage-big-like`)
- Trường cần nhập:
  - `uid` (Link Fanpage hoặc profile) *
  - `quantity` (Số lượng like muốn mua – tối thiểu 300.000)
  - `zalo_phone` (SDT Zalo liên hệ)
  - `note` (Ghi chú)

- **Lưu ý:**
  - Số lượng từ **300.000 like** trở lên  
  - Giá tiền = **Số lượng muốn mua × rate (19.2 ₫/like)**  
  - Ví dụ: 300.000 like ≈ 5.760.000 ₫  
  - Thời gian hoàn thành: khoảng **3 ngày**  
  - Tăng được cho **fanpage** và **sub cá nhân**

- Servers:
  - **FANPAGE_BIGLIKE_S1** – rate 19.2 ₫/like, `status=active`, `min_quantity=300000`  
    - Tăng Like Fanpage số lượng lớn, thời gian hoàn thành khoảng 3 ngày.

y đơn  
    - Không hỗ trợ like group, nick like có avatar random
  - **S15**: 43.9 ₫, `status=active`, min 50, max 100,000  ### 1. Like bài viết Speed (`like_post_speed`, slug: `like-post-speed`)
- Trường cần nhập:
  - `uid` (ID hoặc link bài viết cần chạy)
  - `server_code` (Chọn server)
  - `emotions` (Chọn loại cảm xúc – cho phép chọn **nhiều loại cảm xúc** dạng checkbox: like/love/haha/wow/sad/angry)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user từ `price_per_unit` của server)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- **Lưu ý chung:**
  - Một số server **cho phép dồn đơn** (ví dụ: mua 10k có thể mua 5 lần 2k cùng 1 lúc để chạy nhanh hơn)
  - Một số server **cho phép mua nhiều cảm xúc cùng lúc**, số lượng sẽ được phân chia ngẫu nhiên; nếu Facebook quét và tỉ lệ chủ yếu là Like thì nên tách riêng từng cảm xúc để đạt đúng số lượng mong muốn
  - Các server có ghi chú sẽ **không hỗ trợ like bài video trong album** (server sẽ nhảy like lên bài album)
  - Các server có ghi chú sẽ **không hỗ trợ cảm xúc cho bài reels** (cố tình mua sẽ tính hoàn gói, không hoàn tiền)

- Servers:
  - **S6**: 30.1 ₫, `status=stopped`, min 50, max 200,000  
    - Like Việt – Ngừng nhận đơn (ID: 475352)  
    - Được phép dồn số lượng (mua 10k có thể mua 5 lần 2k cùng lúc)  
    - Hỗ trợ mua cùng lúc nhiều cảm xúc, số lượng sẽ phân chia ngẫu nhiên; nếu FB quét tỉ lệ chủ yếu là Like, nên chọn riêng cảm xúc để đạt số lượng mong muốn  
    - Không hỗ trợ like bài video trong album (server sẽ nhảy like lên bài album)  
    - Không hỗ trợ cảm xúc cho bài reels (cố tình mua sẽ hoàn gói, không hoàn tiền)
  - **S1**: 16.3 ₫, `status=stopped`, min 50, max 10,000  
    - Like Việt, tốc độ chậm – Ngừng nhận đơn
  - **S3**: 28.7 ₫, `status=active`, min 50, max 10,000  
    - Like Việt, tốc độ chậm (ID: 475288)  
    - Đơn giá cảm xúc khác (love/haha/…) **đắt hơn** so với Like  
    - Không hỗ trợ like group  
    - Nick like có avatar random
  - **S5**: 18.4 ₫, `status=active`, min 50, max 10,000  
    - Like Việt, tốc độ trung bình (ID: 475489)  
    - Không hỗ trợ huỷ gói; không nên mua link video dễ bị ẩn/hủ
    - Like Việt (ID: 475581)  
    - Được phép dồn số lượng (mua 10k có thể mua 5 lần 2k cùng lúc)  
    - Hỗ trợ mua cùng lúc nhiều cảm xúc, số lượng phân chia ngẫu nhiên; nếu FB quét tỉ lệ chủ yếu là Like, nên chọn riêng cảm xúc  
    - Không hỗ trợ like bài video trong album; không hỗ trợ cảm xúc cho reels (cố tình mua sẽ hoàn gói, không hoàn tiền)
  - **S16**: 71.5 ₫, `status=active`, min 50, max 100,000  
    - Like Việt (ID: 475582)  
    - Được phép dồn số lượng (mua 10k có thể mua 5 lần 2k cùng lúc)  
    - Hỗ trợ mua cùng lúc nhiều cảm xúc, số lượng phân chia ngẫu nhiên; nếu FB quét tỉ lệ chủ yếu là Like, nên chọn riêng cảm xúc  
    - Không hỗ trợ like bài video trong album; không hỗ trợ cảm xúc cho reels (cố tình mua sẽ hoàn gói, không hoàn tiền)

### 1.2 Like bài viết VIP (`like_post_vip`, slug: `like-post-vip`)
- Trường cần nhập:
  - `uid` (ID hoặc link bài viết cần chạy)
  - `server_code` (Chọn server)
  - `emotion` (Chọn loại cảm xúc – **chỉ cho phép chọn 1 loại cảm xúc**: like/love/haha/wow/sad/angry)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 1**: 66.2 ₫, `status=active`, min 20, max 5,000
    - Tăng chậm (ID: 475271)

### 1.3 Sub cá nhân & Fanpage (`sub_personal_fanpage`, slug: `sub-personal-fanpage`)
- Trường cần nhập:
  - `uid` (ID hoặc link tài khoản cần tăng sub)
  - `account_name` (Tên tài khoản)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- **Lưu ý:** Đọc kĩ trước khi chọn gói, tốc độ ở mỗi gói mang tính chất tham khảo.

- Servers:
  - **Server 3**: 48 ₫, `status=active`, min 500, max 40,000
    - Sub Tên Việt Nam, tốc độ 5k /1 ngày, bảo hành 7 ngày (ID: 475536)
    - Hỗ trợ sub cá nhân và sub fanpage
  - **Server 4**: 34.1 ₫, `status=active`, min 100, max 50,000
    - Sub Tên Việt Nam, tốc độ 3k/1 ngày, bảo hành 7 ngày (ID: 475375)
    - Hỗ trợ sub trang cá nhân và sub fanpage
    - Tài nguyên tối đa cho 1 uid là 100.000 sub
  - **Server 6**: 41.4 ₫, `status=active`, min 100, max 1,000,000
    - Sub Tây, tốc độ 100k /1 ngày, bảo hành 7 ngày (ID: 475292)
    - Hỗ trợ sub trang cá nhân và sub fanpage
    - Sub tài nguyên beta+ via
  - **Server 7**: 34.4 ₫, `status=active`, min 500, max 100,000
    - Sub Tây, tốc độ 50k / 1 ngày, bảo hành 7 ngày (ID: 475538)
    - Hỗ trợ sub trang cá nhân và sub fanpage
    - Sub tài nguyên beta+ via
    - 1 đơn chỉ hỗ trợ mua tối đa 3 lần
  - **Server 8**: 18.6 ₫, `status=active`, min 200, max 10,000
    - Sub Tây, tốc độ 30k / 1 ngày, bảo hành 7 ngày (ID: 475371)
    - Hỗ trợ sub trang cá nhân và sub fanpage
    - Bảo hành 7 ngày
  - **Server 11**: 29.7 ₫, `status=stopped`, min 100, max 40,000
    - Sub Việt Nam, tốc độ 5k / 1 ngày, bảo hành 7 ngày – Ngừng nhận đơn
  - **Server 12**: 58 ₫, `status=stopped`, min 100, max 40,000
    - Sub Việt Nam, tốc độ 10k/ 1 ngày, bảo hành 7 ngày – Ngừng nhận đơn
  - **Server 15**: 75.6 ₫, `status=stopped`, min 100, max 40,000
    - Sub Việt Nam, tốc độ 30k / 1 ngày, bảo hành 7 ngày – Ngừng nhận đơn

### 1.4 Like Fanpage (`like_fanpage`, slug: `like-fanpage`)
- Trường cần nhập:
  - `uid` (ID hoặc link page cần tăng)
  - `account_name` (Tên tài khoản)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 2**: 39.5 ₫, `status=active`, min 100, max 20,000
    - Like Ngoại, tốc độ 10k/ 1 ngày. Bảo hành 7 ngày (ID: 475543)
    - Hỗ trợ tất cả fanpage có nút like
  - **Server 4**: 60.4 ₫, `status=active`, min 200, max 1,000,000
    - Like Việt Nam, tốc độ 5k/ 1 ngày. Bảo hành 7 ngày (ID: 475500)
    - FanPage cần có nút like
  - **Server 5**: 43.9 ₫, `status=active`, min 1,000, max 40,000
    - Like tên Việt Nam, tốc độ 20k / 1 ngày. Bảo hành 7 ngày (ID: 475544)
    - Phần lớn là sub beta
    - Tốc độ thường lên khá tốt, không hỗ trợ huỷ gói khi chạy
  - **Server 10**: 66.2 ₫, `status=active`, min 200, max 10,000
    - Like Việt Nam, tốc độ 5k/ 1 ngày. Bảo hành 7 ngày (ID: 475547)
    - Tài nguyên phần lớn là Via nick Việt Nam
    - FanPage cần có nút like
    - Không hỗ trợ dồn đơn
  - **Server 11**: 37.3 ₫, `status=active`, min 100, max 50,000
    - Like Việt Nam, tốc độ 3k / 1 ngày. Không bảo hành (ID: 475548)
    - Tài nguyên là via và beta
    - Fanpage cần có nút like
    - Gói có thể dồn đơn, bạn có thể mua 5 lần 2k liên tiếp để đạt 10k nhanh nhất
    - **Lưu ý:** Done thiếu ~20%, ví dụ mua 20k sẽ nhận 16k like
  - **Server 12**: 58 ₫, `status=active`, min 100, max 50,000
    - Like Việt Nam, tốc độ 5k/ 1 ngày. Không bảo hành (ID: 475549)
    - Tài nguyên là via và beta
    - Fanpage cần có nút like
    - Gói có thể dồn đơn, bạn có thể mua 5 lần 2k liên tiếp để đạt 10k nhanh nhất
    - **Lưu ý:** Done thiếu ~20%, ví dụ mua 20k sẽ nhận 16k like
  - **Server 15**: 75.6 ₫, `status=active`, min 50, max 50,000
    - Like Việt Nam, tốc độ 20k/ 1 ngày. Không bảo hành (ID: 475579)
    - Tài nguyên là via và beta
    - Fanpage cần có nút like
    - Gói có thể dồn đơn, bạn có thể mua 5 lần 2k liên tiếp để đạt 10k nhanh nhất
    - **Lưu ý:** Done thiếu ~20%, ví dụ mua 20k sẽ nhận 16k like

### 1.5 Like cho Bình luận (`like_comment`, slug: `like-comment`)
- Trường cần nhập:
  - `uid` (ID hoặc link đối tượng)
  - `server_code` (Chọn server)
  - `emotions` (Chọn loại cảm xúc – **Server 3 cho phép chọn nhiều cảm xúc cùng lúc**, còn server còn lại thì chỉ cho chọn 1 loại cảm xúc: like/love/haha/wow/sad/angry)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 3**: 58 ₫, `status=active`, min 50, max 50,000
    - Like việt (ID: 475412)
    - Hỗ trợ dồn đơn
    - **Cho phép chọn nhiều cảm xúc cùng lúc**
  - **Server 4**: 31.5 ₫, `status=slow`, min 50, max 10,000
    - Like việt (ID: 475558)
    - Không được dồn đơn, sẽ bị chậm
    - **Chỉ cho phép chọn 1 loại cảm xúc**
  - **Server 5**: 81.4 ₫, `status=active`, min 50, max 20,000
    - Tốc độ tốt (ID: 475587)
    - Hỗ trợ dồn đơn
    - **Chỉ cho phép chọn 1 loại cảm xúc**

### 1.6 Tăng bình luận (`increase_comment`, slug: `increase-comment`)
- Trường cần nhập:
  - `uid` (ID hoặc link bài viết cần chạy)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `content` (Danh sách nội dung – mỗi bình luận là 1 dòng, tối thiểu 5 bình luận)
  - `price_per_unit` (Giá tiền mỗi bình luận – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 5**: 676.2 ₫, `status=active`, min 10, max 500
    - Việt Nam. Tốc độ nhanh (ID: 475307)
    - Có hỗ trợ LIVESTREAM
    - Không hỗ trợ các nội dung lừa đảo, vi phạm chính trị, đạo đức v.v
  - **Server 6**: 483 ₫, `status=active`, min 10, max 20
    - Việt Nam. Tốc độ ổn (ID: 475572)
    - Không hỗ trợ livestream
    - Không hỗ trợ các nội dung lừa đảo, vi phạm chính trị, đạo đức v.v
    - Nội dung thường bị ẩn sau vài ngày
  - **Server 7**: 676.2 ₫, `status=active`, min 5, max 1,000
    - Việt Nam. Tốc độ trung bình (ID: 475597)
    - Có hỗ trợ livestream nếu đơn hàng hoạt động tốt. Tối đa 100 cmt/ 1 lần mua
    - Nếu lên chậm trong livestream vui lòng thông cảm, đơn sẽ không hoàn tiền
    - Không hỗ trợ các nội dung lừa đảo, vi phạm chính trị, đạo đức v.v
  - **Server 8**: 9,660 ₫, `status=maintenance`
    - Nick tích xanh Tên Việt Nam – Bảo trì
  - **Server 9**: 331.2 ₫, `status=active`, min 30, max 200,000
    - Bình luận ẩn. (dư bình luận cao) (ID: 485672)
    - Chỉ hiển thị số lượng bình luận, không hiển thị nội dung (có dư bình luận nhiều)
    - Có thể bỏ trống mục nội dung (chỉ cần nhập số lượng bình luận)
    - Tốc độ siêu cao 200k bình luận /1 ngày

### 1.7 Chia sẻ bài viết (`share_post`, slug: `share-post`)
- Trường cần nhập:
  - `uid` (ID hoặc link bài viết cần chạy)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- **Share việt:**
  - **Server 2**: 317.4 ₫, `status=active`, min 20, max 10,000
    - Chia sẻ việt, tốc độ nhanh (ID: 475345)
    - Hỗ trợ tất cả các link trên nền tảng FB
  - **Server 6**: 400.2 ₫, `status=active`, min 20, max 10,000
    - Share việt, tốc độ siêu tốc (ID: 475388)
    - Tốc độ chạy rất nhanh
  - **Server 7**: 414 ₫, `status=slow`, min 5, max 1,000
    - Kèm nội dung khi share (ID: 475443)
    - Nội dung ngắn gọn, không hỗ trợ share cho bài gr
    - Không vi phạm pháp luật, chửi bới, bôi xấu người khác, lừa đảo. Vi phạm hủy gói không hoàn tiền

- **Share ảo:**
  - **Server 5**: 27.6 ₫, `status=active`, min 1,000, max 100,000,000
    - Share ảo [Lên Siêu Tốc - hỗ trợ tất cả link fb] (ID: 475361)
    - Share ảo [max. 100 triệu share]
    - Hỗ Trợ Tất Cả Các Link
    - Các đơn cần chạy gấp, cuộc đua, vote thì inbox trước cho admin để ưu tiên chạy trước. Thời gian chạy 9h-24h mỗi ngày

### 1.8 Tăng member group (`member_group`, slug: `member-group`)
- Trường cần nhập:
  - `uid` (Link nhóm cần tăng)
  - `account_name` (Tên nhóm cần tăng)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 2**: 40 ₫, `status=active`, min 100, max 200,000
    - Member beta, Tên Việt Nam (ID: 475297)
    - Không hỗ trợ group riêng tư
    - Yêu cầu bật cho fanpage tham gia
  - **Server 3**: 49.1 ₫, `status=active`, min 1,000, max 30,000
    - Member beta, Tên Việt Nam [30k / 24 giờ.] (ID: 475298)
    - Không hỗ trợ group riêng tư
    - Yêu cầu bật cho fanpage tham gia
  - **Server 4**: 16.6 ₫, `status=stopped`, min 100, max 30,000
    - Fb Via tên Việt Nam [5k-10k/ 24 giờ.] – Ngừng nhận đơn
  - **Server 5**: 47.6 ₫, `status=active`, min 100, max 30,000
    - Fb Via tên Việt Nam [5k/ 24 giờ.] (ID: 475516)
    - Có thể mua dồn đơn để lên nhanh
    - Ví dụ: mua 5 lần 1k thì chạy đồng loạt 5 đơn
  - **Server 6**: 17.9 ₫, `status=active`, min 500, max 100,000
    - Member Beta ngoại [20k / 24 giờ] (ID: 475422)
    - Không hỗ trợ group riêng tư
    - Yêu cầu bật cho fanpage tham gia
    - Không được mua dồn đơn, sẽ bị mất tiền
  - **Server 15**: 71.5 ₫, `status=active`, min 50, max 50,000
    - Fb Via tên Việt Nam [10k / 24 giờ.] (ID: 475574)
    - Có thể mua dồn đơn để lên nhanh
    - Ví dụ: mua 5 lần 1k thì chạy đồng loạt 5 đơn

### 1.9 Share Livestream Group (`share_live_group`, slug: `share-live-group`)
- Trường cần nhập:
  - `uid` (Link cần share group)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 1**: 345 ₫, `status=active`, min 100, max 20,000
    - Rẻ (ID: 475268)
    - Không share bài chứa link liên kết
    - Không nhận share bài viết, ảnh… chỉ nhận share livestream
    - Nên mua từ thời gian: 9h-23h
  - **Server 2**: 552 ₫, `status=stopped`, min 100, max 20,000
    - Lên ổn – Ngừng nhận đơn

### 1.10 Đánh giá 5* Fanpage (`review_fanpage`, slug: `review-fanpage`)
- Trường cần nhập:
  - `uid` (ID hoặc link cần chạy)
  - `account_name` (Tên tài khoản)
  - `server_code` (Chọn server)
  - `content` (Danh sách các nội dung – mỗi review 1 dòng, tối thiểu 5 dòng)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 5**: 1,587 ₫, `status=active`, min 10, max 500
    - Via việt. Chất lượng tốt (Yêu cầu có tối thiểu 1 đánh giá) (ID: 475598)
    - Hãy kiểm tra bật đánh giá và có tối thiểu 1 đánh giá, không hỗ trợ hủy gói
    - Tài nguyên tối đa cho 1 page là 500, tuyệt đối không dồn đơn mua liên tiếp

### 1.11 Check in fanpage (`checkin_fanpage`, slug: `checkin-fanpage`)
- Trường cần nhập:
  - `uid` (ID hoặc link cần chạy)
  - `account_name` (Tên tài khoản)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi Checkin – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Server 2**: 662.4 ₫, `status=stopped`
    - Lên nhanh - Bảo hành 30 ngày. Bảo trì

### 1.12 Sự kiện event facebook (`event_facebook`, slug: `event-facebook`)
- Trường cần nhập:
  - `uid` (Link hoặc UID sự kiện)
  - `server_code` (Chọn server)
  - `quantity` (Số lượng)
  - `price_per_unit` (Giá tiền mỗi tương tác – tự tính cho user)
  - `note` (Ghi chú)
- **Tổng Giá:** `price_per_unit * quantity` (tự tính cho user)

- Servers:
  - **Quan tâm event**: 441.6 ₫, `status=stopped`, min 100, max 50,000
    - Bảo trì (ID: 475512)
    - Không hỗ trợ hủy gói, thời gian tăng có thể mất 1-2 ngày
    - Người tham gia nước ngoài
  - **Tham gia event**: 441.6 ₫, `status=stopped`, min 100, max 50,000
    - Bảo trì

### 12. VIP Like theo tháng (`vip_like_monthly`, slug: `vip-like-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, `account_name`, chọn gói VIP, thời gian, `note` (FE thêm các option gói/thời gian)
- Servers:
  - VIPL_S9: Like Việt 1,260 ₫, active, thời gian 7h-23h, giới hạn 5 bài/ngày, lên 5-30p
  - VIPL_S10: Like Việt tốt nhất 2,520 ₫, active
  - VIPL_S11: Like Việt 1,764 ₫, active

### 13. VIP Like group theo tháng (`vip_like_group_monthly`, slug: `vip-like-group-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, `account_name`, chọn gói VIP, thời gian, tùy chọn số bài mỗi ngày, `note`
- Servers:
  - VIPLG_S1: Like Via Việt tốc độ chậm 1,308 ₫, stopped
  - VIPLG_S2: Like Via Việt tốc độ tốt 2,340 ₫, stopped

### 14. VIP Comment theo tháng (`vip_comment_monthly`, slug: `vip-comment-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, `account_name`, chọn gói VIP, thời gian, số bài mỗi ngày, `content` (tối đa 100 cmt/lần, min/max 10/100), `note`
- Servers:
  - VIPC_S5: Việt Nam, tốc độ nhanh, 24,000 ₫, active, min 10, max 100

### 15. VIP Mắt theo tháng (`vip_eye_monthly`, slug: `vip-eye-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, số lượng mắt (50-5000), thời gian, số phút mắt, số bài/tháng, giá/mắt/phút, `note`
- Servers:
  - VIPEYE_S2: 3.1 ₫, active, min 50, max 5000

### 16. VIP View theo tháng (`vip_view_monthly`, slug: `vip-view-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, số lượng xem, tốc độ (bình thường/nhanh), loại view (ví dụ xem 3s), tối đa video/ngày, thời gian, `note`
- Servers:
  - VIPV_S1: 14.4 ₫, stopped, view 3s, tối đa 6 video/ngày (giá x1)

### 17. VIP Share theo tháng (`vip_share_monthly`, slug: `vip-share-monthly`)
- Trường cần nhập: `uid` hoặc link tài khoản, số bài mỗi ngày (tuỳ chọn), chọn gói VIP, thời gian, `note`
- Servers:
  - VIPS_S2: Share Việt 13,200 ₫, active, không hoàn tiền kể cả uid die

### 18. Buff mắt Livestream V2 (`eye_live_view_video`, slug: `buff-mat-livestream-v2`)
- Trường cần nhập: `uid` (link chứa từ “Videos”), `quantity`, `note`, chọn server, chọn số phút (đơn giá thay đổi theo phút); Giá Tiền Mỗi Tương Tác; Tổng Giá
- Servers:
  - LIVEV2_S4: 79.2 ₫, active, min 50, max 1000; mô tả: Máy chủ 518398 - mắt xem livestream ~30 phút. Tùy chọn phút: 30p (79.2₫, id 518398), 60p (158.4₫, id 518399), 90p (237.6₫, id 518400), 120p (316.8₫, id 518401), 150p (396₫, id 518402), 180p (475.2₫, id 518403), 210p (554.4₫, id 518404), 240p (633.6₫, id 518405). Gói mắt tự do: id 475409 giá 2.6₫.
  - LIVEV2_S6: 79.2 ₫, active, min 50, max 1000; mô tả: Máy chủ 518398 - mắt xem livestream ~30 phút. Tùy chọn phút: 30p (90₫, id 518406), 60p (180₫, id 518407), 90p (270₫, id 518408), 120p (360₫, id 518409), 150p (450₫, id 518410), 180p (540₫, id 518411), 210p (630₫, id 518412), 240p (720₫, id 518413). Gói mắt tự do: id 475454 giá 3₫.

### 19. Tăng View video (`eye_live_view_video`, slug: `tang-view-video`)
- Trường cần nhập: `uid` (link video), `quantity` (min 500), `note`
- Servers:
  - VIEW_S4: 10.2 ₫, active, min 500, max 5,000,000; auto play nếu video bị ẩn view; video <1 phút sẽ chậm
  - VIEW_S7: 13.2 ₫, active, min 500, max 5,000,000; tốc độ ổn, ưu tiên đơn lớn

### 20. Tăng View Story (`eye_live_view_video`, slug: `tang-view-story`)
- Trường cần nhập: `uid` (link story), `quantity` (min 200), `note`
- Servers:
  - STORY_S2: 24 ₫, active, min 200, max 20,000; không mua trùng khi view chưa đủ; nên mua ngay sau khi đăng
  - STORY_S3: 57.4 ₫, active, min 200, max 20,000; tốc độ tốt

### 21. View 600k phút (`eye_live_view_video`, slug: `view-600k-phut`)
- Trường cần nhập: `uid` (video ≥60 phút), `Độ dài video` (1 giờ / 2 giờ / 3 giờ), `note`
- Servers:
  - VIEW600K: 300,000 ₫, active, min 1, max 1; gói 600k phút, thường hoàn thành 1-2 ngày

### 22. View 60K offline (`eye_live_view_video`, slug: `view-60k-offline`)
- Trường cần nhập: `uid` (video ≥3h + 3s), `Độ dài video` (1 giờ / 2 giờ / 3 giờ), `note`
- Servers:
  - OFF60K_S1: 114,000 ₫, active, min 1, max 1; ưu tiên nhanh, hoàn thành trong ngày; còn 1850 đơn
  - OFF60K_S2: 87,600 ₫, active, min 1, max 1; gói thường; còn 1851 đơn

### 23. View 60K Live (`eye_live_view_video`, slug: `view-60k-live`)
- Trường cần nhập: `uid` (video/live ≥3h + 3s), `Độ dài video` (1 giờ / 2 giờ / 3 giờ), `note`
- Servers:
  - LIVE60K_S1: 228,000 ₫, active, min 1, max 1; ưu tiên nhanh, hoàn thành trong ngày; còn 1817 đơn
  - LIVE60K_S2: 138,000 ₫, active, min 1, max 1; gói thường; còn 1897 đơn

### 24. Tăng view 100k Reels (`eye_live_view_video`, slug: `tang-view-100k-reels`)
- Trường cần nhập: `uid` hoặc link reels chính xác, `quantity` (gói = 1), `note`
- Servers:
  - REELS_S1: 600,000 ₫, active, min 1, max 1; lên nhanh; khả dụng hiện 0 đơn
  - REELS_S2: 312,000 ₫, active, min 1, max 1; lên trung bình; khả dụng hiện 0 đơn

### 25. Lọc bạn bè không tương tác (`friend_cleanup`, slug: `loc-ban-be-khong-tuong-tac`)
- Trường cần nhập: `uid` hoặc link người dùng, `account_name`, `note`
- Servers:
  - FRIEND_CLEAN: 15,000 ₫, active, min 1, max 1; lọc bạn bè không tương tác (tài khoản VIP)

### 26. Like Instagram (`instagram_like`, slug: `like-instagram`)
- Trường cần nhập: `uid` hoặc link bài viết (https://www.instagram.com/p/id/), `quantity`, `note`
- Servers:
  - IGLIKE_S1: 27.6 ₫, active, min 100, max 50,000; Like Việt 500/24h (tụt 10-20%)
  - IGLIKE_S2: 25.2 ₫, active, min 100, max 50,000; Like Việt 5k-10k/24h
  - IGLIKE_S4: 13.6 ₫, active, min 100, max 50,000; Like Việt tốc độ trung bình
  - IGLIKE_S5: 8.6 ₫, active, min 100, max 50,000; Like Tây, tốc độ trung bình, không bảo hành
  - IGLIKE_S6: 14.8 ₫, active, min 100, max 50,000; Like Tây, tốc độ tốt, không bảo hành

### 27. Comment Instagram (`instagram_comment`, slug: `comment-instagram`)
- Trường cần nhập: `uid` hoặc link bài viết (https://www.instagram.com/p/id/), `content` (mỗi dòng 1 bình luận), `quantity`, `note`, `speed` (nhanh/cham/trung_binh)
- Servers:
  - IGCMT_S2: 720 ₫, active, min 10, max 10,000; Nick Việt, tốc độ trung bình (ID: 475481)
  - IGCMT_S3: 192 ₫, active, min 10, max 10,000; Nick ngoại

### 28. Follow Instagram (`instagram_follow`, slug: `follow-instagram`)
- Trường cần nhập: `uid` hoặc link profile, `quantity` (cộng dư 15%), `note`
- Servers:
  - IGFOLLOW_S1: 94.8 ₫, stopped, min 100, max 10,000; Sub Việt 500/24h, tụt cao, BH 7 ngày (ID: 475266)
  - IGFOLLOW_S6: 26.4 ₫, active, min 100, max 10,000; Sub Tây 20k/24h, không BH
  - IGFOLLOW_S7: 53.8 ₫, active, min 100, max 10,000; Sub Tây 2k/24h, không BH
  - IGFOLLOW_S8: 106.8 ₫, active, min 100, max 10,000; Sub Tây 5k/24h, không BH
  - IGFOLLOW_S9: 83.4 ₫, active, min 100, max 10,000; Sub Tây 10k/24h, không BH

### 29. View Instagram (`instagram_view`, slug: `view-instagram`)
- Trường cần nhập: `uid` hoặc link video/reel/igtv/story, `quantity`, `note`
- Servers:
  - IGVIEW_S1: 10.6 ₫, active, min 100, max 1,000,000; View Video+REEL+IGTV, tốc độ có thể đạt triệu view/ngày (ID: 475417)
  - IGVIEW_S2: 0.48 ₫, active, min 10,000, max 1,000,000; View Video+REEL+IGTV, min 10k
  - IGVIEW_S3: 2.2 ₫, active, min 100, max 1,000,000; View Video+REEL+IGTV
  - IGVIEW_S5: 4.2 ₫, active, min 100, max 1,000,000; Chỉ hỗ trợ stories 24 giờ

### 30. Mắt Livestream Instagram (`instagram_live_eye`, slug: `mat-livestream-instagram`)
- Trường cần nhập: `uid` hoặc link live/story, `quantity`, `note`
- Servers:
  - IGLIVE_S1: 18.2 ₫, active, min 100, max 1,000,000; Mắt LiveStream 15đ, tốc độ có thể đạt triệu view/ngày (ID: 475416)
  - IGLIVE_S2: 0.84 ₫, active, min 10,000, max 1,000,000; Mắt LiveStream min 10k
  - IGLIVE_S3: 4.4 ₫, active, min 100, max 1,000,000; Mắt LiveStream 12đ
  - IGLIVE_S5: 8.4 ₫, active, min 100, max 1,000,000; Chỉ hỗ trợ stories 24 giờ

### 31. VIP Like Instagram (`instagram_vip_like`, slug: `vip-like-instagram`)
- Trường cần nhập: `uid` hoặc link profile, `quantity` (số like cần mua), `duration` (1/2/3 tháng), `posts_per_day` (tùy chọn), `note`
- Servers:
  - IGVIPLIKE_S1: 900 ₫, active, min 1; Like Việt, không nên ghim bài (ID: 475349)

### 32. VIP Comment Instagram (`instagram_vip_comment`, slug: `vip-comment-instagram`)
- Trường cần nhập: `uid` hoặc link profile, `content` (mỗi dòng 1 bình luận), `package` (10/20/30/40/50/60/70/80/90/100 bình luận), `duration` (1/2/3 tháng), `speed` (nhanh/trung_binh/cham), `posts_per_day` (tùy chọn), `note`
- Servers:
  - IGVIPCMT_S1: 16,680 ₫, active, min 1; Bắt buộc không ghim bài (ID: 475380)

### 33. Like Threads (`threads_like`, slug: `like-threads`)
- Trường cần nhập: `uid` (link bài viết Threads), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự động tính từ `price_per_unit` của server
- Tổng Giá: Tự động tính = `price_per_unit * quantity`
- Servers:
  - THREADS_LIKE_S2: 64.8 ₫, stopped, min 50, max 500,000; Like tây, ổn định, lên khá nhanh (ID: 475517) - Ngừng nhận đơn
  - THREADS_LIKE_S3: 42 ₫, maintenance; Like việt, giá rẻ - Bảo trì

### 34. Follow Threads (`threads_follow`, slug: `follow-threads`)
- Trường cần nhập: `uid` (link bài viết Threads), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự động tính từ `price_per_unit` của server
- Tổng Giá: Tự động tính = `price_per_unit * quantity`
- Servers:
  - THREADS_FOLLOW_S1: 75.6 ₫, stopped, min 100, max 100,000; Sub ngoại, không bảo hành, tốc độ lên nhanh, tỉ lệ tụt thấp (ID: 475505) - Ngừng nhận đơn
  - THREADS_FOLLOW_S2: 40.8 ₫, maintenance; Sub ngoại, không bảo hành - Bảo trì
  - THREADS_FOLLOW_S3: 54 ₫, active; Sub tên Việt, 100-500 /24 giờ - Hoạt động

### 35. Like TikTok (`tiktok_like`, slug: `tiktok-like`)
- Trường cần nhập: `uid` (link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLIKE_S1: 14.4 ₫, active, min 50, max 10k; Like việt 5k/24h, hoàn tiền khi chậm, phù hợp gói <1k, tốc độ rất nhanh, có thể tụt cao (ID: 475278)
  - TIKLIKE_S3: 15 ₫, active, min 50, max 10k; Like việt 5k/24h
  - TIKLIKE_S5: 16.2 ₫, active, min 50, max 10k; Like việt 5k/24h
  - TIKLIKE_S2: 5.8 ₫, active, min 50, max 10k; Like ngoại giá rẻ
  - TIKLIKE_S6: 11.4 ₫, active, min 50, max 10k; Like ngoại tốc độ tốt
  - TIKLIKE_S7: 10.1 ₫, active, min 50, max 10k; Like ngoại
  - TIKLIKE_S8: 16.2 ₫, active, min 50, max 10k; Like ngoại rất nhanh

### 36. Like Comment TikTok (`tiktok_like_comment`, slug: `tiktok-like-comment`)
- Trường cần nhập: `uid` (link bài viết), `account_name` hoặc `profile` của người comment (ví dụ: https://www.tiktok.com/@profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLC_S2: 20.4 ₫, active, min 100, max 10k; Tốc độ nhanh. Username nhiều dấu chấm có thể không nhận diện (ID: 475571)

### 37. Follow TikTok (`tiktok_follow`, slug: `tiktok-follow`)
- Trường cần nhập: `uid` (link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKFOLLOW_S2: 94.8 ₫, active, min 100, max 10k; Sub việt 5k/24h, BH 7 ngày, không hỗ trợ đổi username, có thể tụt (ID: 475590)
  - TIKFOLLOW_S4: 73.2 ₫, slow, min 100, max 10k; Sub việt 300/24h
  - TIKFOLLOW_S5: 28.2 ₫, active, min 100, max 10k; Sub việt 3k/24h, có hiện tượng tụt cao
  - TIKFOLLOW_S6: 40.8 ₫, active, min 100, max 10k; Sub việt 1k/1 ngày, có hiện tượng tụt cao
  - TIKFOLLOW_S3: 45.4 ₫, active, min 100, max 10k; Sub ngoại 5k-10k/24h
  - TIKFOLLOW_S7: 66 ₫, active, min 100, max 10k; Sub ngoại 5k/24h

### 38. View TikTok (`tiktok_view`, slug: `tiktok-view`)
- Trường cần nhập: `uid` (link bài viết), `quantity` (lượt xem), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKVIEW_S3: 0.84 ₫, active, min 1k, max 100k; Ổn định, nên hẹn giờ 10k/đơn cách 12-24h nếu mua nhiều (ID: 475384)
  - TIKVIEW_S4: 0.84 ₫, active, min 1k, max 100k; Ổn định
  - TIKVIEW_S5: 1.1 ₫, active, min 1k, max 100k; Tăng chậm, hạn chế tụt

### 39. Comment TikTok (`tiktok_comment`, slug: `tiktok-comment`)
- Trường cần nhập: `uid` (link bài viết), `content` (danh sách nội dung, mỗi dòng 1 bình luận), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKCMT_S4: 720 ₫, slow, min 10, max 20; Nick việt, tốc độ chậm, cần tối thiểu 1 bình luận (ID: 475477), nội dung có thể bị ẩn/trùng, tắt lọc/kiểm duyệt
  - TIKCMT_S6: 408 ₫, stopped, min 10, max 20; Nick ngoại, tốc độ nhanh (Bảo trì)

### 40. Share TikTok (`tiktok_share`, slug: `tiktok-share`)
- Trường cần nhập: `uid` (link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKSHARE_S1: 16.6 ₫, stopped, min 100, max 50,000,000; BH 30 ngày
  - TIKSHARE_S2: 7 ₫, active, min 100, max 50,000,000; Ổn định, BH 30 ngày, nếu delay có thể chậm; share có thể lên dư (ID: 475414)
  - TIKSHARE_S4: 3.1 ₫, stopped, min 100, max 50,000,000; Giá rẻ nhất

### 41. Save TikTok (`tiktok_save`, slug: `tiktok-save`)
- Trường cần nhập: `uid` (link bài viết/nhóm cần tăng save), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKSAVE_S1: 8.2 ₫, active, min 100, max 1,000,000; Tốc độ tốt, có thể rất nhanh (ID: 475424)
  - TIKSAVE_S2: 9.6 ₫, active, min 100, max 1,000,000; Tốc độ trung bình
  - TIKSAVE_S3: 14.4 ₫, stopped, min 100, max 1,000,000; Ổn định, lên chậm

### 42. Tim Livestream TikTok (`tiktok_live_like`, slug: `tiktok-live-like`)
- Trường cần nhập: `uid` (link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLIVE_LIKE_S1: 10.6 ₫, active, min 500, max 50,000; Tim livestream, tốc độ tốt (ID: 475428)
  - TIKLIVE_LIKE_S3: 6 ₫, stopped, min 500, max 50,000; Tốc độ ổn, Bảo trì

### 43. Share Livestream TikTok (`tiktok_live_share`, slug: `tiktok-live-share`)
- Trường cần nhập: `uid` (link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLIVE_SHARE_S2: 24 ₫, stopped, min 200, max 100,000; Share việt, cấm dồn đơn, thời gian vài phút, lên đều chậm (ID: 475429)
  - TIKLIVE_SHARE_S3: 24 ₫, stopped, min 200, max 100,000; Share siêu tốc, Bảo trì

### 44. Comment Livestream TikTok (`tiktok_live_comment`, slug: `tiktok-live-comment`)
- Trường cần nhập: `uid` (link profile), `content` (mỗi dòng 1 comment nếu dùng server nhập nội dung), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLIVE_CMT_S1: 300 ₫, active, min 10, max 100,000; Icon ngẫu nhiên, tên nước ngoài, tốc độ rất nhanh (ID: 475465)
  - TIKLIVE_CMT_S2: 468 ₫, stopped, min 10, max 100,000; Nội dung tự nhập, Bảo trì

### 45. Mắt Livestream TikTok (`tiktok_live_eye`, slug: `tiktok-live-eye`)
- Trường cần nhập: `uid` (link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: (đang bảo trì, chưa cập nhật giá)
- Servers:
  - TIKLIVE_EYE_S1: stopped; Bảo trì
  - TIKLIVE_EYE_S5: stopped; Bảo trì

### 46. PK Livestream TikTok (`tiktok_live_pk`, slug: `tiktok-live-pk`)
- Trường cần nhập: `uid` (link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKLIVE_PK_S1: 16.6 ₫, active, min 500, max 10,000; Không hoàn khi lỗi, mỗi live chỉ mua 1 đơn, có thể thiếu, thường kèm like (ID: 475524)
  - TIKLIVE_PK_S2: 17.8 ₫, active, min 500, max 10,000; Không hoàn khi lỗi, mỗi live chỉ mua 1 đơn, có thể thiếu, thường kèm like

### 47. VIP Love TikTok (`tiktok_vip_like`, slug: `tiktok-vip-like`)
- Trường cần nhập: `uid` (link profile), `quantity`, `duration` (1/2/3 tháng), `posts_per_day` (tùy chọn số bài mỗi ngày), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKVIPLOVE_S2: 504 ₫, active, min 1; Like việt, bắt đầu chạy tim sau vài giờ từ khi đăng, gói VIP tháng (ID: 475381)

### 48. VIP View TikTok (`tiktok_vip_view`, slug: `tiktok-vip-view`)
- Trường cần nhập: `uid` (link profile), `quantity`, `duration` (1/2/3 tháng), `posts_per_day` (tùy chọn số bài mỗi ngày), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TIKVIPVIEW_S1: 20.4 ₫, active, min 1; Lưu nhật ký uid; view có thể lên chậm do tiktok bóp; nếu bài bị hủy có thể bấm bù bài (ID: 475379)

### 49. Follow Shopee (`shopee_follow`, slug: `shopee-follow`)
- Trường cần nhập: `uid` (username hoặc link shop), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - SHOPEE_FOLLOW_S1: 70.8 ₫, active, min 500, max 30k; Siêu tốc 10k/1 ngày; Sub gốc cao hoặc >15k sub tốc độ sẽ chậm (ID: 475281)
  - SHOPEE_FOLLOW_S2: 66 ₫, slow, min 500, max 30k; 100-500/24 giờ, tốc độ chậm

### 50. Love Shopee (`shopee_love`, slug: `shopee-love`)
- Trường cần nhập: `uid` (link sản phẩm Shopee), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - SHOPEE_LOVE_S1: 30 ₫, stopped; Tốc độ chậm, Bảo trì

### 51. Like Review Shopee (`shopee_like_review`, slug: `shopee-like-review`)
- Trường cần nhập: `uid` (link sản phẩm Shopee), `account_name` (username người review), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - SHOPEE_LIKEREV_S1: 33.6 ₫, stopped; Bảo trì

### 52. Mắt Livestream Shopee (`shopee_live_eye`, slug: `shopee-live-eye`)
- Trường cần nhập: `uid` (link Shopee live), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit` / hoặc giá theo option phút
- Tổng Giá: `price_per_unit * quantity` (tham chiếu giá option trong `features.options`)
- Servers:
  - SHOPEE_LIVE_EYE_S1: 33.6 ₫, stopped; Bảo trì; options phút (ID: 518441–518446)
  - SHOPEE_LIVE_EYE_S2: 38.6 ₫, stopped; Bảo trì; options phút (ID: 518441–518446)
- Options (features):
  - 30p: 568.8₫ (518441)
  - 60p: 1137.6₫ (518442)
  - 90p: 1706.4₫ (518443)
  - 120p: 2275.2₫ (518444)
  - 180p: 3412.8₫ (518445)
  - 240p: 4550.4₫ (518446)

### 53. Member & Sub Telegram (`telegram_member_sub`, slug: `telegram-member-sub`)
- Trường cần nhập: `uid` (Link Group Telegram), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TELEGRAM_MEMBER_S1: 36.9 ₫, active, min 200, max 40,000; Tốc độ 10k/24 giờ, Bảo hành 7 ngày cho đơn mua đầu tiên (vì vậy không chia nhỏ đơn hàng), có thể tụt vào thời điểm không xác định (ID: 475325)
  - TELEGRAM_MEMBER_S2: 68.8 ₫, active, min 200, max 40,000; Tốc độ 5k-10k/24 giờ, Bảo hành 7 ngày
  - TELEGRAM_MEMBER_S4: 34.4 ₫, active, min 200, max 40,000; Tốc độ 5k/24 giờ, Không bảo hành (tụt hết sau vài ngày)

### 54. View bài viết Telegram (`telegram_post_view`, slug: `telegram-post-view`)
- Trường cần nhập: `uid` (Link Post kênh Telegram - Chỉ hỗ trợ kênh, không hỗ trợ nhóm), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý đặc biệt:** Server 1 yêu cầu số lượng mua phải chia hết cho 100 (ví dụ: 500, 600, 700...)
- Servers:
  - TELEGRAM_VIEW_S1: 1.9 ₫, active, min 500, max 1,000,000; Tốc độ lên chậm, số lượng mua phải chia hết cho 100, bài text thường lên sớm hơn, bài video và ảnh sẽ chậm hơn (ID: 475392)
  - TELEGRAM_VIEW_S2: 6.3 ₫, active, min 500, max 1,000,000; Siêu tốc, 1 bài
  - TELEGRAM_VIEW_S3: 3.8 ₫, maintenance; Nhiều bài tùy chọn - Bảo trì

### 55. Cảm xúc bài viết Telegram (`telegram_post_reaction`, slug: `telegram-post-reaction`)
- Trường cần nhập: `uid` (Link Post kênh Telegram), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Có thể thiếu và không bảo hành, nên mua dư khi mua. Không hỗ trợ group.
- Servers:
  - TELEGRAM_REACTION_S1: 10 ₫, active, min 50, max 500,000; Cảm xúc tích cực ngẫu nhiên [👍🤩🎉🔥❤️🥰👏🏻] (ID: 475395)
  - TELEGRAM_REACTION_S2: 10 ₫, active, min 50, max 500,000; Cảm xúc tiêu cực ngẫu nhiên [👎💩🤮😢😱]
  - TELEGRAM_REACTION_S3: 10 ₫, active, min 50, max 500,000; Cảm xúc tùy chỉnh - Dễ quá tải và hoàn giữa chừng

### 56. Like Youtube (`youtube_like`, slug: `youtube-like`)
- Trường cần nhập: `uid` (Link Video Youtube), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - YOUTUBE_LIKE_S1: 20.3 ₫, active, min 50, max 20,000; Tốc độ trung bình, Bảo hành 15 ngày (ID: 475457)
  - YOUTUBE_LIKE_S2: 30 ₫, active, min 50, max 20,000; Lên nhanh, Bảo hành 15 ngày
  - YOUTUBE_LIKE_S3: 34.5 ₫, active, min 50, max 20,000; Lên nhanh, Bảo hành 30 ngày

### 57. View Youtube (`youtube_view`, slug: `youtube-view`)
- Trường cần nhập: `uid` (Link Video Youtube), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - YOUTUBE_VIEW_S1: 43.1 ₫, active, min 500, max 1,000,000; Speed 1k/day, phần lớn là nguồn ngoài và không xác định, Bảo hành view 30 ngày (ID: 475330)
  - YOUTUBE_VIEW_S4: 33.5 ₫, active, min 10,000, max 1,000,000; Tốc độ nhanh [Native ADS]
  - YOUTUBE_VIEW_S6: 30.6 ₫, active, min 20,000, max 1,000,000; Tốc độ nhanh [Native ADS]
  - YOUTUBE_VIEW_S7: 47.3 ₫, active, min 1,000, max 1,000,000; Speed 2k/day, view random
  - YOUTUBE_VIEW_S9: 57.5 ₫, maintenance, min 1,000, max 1,000,000; Speed 1k/day, Thời lượng xem 10s-2p phút - Bảo trì
  - YOUTUBE_VIEW_S11: 29.4 ₫, active, min 40,000, max 1,000,000; Tốc độ trung bình [Native ADS] - View Số lượng cao
  - YOUTUBE_VIEW_S10: 25 ₫, active, min 300,000, max 1,000,000; [Native ADS]
  - YOUTUBE_VIEW_S12: 22.1 ₫, active, min 500,000, max 1,000,000; [Native ADS]

### 58. View Youtube (400H) (`youtube_view_400h`, slug: `youtube-view-400h`)
- Trường cần nhập: `uid` (Link video kênh), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Yêu cầu video thời lượng từ 5-45 phút
- Servers:
  - YOUTUBE_VIEW_400H_S3: 900 ₫, maintenance; Yêu cầu video thời lượng từ 5-45 phút - Bảo trì

### 59. Live Stream Youtube (`youtube_live_stream`, slug: `youtube-live-stream`)
- Trường cần nhập: `uid` (Link video Youtube), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit` (tùy chọn phút)
- Tổng Giá: `price_per_unit * quantity` (tham chiếu giá option trong `features.options`)
- Servers:
  - YOUTUBE_LIVE_S1: Mắt xem livestream youtube với các tùy chọn phút:
    - 30 phút: 120₫ (ID: 518434)
    - 60 phút: 240₫ (ID: 518435)
    - 90 phút: 360₫ (ID: 518436)
    - 120 phút: 480₫ (ID: 518437)
    - 180 phút: 720₫ (ID: 518439)
    - 240 phút: 960₫ (ID: 518440)

### 60. Like Youtube (400H) (`youtube_like_400h`, slug: `youtube-like-400h`)
- Trường cần nhập: `uid` (Link video kênh), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Yêu cầu video thời lượng từ 5-45 phút
- Servers:
  - YOUTUBE_LIKE_400H_S3: 900 ₫, maintenance; Yêu cầu video thời lượng từ 5-45 phút - Bảo trì

### 61. Comment Youtube (`youtube_comment`, slug: `youtube-comment`)
- Trường cần nhập: `uid` (Link Youtube), `content` (Danh sách nội dung, mỗi dòng 1 bình luận), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - YOUTUBE_CMT_S1: 350 ₫, active, min 10, max 1,500; Đa quốc gia, điền nội dung, Tốc độ thường rất nhanh (ID: 475337)
  - YOUTUBE_CMT_S4: 600 ₫, active, min 10, max 1,500; Việt Nam, điền nội dung
  - YOUTUBE_CMT_S5: 600 ₫, maintenance, min 10, max 1,500; Đa quốc gia, comment AI - Bảo trì
  - YOUTUBE_CMT_S6: 600 ₫, maintenance, min 10, max 1,500; Việt Nam, comment AI - Bảo trì
  - YOUTUBE_CMT_S10: 600 ₫, maintenance, min 10, max 1,500; Đa quốc gia, reply comment AI - Tăng trả lời bình luận - Bảo trì
  - YOUTUBE_CMT_S11: 600 ₫, maintenance, min 10, max 1,500; Việt Nam, reply comment AI - Tăng trả lời bình luận - Bảo trì

### 62. Like Comment Youtube (`youtube_like_comment`, slug: `youtube-like-comment`)
- Trường cần nhập: `uid` (Link Comment Video Youtube), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - YOUTUBE_LIKE_CMT_S1: 45 ₫, active, min 50, max 100,000; Lên siêu tốc, Bảo hành 7 ngày, Tỉ lệ tụt thấp (ID: 475360)
  - YOUTUBE_LIKE_CMT_S2: 41.3 ₫, active, min 50, max 100,000; Siêu tốc, bảo hành 30 ngày

### 63. Subscribe Youtube (`youtube_subscribe`, slug: `youtube-subscribe`)
- Trường cần nhập: `uid` (Link Kênh Youtube), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Cần có video dài hơn 3p để sub không bị tụt. Theo dõi lên chậm thường lên sau 1-2 ngày.
- Servers:
  - YOUTUBE_SUB_S1: 712.5 ₫, slow, min 100, max 1,000,000; Bảo hành 30 ngày, Cần có video dài hơn 3p để sub không bị tụt, Theo dõi lên chậm thường lên sau 1-2 ngày (ID: 475341)
  - YOUTUBE_SUB_S2: 487.5 ₫, active, min 100, max 1,000,000; Bảo hành 30 ngày, [100-300/ 1 ngày]

### 64. Like Twitter (`twitter_like`, slug: `twitter-like`)
- Trường cần nhập: `uid` (Link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TWITTER_LIKE_S1: 26.2 ₫, maintenance; Like ngoại, giá rẻ - Bảo trì
  - TWITTER_LIKE_S2: 82.8 ₫, maintenance; Like việt, [100-200/24 giờ] - Bảo trì

### 65. Follow Twitter (`twitter_follow`, slug: `twitter-follow`)
- Trường cần nhập: `uid` (Link profile), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Dịch vụ có thể tụt hết sub vì vậy không mua số lượng cao. Không bảo hành. Cần tối thiểu 1 sub.
- Servers:
  - TWITTER_FOLLOW_S1: 455.4 ₫, active, min 100, max 1,000; Sub tây, [1000/24 giờ]. Dịch vụ có thể tụt hết sub vì vậy không mua số lượng cao. Không bảo hành (ID: 475357)
  - TWITTER_FOLLOW_S2: 538.2 ₫, active, min 100, max 1,000; Sub tây, [1000/24 giờ]. Bảo hành 7 ngày

### 66. View Twitter (`twitter_view`, slug: `twitter-view`)
- Trường cần nhập: `uid` (Link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Siêu tốc, lên sau vài phút. 10 triệu view/1 ngày. Có tăng lượt impressions để bật kiếm tiền.
- Servers:
  - TWITTER_VIEW_S2: 3.5 ₫, active, min 1,000, max 10,000,000; Siêu tốc, view & impressions. Bảo hành 30 ngày. Siêu tốc, lên sau vài phút. 10 triệu view/1 ngày. Có tăng lượt impressions để bật kiếm tiền (ID: 475501)

### 67. ReTweet Twitter (`twitter_retweet`, slug: `twitter-retweet`)
- Trường cần nhập: `uid` (Link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Mỗi link được mua 1 lần, mua lần 2 gói sẽ bị hoàn tiền.
- Servers:
  - TWITTER_RETWEET_S1: 483 ₫, active, min 10, max 2,000; Nước ngoài. Có tỉ lệ tụt. Mỗi link được mua 1 lần, mua lần 2 gói sẽ bị hoàn tiền (ID: 475416)
  - TWITTER_RETWEET_S2: 372.6 ₫, active, min 10, max 2,000; Nước ngoài. Có tụt

### 68. Comment Twitter (`twitter_comment`, slug: `twitter-comment`)
- Trường cần nhập: `uid` (Link bài viết), `content` (Danh sách nội dung, mỗi dòng 1 bình luận), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TWITTER_CMT_S1: 579.6 ₫, active, min 5, max 1,000; Việt Nam (tốc độ chậm) (ID: 475476)
  - TWITTER_CMT_S2: 1,242 ₫, maintenance; Tài nguyên random - Bảo trì

### 69. Livestream Twitter (`twitter_live_stream`, slug: `twitter-live-stream`)
- Trường cần nhập: `uid` (Link bài viết), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TWITTER_LIVE_S1: 724.5 ₫, active, min 50, max 1,000; Mắt xem livestream twitter ~ 30 phút (ID: 518430)

### 70. VIP Like Twitter (`twitter_vip_like`, slug: `twitter-vip-like`)
- Trường cần nhập: `uid` (Link profile), `quantity` (số like cần mua), `duration` (1/2/3 tháng), `posts_per_day` (tùy chọn số bài mỗi ngày), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `(Giá tiền mỗi like) x (Số lượng like cần mua) x (Tổng số bài mỗi ngày) x (số ngày mua gói)`
- **Lưu ý:** Min 50 like, Max 2000 like
- Servers:
  - TWITTER_VIP_LIKE_S2: 2,428.8 ₫, maintenance; Like random. Tốc độ ổn - Bảo trì (ID: 475497)

### 71. VIP View Twitter (`twitter_vip_view`, slug: `twitter-vip-view`)
- Trường cần nhập: `uid` (Link bài viết), `quantity` (số lượng view cần mua), `duration` (1/2/3 tháng), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- Servers:
  - TWITTER_VIP_VIEW_S1: 20 ₫, active; VIP View Twitter theo tháng (ID: 475499)

### 72. Sub Lazada (`lazada_sub`, slug: `lazada-sub`)
- Trường cần nhập: `uid` (Link Shop), `quantity`, `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** Gói có thể tụt, hãy mua dư 10-20%. Không mua dồn đơn. Bảo hành 15 ngày (bh khi tụt trên 100 sub)
- Servers:
  - LAZADA_SUB_S1: 165.6 ₫, slow, min 100, max 5,000; 100 sub / 24 giờ. BH 15 ngày. (ID: 475485)

### 73. Google Maps (`google_map_create`, slug: `google-map-create`)
- Trường cần nhập: `name` (Tên google maps), `address_type` (options: "Địa chỉ Việt Nam" / "Địa chỉ nước ngoài (Giá +300K)"), `address` (text), `phone` (SDT ghim trên google maps - Liên hệ fanpage để xác thực mã), `website_or_fanpage` (Tên Website hoặc Fanpage - nếu có), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** 
  - Server 1: Thời gian trung bình tầm 5 ngày, 1 số đơn maps yêu cầu cao của google chờ duyệt lâu hơn kéo dài 1-2 tuần. Sau khi tạo maps chúng tôi sẽ liên hệ qua zalo để lấy mã google.
  - Server 2: Cần có bảng hiệu treo và tên maps trùng tên bảng hiệu. Địa chỉ nước ngoài sẽ cộng thêm 300,000 VNĐ.
- Servers:
  - GGMAP_CREATE_S1: 1,242,000 ₫, active, min 1, max 1; Map ảo (ID: 475432). Thời gian trung bình ~5 ngày, có thể 1-2 tuần với maps yêu cầu cao. Sau khi tạo maps sẽ liên hệ qua Zalo để lấy mã google.
  - GGMAP_CREATE_S2: 883,200 ₫, active, min 1, max 1; Map thật, cần bảng hiệu treo và tên maps trùng tên bảng hiệu. Địa chỉ nước ngoài +300k.

### 74. RIP Google Maps (`google_map_rip`, slug: `google-map-rip`)
- Trường cần nhập: `uid` (Link google maps), `address_type` (options: "Địa chỉ Việt Nam" / "Địa chỉ nước ngoài (Giá +300K)"), `contact_phone` (SDT Liên Hệ), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity` (nếu địa chỉ nước ngoài sẽ cộng thêm 300,000 VNĐ)
- **Lưu ý:** Từ chối rip doanh nghiệp uy tín, có chất lượng và nhiều đánh giá tích cực. Nếu maps nước ngoài chi phí sẽ thêm 300,000 VNĐ.
- Servers:
  - GGMAP_RIP_S1: 1,242,000 ₫, active, min 1, max 1; Map ảo (ID: 475444). Từ chối rip doanh nghiệp uy tín, có chất lượng và nhiều đánh giá tích cực. Nếu maps nước ngoài chi phí sẽ thêm 300,000 VNĐ.

### 75. Review 5* Google Maps (`google_map_review`, slug: `google-map-review`)
- Trường cần nhập: `uid` (Link google maps), `quantity`, `service_description` (Mô tả dịch vụ maps bạn cung cấp - **bắt buộc với server này!** Người đánh giá sẽ tự nghĩ nội dung phù hợp để đánh giá với server này!), `note`
- Giá Tiền Mỗi Tương Tác: Tự tính theo `price_per_unit`
- Tổng Giá: `price_per_unit * quantity`
- **Lưu ý:** 
  - Review tích cực, tốc độ chậm 1-2 review/1 ngày (cấm mua lại khi đơn cũ chưa hoàn thành)
  - Hãy nhập chi tiết rõ ràng mô tả của maps để chạy review (nội dung đánh giá có thể lệch chủ đề maps, vì vậy maps cần sự chuẩn chỉ từng câu chữ thì không nên mua dịch vụ)
  - Web không hỗ trợ review ngoại và nội dung ngoại
  - Hãy like review để chất lượng hiển thị review tốt nhất
  - Mỗi nội dung sẽ có 1 lần bấm bảo hành trong 30 ngày đầu, vì vậy hãy kiểm tra kĩ nội dung có mất thì mới bấm
- Servers:
  - GGMAP_REVIEW_S3: 24.15 ₫, slow, min 5, max 20; Review tích cực, tốc độ chậm 1-2 review/ngày (ID: 475551). Cấm mua lại khi đơn cũ chưa hoàn thành.

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
| **Admin Servers** | `GET /api/admin/servers` | name, code, description | `platform`, `service_id`, `status`, `is_active` |

### 🔍 Chi tiết từng API

#### Public APIs

##### Services (`GET /api/services`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, description
- **Lọc:** `?category=like_post_speed` - Lọc theo category cụ thể
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
- **Lọc:** `?category=like_post_speed` - Lọc theo category cụ thể
- **Lọc:** `?platform=facebook` - Lọc theo nhóm dịch vụ (facebook, instagram, threads, tiktok, shopee, telegram, youtube)
- **Lọc:** `?is_active=true` - Lọc theo trạng thái active
- **Ví dụ:** 
  - `GET /api/admin/services?platform=facebook` - Lấy tất cả dịch vụ Facebook (bao gồm inactive)
  - `GET /api/admin/services?platform=youtube&is_active=true` - Lấy dịch vụ YouTube đang active
  - `GET /api/admin/services?search=like&category=like_post_speed&is_active=true` - Tìm kiếm và lọc category cụ thể

##### Servers (`GET /api/admin/servers`)
- **Tìm kiếm:** `?search=keyword` - Tìm theo name, code, description
- **Lọc:** `?service_id=1` - Lọc theo service (ưu tiên cao nhất)
- **Lọc:** `?platform=facebook` - Lọc theo nhóm dịch vụ (chỉ dùng khi không có service_id)
- **Lọc:** `?status=active&is_active=true` - Lọc theo trạng thái
- **Ví dụ:** 
  - `GET /api/admin/servers?service_id=27&page=1&per_page=10` - Lấy servers theo service_id (ưu tiên)
  - `GET /api/admin/servers?platform=facebook&page=1&per_page=10` - Lấy tất cả servers của Facebook (khi không có service_id)
  - `GET /api/admin/servers?platform=youtube&status=active` - Lấy servers YouTube đang active
  - `GET /api/admin/servers?service_id=27&platform=instagram` - Nếu có cả 2, sẽ ưu tiên service_id=27
  - `GET /api/admin/servers?search=Server&service_id=1&status=active&is_active=true` - Tìm kiếm và lọc

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
  - Authentication: 2 (register, login)
  - Services: 4 (list, detail, servers, calculate-price)
- **Protected APIs (User):** 7 endpoints
  - Authentication: 2 (logout, me)
  - User: 2 (update profile, balance)
  - Orders: 3 (create, list, detail)
- **Admin APIs:** 22 endpoints
  - Users: 5 (list, detail, create, update, delete)
  - Orders: 4 (list, detail, update, delete)
  - Services: 5 (list, detail, create, update, delete)
  - Servers: 5 (list, detail, create, update, delete)
  - Settings: 2 (get, update)
  - Platforms: 1 (list)
- **Tổng cộng:** 35 API endpoints
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
