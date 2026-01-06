# Hướng dẫn chạy source code trên Local (XAMPP)

## Yêu cầu hệ thống

- **XAMPP** đã được cài đặt (PHP >= 7.4, MySQL, Apache)
- **Composer** đã được cài đặt
- **Git** (nếu cần clone project)

## Bước 1: Kiểm tra XAMPP

1. Mở **XAMPP Control Panel**
2. Khởi động **Apache** và **MySQL**
3. Đảm bảo cả hai đều chạy (màu xanh)

## Bước 2: Tạo Database

1. Mở trình duyệt và truy cập: `http://localhost/phpmyadmin`
2. Tạo database mới:
   - Click vào **"New"** (hoặc "Mới")
   - Đặt tên database: `likewebapp` (hoặc tên bạn muốn)
   - Chọn collation: `utf8mb4_unicode_ci`
   - Click **"Create"** (Tạo)

## Bước 3: Cấu hình file .env

1. Mở thư mục project: `C:\xampp\htdocs\api`
2. Tạo file `.env` từ `.env.example`:
   ```bash
   copy .env.example .env
   ```
   Hoặc copy thủ công file `.env.example` và đổi tên thành `.env`

3. Mở file `.env` và cấu hình:
   ```env
   APP_NAME="Facebook Buff API"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost/api

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=likewebapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   
   **Lưu ý**: 
   - `DB_DATABASE`: Tên database bạn vừa tạo
   - `DB_USERNAME`: Thường là `root` trên XAMPP
   - `DB_PASSWORD`: Để trống nếu chưa set password cho MySQL

## Bước 4: Cài đặt Dependencies

Mở **Command Prompt** hoặc **PowerShell** và chạy:

```bash
cd C:\xampp\htdocs\api
composer install
```

Nếu chưa có Composer, tải và cài đặt từ: https://getcomposer.org/

## Bước 5: Tạo APP_KEY

```bash
php artisan key:generate
```

Lệnh này sẽ tự động tạo và cập nhật `APP_KEY` trong file `.env`

## Bước 6: Chạy Migrations (Tạo bảng database)

```bash
php artisan migrate
```

Lệnh này sẽ tạo tất cả các bảng cần thiết trong database.

## Bước 7: Chạy Seeders (Tạo dữ liệu mẫu)

```bash
php artisan db:seed
```

Lệnh này sẽ tạo dữ liệu mẫu (services, servers) để test.

## Bước 8: Cấu hình Virtual Host (Tùy chọn - Khuyến nghị)

### Sử dụng trực tiếp (Đơn giản)

Truy cập API qua: `http://localhost/api/public/`


## Bước 9: Kiểm tra hoạt động

1. Mở trình duyệt và truy cập:
   - `http://localhost/api/public/api/services`
   - Hoặc `http://api.local/api/services` (nếu đã cấu hình virtual host)

2. Nếu thấy JSON response với danh sách services, hệ thống đã hoạt động!

Ví dụ response:
```json
{
    "success": true,
    "data": [...]
}
```

## Bước 10: Tạo tài khoản Admin đầu tiên

User đầu tiên được tạo (id = 1) sẽ có quyền admin.

### Cách 1: Đăng ký qua API

Sử dụng Postman hoặc curl:

```bash
POST http://localhost/api/public/api/register
Content-Type: application/json

{
    "username": "admin",
    "email": "admin@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "full_name": "Admin User"
}
```

### Cách 2: Thêm trực tiếp vào database

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Chọn database `likewebapp`
3. Vào bảng `users`
4. Insert user với `id = 1`:
   ```sql
   INSERT INTO users (id, username, email, password, full_name, type, balance, is_active, created_at, updated_at)
   VALUES (1, 'admin', 'admin@example.com', '$2y$10$...', 'Admin User', 'user', 0, 1, NOW(), NOW());
   ```
   
   **Lưu ý**: Password cần được hash bằng bcrypt. Bạn có thể tạo password hash bằng:
   ```bash
   php artisan tinker
   >>> Hash::make('password123')
   ```

## Sử dụng API

### Base URL
- Local: `http://localhost/api/public/api`
- Hoặc: `http://api.local/api` (nếu dùng virtual host)

### Ví dụ đăng nhập

```bash
POST http://localhost/api/public/api/login
Content-Type: application/json

{
    "username": "admin",
    "password": "password123"
}
```

Response:
```json
{
    "success": true,
    "data": {
        "token": "1|xxxxxxxxxxxxx",
        "user": {...}
    }
}
```

### Ví dụ lấy danh sách services

```bash
GET http://localhost/api/public/api/services
```

### Ví dụ tạo đơn hàng (cần token)

```bash
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

## Troubleshooting

### Lỗi: "Class 'PDO' not found"
- Mở `php.ini` trong XAMPP
- Tìm và bỏ comment dòng: `extension=pdo_mysql`
- Restart Apache

### Lỗi: "Composer not found"
- Tải Composer từ: https://getcomposer.org/
- Hoặc sử dụng: `php composer.phar install`

### Lỗi: "500 Internal Server Error"
- Kiểm tra file `.env` đã được tạo
- Kiểm tra quyền ghi cho thư mục `storage` và `bootstrap/cache`
- Xem log: `storage/logs/laravel.log`

### Lỗi: "SQLSTATE[HY000] [1045] Access denied"
- Kiểm tra thông tin database trong `.env`
- Kiểm tra MySQL đã chạy trong XAMPP
- Thử đổi `DB_HOST` từ `127.0.0.1` sang `localhost`

### Lỗi: "Route not found" hoặc "404"
- Đảm bảo truy cập đúng URL: `http://localhost/api/public/api/...`
- Kiểm tra file `.htaccess` trong thư mục `public`
- Kiểm tra mod_rewrite đã được bật trong Apache

### Lỗi: "The stream or file could not be opened"
- Tạo thư mục `storage/logs` nếu chưa có
- Đảm bảo quyền ghi cho thư mục `storage`

## Các lệnh Artisan hữu ích

```bash
# Xem danh sách routes
php artisan route:list

# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Chạy lại migrations (xóa và tạo lại)
php artisan migrate:fresh
php artisan db:seed

# Tạo user mới qua tinker
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->username = 'test';
>>> $user->email = 'test@test.com';
>>> $user->password = Hash::make('password');
>>> $user->save();
```

## Kết nối với Frontend (React/Vue)

Cấu hình CORS trong `config/cors.php` để cho phép frontend kết nối:

```php
'allowed_origins' => ['http://localhost:3000'], // URL của frontend
```

Sau đó trong frontend, sử dụng base URL:
```javascript
const API_URL = 'http://localhost/api/public/api';
// hoặc
const API_URL = 'http://api.local/api';
```

## Lưu ý quan trọng

1. pull code
2. **APP_DEBUG=true** chỉ dùng cho local, không dùng cho production
3. User đầu tiên (id = 1) tự động có quyền admin
4. Đảm bảo PHP version >= 7.4 (kiểm tra: `php -v`)
