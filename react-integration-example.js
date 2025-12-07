// Ví dụ tích hợp API với React.js
// File này chỉ là ví dụ, bạn có thể sử dụng trong project React của mình

import axios from 'axios';

// Cấu hình base URL
const API_BASE_URL = 'https://yourdomain.com/api';

// Tạo axios instance
const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Thêm token vào header nếu có
const token = localStorage.getItem('token');
if (token) {
  api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// ============ AUTHENTICATION ============

// Đăng ký
export const register = async (userData) => {
  try {
    const response = await api.post('/register', userData);
    const token = response.data.data.token;
    localStorage.setItem('token', token);
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Đăng nhập
export const login = async (username, password) => {
  try {
    const response = await api.post('/login', { username, password });
    const token = response.data.data.token;
    localStorage.setItem('token', token);
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Đăng xuất
export const logout = async () => {
  try {
    await api.post('/logout');
    localStorage.removeItem('token');
    delete api.defaults.headers.common['Authorization'];
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy thông tin user hiện tại
export const getCurrentUser = async () => {
  try {
    const response = await api.get('/me');
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// ============ USER ============

// Cập nhật thông tin cá nhân
export const updateProfile = async (profileData) => {
  try {
    const response = await api.put('/profile', profileData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy số dư
export const getBalance = async () => {
  try {
    const response = await api.get('/balance');
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// ============ SERVICES ============

// Lấy danh sách dịch vụ
export const getServices = async () => {
  try {
    const response = await api.get('/services');
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy chi tiết dịch vụ
export const getService = async (id) => {
  try {
    const response = await api.get(`/services/${id}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy danh sách server của dịch vụ
export const getServers = async (serviceId) => {
  try {
    const response = await api.get(`/services/${serviceId}/servers`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Tính giá tiền
export const calculatePrice = async (serverId, quantity) => {
  try {
    const response = await api.post('/calculate-price', {
      server_id: serverId,
      quantity: quantity,
    });
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// ============ ORDERS ============

// Tạo đơn hàng
export const createOrder = async (orderData) => {
  try {
    const response = await api.post('/orders', orderData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy danh sách đơn hàng
export const getOrders = async (page = 1) => {
  try {
    const response = await api.get(`/orders?page=${page}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy chi tiết đơn hàng
export const getOrder = async (id) => {
  try {
    const response = await api.get(`/orders/${id}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// ============ ADMIN ============

// Lấy danh sách users (admin)
export const getUsers = async (page = 1) => {
  try {
    const response = await api.get(`/admin/users?page=${page}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Tạo user mới (admin)
export const createUser = async (userData) => {
  try {
    const response = await api.post('/admin/users', userData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Cập nhật user (admin)
export const updateUser = async (id, userData) => {
  try {
    const response = await api.put(`/admin/users/${id}`, userData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Xóa user (admin)
export const deleteUser = async (id) => {
  try {
    const response = await api.delete(`/admin/users/${id}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Lấy danh sách đơn hàng (admin)
export const getAdminOrders = async (page = 1) => {
  try {
    const response = await api.get(`/admin/orders?page=${page}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// Cập nhật đơn hàng (admin)
export const updateOrder = async (id, orderData) => {
  try {
    const response = await api.put(`/admin/orders/${id}`, orderData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error;
  }
};

// ============ VÍ DỤ SỬ DỤNG TRONG REACT COMPONENT ============

/*
// Ví dụ trong React Component
import React, { useState, useEffect } from 'react';
import { getServices, createOrder, login } from './api';

function ServicesList() {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchServices = async () => {
      try {
        const response = await getServices();
        setServices(response.data);
      } catch (error) {
        console.error('Error fetching services:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchServices();
  }, []);

  const handleCreateOrder = async (serviceId, serverId, quantity) => {
    try {
      const orderData = {
        service_id: serviceId,
        server_id: serverId,
        quantity: quantity,
        uid: 'https://facebook.com/post/123',
        emotion: 'like',
        speed: 'nhanh',
      };
      
      const response = await createOrder(orderData);
      alert('Tạo đơn hàng thành công!');
      console.log('Order created:', response.data);
    } catch (error) {
      console.error('Error creating order:', error);
      alert(error.message || 'Có lỗi xảy ra');
    }
  };

  if (loading) return <div>Loading...</div>;

  return (
    <div>
      <h1>Danh sách dịch vụ</h1>
      {services.map(service => (
        <div key={service.id}>
          <h2>{service.name}</h2>
          {service.servers.map(server => (
            <div key={server.id}>
              <p>{server.name} - {server.price_per_unit} ₫</p>
              <button onClick={() => handleCreateOrder(service.id, server.id, 100)}>
                Đặt hàng
              </button>
            </div>
          ))}
        </div>
      ))}
    </div>
  );
}

export default ServicesList;
*/

