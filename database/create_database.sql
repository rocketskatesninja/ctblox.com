-- Create the database and user
CREATE DATABASE IF NOT EXISTS ctblox;
USE ctblox;

CREATE USER IF NOT EXISTS 'ctblox_user'@'localhost' IDENTIFIED BY 'ctblox_password';
GRANT ALL PRIVILEGES ON ctblox.* TO 'ctblox_user'@'localhost';
FLUSH PRIVILEGES;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    bio TEXT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    is_coach BOOLEAN DEFAULT FALSE,
    coach_id INT NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Lessons table
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    author VARCHAR(100),
    version VARCHAR(20),
    language VARCHAR(10) DEFAULT 'en',
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Chapters table
CREATE TABLE chapters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    chapter_id VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    sequence INT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    UNIQUE KEY unique_chapter (lesson_id, chapter_id)
);

-- Progress table
CREATE TABLE progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    lesson_id INT,
    chapter_id VARCHAR(50),
    completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

-- Quiz results table
CREATE TABLE quiz_results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    lesson_id INT,
    chapter_id VARCHAR(50),
    score INT,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

-- Settings table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Active sessions table
CREATE TABLE active_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    user_type VARCHAR(20) DEFAULT 'student',
    session_id VARCHAR(255) NOT NULL,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, is_admin) 
VALUES ('admin', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'admin@example.com', TRUE);

-- Insert default coach user (password: admin123)
INSERT INTO users (username, password, email, is_coach) 
VALUES ('coach', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'coach@example.com', TRUE);

-- Get the coach ID for student assignments
SET @coach_id = LAST_INSERT_ID();

-- Insert sample student users (password: admin123)
INSERT INTO users (username, password, email, coach_id) 
VALUES 
('student1', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'student1@example.com', @coach_id),
('student2', '$2y$10$8K1p/a0dL1LXMIhuZ5Mw8.XZh.MwF1T5MCqwJ7mGBB6AAVt.pq3PC', 'student2@example.com', @coach_id);

-- Sessions table for database session handling
CREATE TABLE sessions (
    id VARCHAR(128) PRIMARY KEY,
    data TEXT,
    last_accessed TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO settings (setting_key, setting_value) VALUES
('max_users', '100'),
('smtp_host', ''),
('smtp_port', '587'),
('smtp_user', ''),
('smtp_pass', ''),
('smtp_from', 'noreply@corporatetools.com'),
('smtp_from_name', 'CTBlox Training'),
('allowed_ip_ranges', '["*"]'),
('certificate_template', 'default'),
('session_lifetime', '3600');

-- Create activity_log table for tracking user activities
CREATE TABLE IF NOT EXISTS activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    target_username VARCHAR(50),
    activity_type VARCHAR(50) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45) DEFAULT NULL,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create lesson_feedback table for collecting user feedback on lessons
CREATE TABLE IF NOT EXISTS lesson_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    lesson_id INT NOT NULL,
    rating VARCHAR(20) NOT NULL,
    comments TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    UNIQUE KEY unique_feedback (user_id, lesson_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

-- Create lesson_assignments table for tracking coach assignments
CREATE TABLE IF NOT EXISTS lesson_assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    lesson_id INT NOT NULL,
    assigned_by INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (user_id, lesson_id)
);
