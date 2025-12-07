# Facebook Buff API System

Hệ thống API quản lý dịch vụ Facebook Buff (Like, Share, Comment, Sub) được xây dựng bằng Laravel.

## Cài đặt

### Yêu cầu
- PHP >= 7.4
- MySQL/MariaDB
- Composer
- cPanel hosting

### Cài đặt trên cPanel

1. **Upload files lên cPanel**
   - Upload toàn bộ files vào thư mục `public_html` hoặc thư mục bạn muốn

2. **Cấu hình database**
   - Tạo database và user trong cPanel
   - Sửa file `.env` (hoặc tạo từ `.env.example`):
   ```
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   DB_HOST=localhost
   ```

3. **Cài đặt dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Chạy migrations**
   ```bash
   php artisan migrate
   ```

5. **Chạy seeders để tạo dữ liệu mẫu**
   ```bash
   php artisan db:seed
   ```

6. **Tạo APP_KEY**
   ```bash
   php artisan key:generate
   ```

7. **Cấu hình .htaccess**
   - Đảm bảo file `.htaccess` đã được upload
   - Đảm bảo mod_rewrite đã được bật trong cPanel

## Cấu trúc API

### Authentication
- `POST /api/register` - Đăng ký tài khoản
- `POST /api/login` - Đăng nhập
- `POST /api/logout` - Đăng xuất (cần auth)
- `GET /api/me` - Lấy thông tin user hiện tại (cần auth)

### User
- `PUT /api/profile` - Cập nhật thông tin cá nhân (cần auth)
- `GET /api/balance` - Lấy số dư (cần auth)

### Services
- `GET /api/services` - Lấy danh sách dịch vụ
- `GET /api/services/{id}` - Lấy chi tiết dịch vụ
- `GET /api/services/{serviceId}/servers` - Lấy danh sách server của dịch vụ
- `POST /api/calculate-price` - Tính giá tiền

### Orders
- `POST /api/orders` - Tạo đơn hàng (cần auth)
- `GET /api/orders` - Lấy danh sách đơn hàng của user (cần auth)
- `GET /api/orders/{id}` - Lấy chi tiết đơn hàng (cần auth)

### Admin
- `GET /api/admin/users` - Lấy danh sách users
- `GET /api/admin/users/{id}` - Lấy chi tiết user
- `POST /api/admin/users` - Tạo user mới
- `PUT /api/admin/users/{id}` - Cập nhật user
- `DELETE /api/admin/users/{id}` - Xóa user
- `GET /api/admin/orders` - Lấy danh sách đơn hàng
- `GET /api/admin/orders/{id}` - Lấy chi tiết đơn hàng
- `PUT /api/admin/orders/{id}` - Cập nhật đơn hàng
- `DELETE /api/admin/orders/{id}` - Xóa đơn hàng

## Sử dụng với React.js

### Ví dụ đăng nhập
```javascript
const response = await fetch('https://yourdomain.com/api/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    username: 'username',
    password: 'password'
  })
});

const data = await response.json();
const token = data.data.token;

// Lưu token để sử dụng cho các request sau
localStorage.setItem('token', token);
```

### Ví dụ gọi API có authentication
```javascript
const token = localStorage.getItem('token');

const response = await fetch('https://yourdomain.com/api/me', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json',
  }
});

const data = await response.json();
```

### Ví dụ tạo đơn hàng
```javascript
const response = await fetch('https://yourdomain.com/api/orders', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    service_id: 1,
    server_id: 1,
    uid: 'https://facebook.com/post/123',
    quantity: 100,
    emotion: 'like',
    speed: 'nhanh',
    note: 'Ghi chú'
  })
});
```

## Database Schema

### Users
- id, username, email, full_name, phone, ref_code
- password, type (user/agent/collaborator)
- balance, monthly_deposit, level
- is_verified, is_active

### Services
- id, name, slug, description, category, is_active

### Servers
- id, name, code, service_id, description
- price_per_unit, status (active/slow/stopped)
- min_quantity, max_quantity, features, is_active

### Orders
- id, user_id, service_id, server_id
- action, uid, account_name, content
- note, admin_note, quantity, ran
- price_per_unit, total_price
- emotion, speed, started_at, status
- admin_id

## Lưu ý

1. User đầu tiên được tạo sẽ có quyền admin (id = 1)
2. Đảm bảo cấu hình CORS đúng với domain React.js của bạn
3. Sửa `config/cors.php` nếu cần thiết
4. Đảm bảo PHP version >= 7.4 trên cPanel
5. Kiểm tra quyền ghi cho thư mục `storage` và `bootstrap/cache`

