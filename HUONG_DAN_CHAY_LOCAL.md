# Hướng dẫn chạy Local - Các bước đã hoàn thành ✅

## ✅ Đã hoàn thành:
1. ✅ Đã cài đặt dependencies (composer install)
2. ✅ Đã tạo file .env
3. ✅ Đã tạo APP_KEY
4. ✅ Đã sửa lỗi code

## 📋 Các bước tiếp theo bạn cần làm:

### Bước 1: Khởi động XAMPP
1. Mở **XAMPP Control Panel**
2. Click **Start** cho **Apache** và **MySQL**
3. Đảm bảo cả hai đều hiển thị màu xanh (đang chạy)

### Bước 2: Tạo Database
1. Mở trình duyệt và truy cập: **http://localhost/phpmyadmin**
2. Click vào **"New"** (hoặc "Mới") ở sidebar bên trái
3. Đặt tên database: `likewebapp`
4. Chọn collation: `utf8mb4_unicode_ci`
5. Click **"Create"** (Tạo)

### Bước 3: Cấu hình Database trong file .env
Mở file `.env` trong thư mục `C:\xampp\htdocs\api` và kiểm tra các dòng sau:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=likewebapp
DB_USERNAME=root
DB_PASSWORD=
```

**Lưu ý**: 
- `DB_DATABASE` phải trùng với tên database bạn vừa tạo
- `DB_PASSWORD` để trống nếu MySQL chưa set password

### Bước 4: Chạy Migrations (Tạo bảng trong database)
Mở **Command Prompt** hoặc **PowerShell** và chạy:

```bash
cd C:\xampp\htdocs\api
php artisan migrate
```

Lệnh này sẽ tạo tất cả các bảng cần thiết trong database.

### Bước 5: Chạy Seeders (Tạo dữ liệu mẫu)
```bash
php artisan db:seed
```

Lệnh này sẽ tạo dữ liệu mẫu (services, servers) để test.

### Bước 6: Kiểm tra hoạt động
Mở trình duyệt và truy cập:

**http://localhost/api/public/api/services**

Nếu thấy JSON response với danh sách services, hệ thống đã hoạt động! 🎉

Ví dụ response:
```json
{
    "success": true,
    "data": [...]
}
```

## 🔐 Tạo tài khoản Admin đầu tiên

User đầu tiên được tạo (id = 1) sẽ có quyền admin.

### Cách 1: Đăng ký qua API (Khuyến nghị)

Sử dụng **Postman** hoặc **curl**:

**POST** `http://localhost/api/public/api/register`

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
    "username": "admin",
    "email": "admin@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "full_name": "Admin User"
}
```

### Cách 2: Sử dụng Tinker
```bash
php artisan tinker
```

Sau đó trong tinker:
```php
$user = new App\Models\User();
$user->username = 'admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('password123');
$user->full_name = 'Admin User';
$user->save();
exit
```

## 📝 Sử dụng API

### Base URL
```
http://localhost/api/public/api
```

### Ví dụ các endpoint:

#### 1. Đăng nhập
```
POST http://localhost/api/public/api/login
Content-Type: application/json

{
    "username": "admin",
    "password": "password123"
}
```

#### 2. Lấy danh sách services (không cần đăng nhập)
```
GET http://localhost/api/public/api/services
```

#### 3. Tạo đơn hàng (cần token)
```
POST http://localhost/api/public/api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
    "service_id": 1,
    "server_id": 1,
    "uid": "https://facebook.com/post/123",
    "quantity": 100,
    "emotion": "like",
    "speed": "nhanh"
}
```

## 🛠️ Troubleshooting

### Lỗi: "SQLSTATE[HY000] [1045] Access denied"
- Kiểm tra MySQL đã chạy trong XAMPP
- Kiểm tra thông tin database trong `.env`
- Thử đổi `DB_HOST` từ `127.0.0.1` sang `localhost`

### Lỗi: "500 Internal Server Error"
- Kiểm tra file `.env` đã được tạo
- Kiểm tra quyền ghi cho thư mục `storage` và `bootstrap/cache`
- Xem log: `storage/logs/laravel.log`

### Lỗi: "Route not found" hoặc "404"
- Đảm bảo truy cập đúng URL: `http://localhost/api/public/api/...`
- Kiểm tra file `.htaccess` trong thư mục `public` (nếu có)

### Lỗi: "Class 'PDO' not found"
- Mở `php.ini` trong XAMPP: `C:\xampp\php\php.ini`
- Tìm và bỏ comment dòng: `extension=pdo_mysql`
- Restart Apache trong XAMPP

## 📚 Các lệnh Artisan hữu ích

```bash
# Xem danh sách routes
php artisan route:list

# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Chạy lại migrations (xóa và tạo lại)
php artisan migrate:fresh
php artisan db:seed
```

## 🎯 Kết nối với Frontend (React/Vue)

Cấu hình CORS trong `config/cors.php` để cho phép frontend kết nối:

```php
'allowed_origins' => ['http://localhost:3000'], // URL của frontend
```

Sau đó trong frontend, sử dụng base URL:
```javascript
const API_URL = 'http://localhost/api/public/api';
```

---

**Chúc bạn thành công! 🚀**

