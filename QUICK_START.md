# Quick Start Guide

## Cài đặt nhanh trên cPanel

### 1. Upload files
Upload toàn bộ files vào thư mục trên cPanel (thường là `public_html`)

### 2. Cấu hình database
Tạo file `.env` với nội dung:
```
APP_NAME="Facebook Buff API"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 3. Chạy lệnh (qua SSH hoặc Terminal trong cPanel)
```bash
cd /home/username/public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 4. Cấu hình quyền
```bash
chmod -R 775 storage bootstrap/cache
```

### 5. Kiểm tra
Truy cập: `https://yourdomain.com/api/services`

Nếu thấy JSON response, hệ thống đã hoạt động!

## Tạo tài khoản admin đầu tiên

Sau khi chạy migrations, user đầu tiên được tạo (id = 1) sẽ có quyền admin.

Bạn có thể:
1. Đăng ký qua API: `POST /api/register`
2. Hoặc thêm trực tiếp vào database với id = 1

## Kết nối với React.js

### Ví dụ sử dụng Axios:
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'https://yourdomain.com/api',
});

// Đăng nhập
const login = async (username, password) => {
  const response = await api.post('/login', { username, password });
  const token = response.data.data.token;
  localStorage.setItem('token', token);
  api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
  return response.data;
};

// Lấy danh sách dịch vụ
const getServices = async () => {
  const response = await api.get('/services');
  return response.data;
};

// Tạo đơn hàng
const createOrder = async (orderData) => {
  const response = await api.post('/orders', orderData);
  return response.data;
};
```

## Các endpoint chính

- `POST /api/register` - Đăng ký
- `POST /api/login` - Đăng nhập
- `GET /api/services` - Danh sách dịch vụ
- `POST /api/orders` - Tạo đơn hàng
- `GET /api/orders` - Lịch sử đơn hàng
- `GET /api/admin/users` - Quản lý users (admin)
- `GET /api/admin/orders` - Quản lý orders (admin)

Xem chi tiết trong file `API_DOCUMENTATION.md`

