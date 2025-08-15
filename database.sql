CREATE DATABASE IF NOT EXISTS `crud_ajax` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `crud_ajax`;

-- Tabel master_role untuk daftar role
CREATE TABLE IF NOT EXISTS `master_role` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `role_name` VARCHAR(50) NOT NULL
);

-- Isi data awal master_role
INSERT INTO `master_role` (`role_name`) VALUES
('Admin'),
('Manager'),
('User');

-- Tabel users dengan relasi ke master_role
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`name`, `username`, `email`, `password`, `role_id`, `is_active`, `last_login`) VALUES
('John Doe', 'johndoe', 'john.doe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, NOW()),
('Jane Smith', 'janesmith', 'jane.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, NOW()),
('Mike Johnson', 'mikejohnson', 'mike.johnson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 0, NOW()),
('Sarah Wilson', 'sarahwilson', 'sarah.wilson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, NOW()),
('David Brown', 'davidbrown', 'david.brown@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, NOW());

DESCRIBE `users`;

SELECT * FROM `users` ORDER BY `id` DESC;

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

-- Contoh query JOIN untuk menampilkan user beserta nama role
SELECT u.*, r.role_name
FROM users u
JOIN master_role r ON u.role_id = r.id;
