<?php
// Script to create the lesson_feedback table

// Include database configuration
require_once __DIR__ . '/config/config.php';

try {
    // Create PDO connection
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Create the lesson_feedback table
    $sql = "CREATE TABLE IF NOT EXISTS lesson_feedback (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
    echo "Lesson feedback table created successfully!";
    
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
