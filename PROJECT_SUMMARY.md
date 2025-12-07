# Tóm tắt dự án Facebook Buff API

## Tổng quan
Hệ thống API quản lý dịch vụ Facebook Buff (Like, Share, Comment, Sub) được xây dựng bằng Laravel 8, sẵn sàng triển khai trên cPanel.

## Cấu trúc dự án

### Database
- **users**: Quản lý tài khoản người dùng
- **services**: Danh sách các dịch vụ
- **servers**: Danh sách server cho từng dịch vụ
- **orders**: Lịch sử đơn hàng/dịch vụ

### Models
- `User`: Quản lý người dùng
- `Service`: Quản lý dịch vụ
- `Server`: Quản lý server
- `Order`: Quản lý đơn hàng

### Controllers
- `AuthController`: Xử lý đăng nhập, đăng ký
- `UserController`: Quản lý thông tin user
- `OrderController`: Xử lý đơn hàng
- `ServiceController`: Quản lý dịch vụ
- `AdminController`: Quản lý admin (users, orders)

### API Routes
Tất cả routes nằm trong `/api/*`

## Tính năng đã hoàn thành

### User
✅ Đăng ký, đăng nhập
✅ Cập nhật thông tin cá nhân (username, email, full_name, phone, ref_code, password)
✅ Xem số dư
✅ Tạo đơn hàng
✅ Xem lịch sử đơn hàng

### Admin
✅ Quản lý users (CRUD)
✅ Phân quyền (type: user/agent/collaborator)
✅ Quản lý số dư, tổng nạp tháng, cấp bậc
✅ Xác thực user (is_verified)
✅ Bật/tắt tài khoản (is_active)
✅ Quản lý đơn hàng (xem, cập nhật trạng thái, ghi chú)
✅ Cập nhật số lượng đã chạy (ran)

### Dịch vụ
✅ Like bài viết Speed (6 servers)
✅ Like bài viết VIP (1 server)
✅ Sub cá nhân & Sub fanpage (8 servers)
✅ Like fanpage (7 servers)
✅ Like cho bình luận (3 servers)
✅ Tăng bình luận (5 servers)
✅ Chia sẻ bài viết (4 servers)

### Tính năng đơn hàng
✅ Tự động tính giá dựa trên server và số lượng
✅ Kiểm tra số dư trước khi tạo đơn
✅ Trừ tiền tự động khi tạo đơn
✅ Lưu đầy đủ thông tin: UID, tên tài khoản, nội dung, ghi chú
✅ Hỗ trợ cảm xúc (like, love, haha, wow, sad, angry)
✅ Hỗ trợ tốc độ (nhanh, chậm, trung bình)
✅ Lưu lịch sử đầy đủ với tất cả thông tin yêu cầu

## Files quan trọng

### Cấu hình
- `.env` - Cấu hình môi trường (cần tạo từ .env.example)
- `config/database.php` - Cấu hình database
- `config/app.php` - Cấu hình ứng dụng
- `.htaccess` - Cấu hình Apache

### Database
- `database/migrations/` - Migrations
- `database/seeders/` - Seeders (tạo dữ liệu mẫu)

### API
- `routes/api.php` - Định nghĩa routes
- `app/Http/Controllers/` - Controllers
- `app/Models/` - Models

### Documentation
- `README.md` - Hướng dẫn tổng quan
- `INSTALL.md` - Hướng dẫn cài đặt chi tiết
- `API_DOCUMENTATION.md` - Tài liệu API đầy đủ
- `QUICK_START.md` - Hướng dẫn nhanh
- `react-integration-example.js` - Ví dụ tích hợp React.js

## Các bước triển khai

1. Upload files lên cPanel
2. Cấu hình database trong `.env`
3. Chạy `composer install`
4. Chạy `php artisan key:generate`
5. Chạy `php artisan migrate`
6. Chạy `php artisan db:seed`
7. Cấu hình quyền cho thư mục `storage` và `bootstrap/cache`

## Kết nối với React.js

API sẵn sàng kết nối với React.js frontend. Xem file `react-integration-example.js` để biết cách tích hợp.

Tất cả responses đều là JSON format:
```json
{
  "success": true/false,
  "message": "Thông báo",
  "data": {...}
}
```

## Lưu ý

1. User đầu tiên (id = 1) có quyền admin
2. Tất cả API cần authentication sẽ yêu cầu Bearer Token
3. CORS đã được cấu hình để cho phép tất cả origins
4. Database migrations và seeders đã bao gồm tất cả dữ liệu mẫu theo yêu cầu

## Hỗ trợ

Nếu gặp vấn đề, kiểm tra:
- File `.env` đã được tạo và cấu hình đúng
- Quyền ghi cho thư mục `storage` và `bootstrap/cache`
- Logs trong `storage/logs/laravel.log`
- Database connection trong `.env`

