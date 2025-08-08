-- Script untuk insert admin dan user sample dengan hash password yang benar
-- Pastikan database crud_ajax sudah ada

USE crud_ajax;

-- Update password semua users dengan hash yang benar untuk "admin123"
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'admin';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'user2';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'user3';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'manager1';

-- Show updated users
SELECT id, name, username, role, is_active, 
       SUBSTRING(password, 1, 20) as password_preview
FROM users;

-- Credentials:
-- Username: admin, Password: admin123 (Role: admin)
-- Username: user2, Password: admin123 (Role: user)  
-- Username: user3, Password: admin123 (Role: user)
-- Username: manager1, Password: admin123 (Role: manager)
