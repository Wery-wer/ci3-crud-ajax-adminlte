USE crud_ajax;

UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'admin';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'user2';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'user3';
UPDATE users SET password = '$2y$10$EIr5zZhd36wKy7GjYgVSVOt.Nv6FMjGpOWfgNXUQcJ0HLQyKGqUCC' WHERE username = 'manager1';

SELECT id, name, username, role, is_active, 
       SUBSTRING(password, 1, 20) as password_preview
FROM users;

