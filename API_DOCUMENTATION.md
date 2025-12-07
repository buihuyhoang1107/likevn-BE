# API Documentation - Facebook Buff System

## Base URL
```
https://yourdomain.com/api
```

## Authentication

Tất cả các API cần authentication sẽ sử dụng Bearer Token trong header:
```
Authorization: Bearer {token}
```

---

## 1. Authentication APIs

### Đăng ký
```
POST /api/register
```

**Request Body:**
```json
{
  "username": "testuser",
  "email": "test@example.com",
  "full_name": "Nguyễn Văn A",
  "phone": "0123456789",
  "ref_code": "REF123",
  "password": "password123"
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

### Đăng nhập
```
POST /api/login
```

**Request Body:**
```json
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

### Đăng xuất
```
POST /api/logout
Headers: Authorization: Bearer {token}
```

### Lấy thông tin user hiện tại
```
GET /api/me
Headers: Authorization: Bearer {token}
```

---

## 2. User APIs

### Cập nhật thông tin cá nhân
```
PUT /api/profile
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "username": "newusername",
  "email": "newemail@example.com",
  "full_name": "Tên mới",
  "phone": "0987654321",
  "ref_code": "NEWREF",
  "password": "newpassword" // optional
}
```

### Lấy số dư
```
GET /api/balance
Headers: Authorization: Bearer {token}
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

---

## 3. Service APIs

### Lấy danh sách dịch vụ
```
GET /api/services
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

### Lấy chi tiết dịch vụ
```
GET /api/services/{id}
```

### Lấy danh sách server của dịch vụ
```
GET /api/services/{serviceId}/servers
```

### Tính giá tiền
```
POST /api/calculate-price
```

**Request Body:**
```json
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

## 4. Order APIs

### Tạo đơn hàng
```
POST /api/orders
Headers: Authorization: Bearer {token}
```

**Request Body:**
```json
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
    "action": "Like bài viết Speed",
    "quantity": 100,
    "total_price": 2620.00,
    "status": "pending",
    ...
  }
}
```

### Lấy danh sách đơn hàng của user
```
GET /api/orders?page=1
Headers: Authorization: Bearer {token}
```

### Lấy chi tiết đơn hàng
```
GET /api/orders/{id}
Headers: Authorization: Bearer {token}
```

---

## 5. Admin APIs

Tất cả admin APIs cần user có quyền admin (id = 1 hoặc type = 'admin').

### Quản lý Users

#### Lấy danh sách users
```
GET /api/admin/users?page=1
Headers: Authorization: Bearer {admin_token}
```

#### Lấy chi tiết user
```
GET /api/admin/users/{id}
Headers: Authorization: Bearer {admin_token}
```

#### Tạo user mới
```
POST /api/admin/users
Headers: Authorization: Bearer {admin_token}
```

**Request Body:**
```json
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
```
PUT /api/admin/users/{id}
Headers: Authorization: Bearer {admin_token}
```

**Request Body:** (tất cả fields đều optional)
```json
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

#### Xóa user
```
DELETE /api/admin/users/{id}
Headers: Authorization: Bearer {admin_token}
```

### Quản lý Orders

#### Lấy danh sách đơn hàng
```
GET /api/admin/orders?page=1
Headers: Authorization: Bearer {admin_token}
```

#### Lấy chi tiết đơn hàng
```
GET /api/admin/orders/{id}
Headers: Authorization: Bearer {admin_token}
```

#### Cập nhật đơn hàng
```
PUT /api/admin/orders/{id}
Headers: Authorization: Bearer {admin_token}
```

**Request Body:**
```json
{
  "status": "processing", // pending, processing, completed, cancelled, failed
  "admin_note": "Ghi chú của admin",
  "ran": 50 // Số lượng đã chạy
}
```

#### Xóa đơn hàng
```
DELETE /api/admin/orders/{id}
Headers: Authorization: Bearer {admin_token}
```

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

## Các loại dịch vụ

1. **like_post_speed** - Like bài viết Speed
2. **like_post_vip** - Like bài viết VIP
3. **sub_personal_fanpage** - Sub cá nhân & Sub fanpage
4. **like_fanpage** - Like fanpage
5. **like_comment** - Like cho bình luận
6. **increase_comment** - Tăng bình luận
7. **share_post** - Chia sẻ bài viết

## Các loại cảm xúc (emotion)

- `like` - Like
- `love` - Tim
- `haha` - Haha
- `wow` - Wow
- `sad` - Buồn
- `angry` - Tức giận

## Tốc độ (speed)

- `nhanh` - Nhanh
- `cham` - Chậm
- `trung_binh` - Trung bình

## Trạng thái đơn hàng (status)

- `pending` - Đang chờ
- `processing` - Đang xử lý
- `completed` - Hoàn thành
- `cancelled` - Đã hủy
- `failed` - Thất bại

