CREATE DATABASE IF NOT EXISTS `crud_ajax` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `crud_ajax`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`name`, `email`, `status`, `created_at`) VALUES
('John Doe', 'john.doe@example.com', 'active', NOW()),
('Jane Smith', 'jane.smith@example.com', 'active', NOW()),
('Mike Johnson', 'mike.johnson@example.com', 'inactive', NOW()),
('Sarah Wilson', 'sarah.wilson@example.com', 'active', NOW()),
('David Brown', 'david.brown@example.com', 'active', NOW());

DESCRIBE `users`;

SELECT * FROM `users` ORDER BY `id` DESC;

ALTER TABLE users 
ADD COLUMN username VARCHAR(50) UNIQUE AFTER id,
ADD COLUMN password VARCHAR(255) AFTER email,
ADD COLUMN role ENUM('admin','manager','user') DEFAULT 'user' AFTER password,
ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER role,
ADD COLUMN last_login DATETIME NULL AFTER is_active,
ADD COLUMN profile_picture VARCHAR(255) NULL AFTER last_login;

UPDATE users SET 
    username = CONCAT('user', id),
    password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin123
    role = 'user',
    is_active = 1;

UPDATE users SET role = 'admin', username = 'admin' WHERE id = 1;

CREATE TABLE departments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    department_code VARCHAR(10) UNIQUE NOT NULL,
    department_name VARCHAR(100) NOT NULL,
    description TEXT,
    manager_id INT NULL,
    budget DECIMAL(15,2) DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    department_id INT,
    position VARCHAR(50),
    hire_date DATE,
    salary DECIMAL(12,2),
    status ENUM('active','inactive','terminated') DEFAULT 'active',
    photo VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

ALTER TABLE users 
ADD COLUMN employee_id INT NULL,
ADD FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE SET NULL;

INSERT INTO departments (department_code, department_name, description, budget) VALUES
('IT', 'Information Technology', 'Handles all IT infrastructure and development', 500000000),
('HR', 'Human Resources', 'Manages employee relations and recruitment', 200000000),
('FIN', 'Finance', 'Financial planning and accounting', 300000000),
('MKT', 'Marketing', 'Marketing and promotional activities', 250000000);

INSERT INTO employees (employee_id, full_name, email, phone, department_id, position, hire_date, salary) VALUES
('EMP001', 'John Developer', 'john.dev@company.com', '081234567890', 1, 'Senior Developer', '2023-01-15', 8000000),
('EMP002', 'Jane Manager', 'jane.mgr@company.com', '081234567891', 2, 'HR Manager', '2022-03-20', 12000000),
('EMP003', 'Bob Analyst', 'bob.analyst@company.com', '081234567892', 3, 'Financial Analyst', '2023-06-10', 7000000);
