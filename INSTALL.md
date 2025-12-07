# Hướng dẫn cài đặt Facebook Buff API trên cPanel

## Bước 1: Upload files

1. Upload toàn bộ files vào thư mục `public_html` hoặc thư mục bạn muốn trên cPanel
2. Đảm bảo các thư mục sau có quyền ghi (755 hoặc 777):
   - `storage`
   - `storage/framework`
   - `storage/framework/cache`
   - `storage/framework/sessions`
   - `storage/framework/views`
   - `storage/logs`
   - `bootstrap/cache`

## Bước 2: Cấu hình database

1. Tạo database trong cPanel:
   - Vào MySQL Databases
   - Tạo database mới (ví dụ: `likewebapp`)
   - Tạo user mới và gán quyền cho database

2. Tạo file `.env` từ `.env.example`:
   ```bash
   cp .env.example .env
   ```

3. Sửa file `.env`:
   ```
   APP_NAME="Facebook Buff API"
   APP_ENV=production
   APP_KEY=
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=likewebapp
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

## Bước 3: Cài đặt dependencies

SSH vào server hoặc sử dụng Terminal trong cPanel:

```bash
cd /home/username/public_html
composer install --no-dev --optimize-autoloader
```

Nếu không có Composer, cài đặt:
```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
```

## Bước 4: Tạo APP_KEY

```bash
php artisan key:generate
```

## Bước 5: Chạy migrations

```bash
php artisan migrate
```

## Bước 6: Chạy seeders để tạo dữ liệu mẫu

```bash
php artisan db:seed
```

## Bước 7: Cấu hình .htaccess

Đảm bảo file `.htaccess` trong thư mục gốc có nội dung đúng. Nếu không hoạt động, thử:

1. Kiểm tra mod_rewrite đã được bật trong cPanel
2. Thêm vào đầu file `.htaccess`:
   ```apache
   RewriteBase /
   ```

## Bước 8: Tạo tài khoản admin đầu tiên

Sau khi chạy migrations, tạo user đầu tiên sẽ có quyền admin (id = 1).

Bạn có thể tạo bằng cách:
1. Đăng ký qua API `/api/register`
2. Hoặc thêm trực tiếp vào database với id = 1

## Bước 9: Kiểm tra

1. Truy cập: `https://yourdomain.com/api/services`
2. Nếu thấy JSON response với danh sách services, hệ thống đã hoạt động!

## Lưu ý quan trọng

1. **PHP Version**: Đảm bảo PHP >= 7.4
2. **File Permissions**: 
   - Thư mục: 755
   - Files: 644
   - storage và bootstrap/cache: 775 hoặc 777
3. **Memory Limit**: Tăng memory_limit trong php.ini nếu cần
4. **Max Execution Time**: Tăng max_execution_time nếu cần

## Troubleshooting

### Lỗi 500 Internal Server Error
- Kiểm tra file `.env` đã được tạo
- Kiểm tra quyền ghi cho thư mục `storage` và `bootstrap/cache`
- Kiểm tra logs trong `storage/logs/laravel.log`

### Lỗi database connection
- Kiểm tra thông tin database trong `.env`
- Kiểm tra user có quyền truy cập database
- Kiểm tra host (thường là `localhost` trên cPanel)

### Lỗi route not found
- Kiểm tra `.htaccess` đã được cấu hình đúng
- Kiểm tra mod_rewrite đã được bật
- Thử thêm `RewriteBase /` vào đầu `.htaccess`

