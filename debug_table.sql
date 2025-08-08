USE crud_ajax;

DESCRIBE users;

SELECT id, name, username, email, role, is_active, status FROM users LIMIT 5;

SHOW COLUMNS FROM users LIKE 'is_active';
SHOW COLUMNS FROM users LIKE 'status';
SHOW COLUMNS FROM users LIKE 'username';
SHOW COLUMNS FROM users LIKE 'role';

