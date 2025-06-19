CREATE DATABASE mvc_app;
USE mvc_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    status ENUM('todo', 'in_progress', 'done') DEFAULT 'todo',
    position INT DEFAULT 0,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user (password: password)
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample tasks
INSERT INTO tasks (title, description, status, position, user_id) VALUES
('Setup Development Environment', 'Install PHP, MySQL, and configure Apache server', 'done', 0, 1),
('Create User Authentication', 'Implement login and registration system', 'done', 1, 1),
('Build Dashboard UI', 'Design responsive dashboard with Bootstrap', 'in_progress', 0, 1),
('Implement Drag & Drop', 'Add Kanban board with SortableJS', 'todo', 0, 1),
('Add User Management', 'CRUD operations for user administration', 'todo', 1, 1),
('Security Hardening', 'Add CSRF protection and input validation', 'todo', 2, 1);