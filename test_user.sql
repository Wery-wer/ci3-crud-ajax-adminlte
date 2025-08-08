USE crud_ajax;

DELETE FROM users WHERE username = 'testadmin';

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

SELECT id, name, username, role, is_active FROM users WHERE username IN ('testadmin', 'simple');
