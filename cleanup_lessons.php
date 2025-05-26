<?php
// Include necessary files
require_once __DIR__ . '/app/includes/config.php';

// Define database connection
$host = 'localhost';
$dbname = 'ctblox';
$username = 'ctblox_user';
$password = 'ctblox_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Define lessons path
define('LESSONS_PATH', __DIR__ . '/app/lessons');

// Connection already established above

echo "Starting lesson cleanup...\n";

// Get all lessons from the database
$stmt = $pdo->query('SELECT id, filename FROM lessons');
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($lessons) . " lessons in the database.\n";

// Check if each lesson directory exists
$deleted = 0;
foreach ($lessons as $lesson) {
    $lessonDir = LESSONS_PATH . '/' . $lesson['filename'];
    
    if (!is_dir($lessonDir)) {
        echo "Lesson directory not found: {$lesson['filename']} (ID: {$lesson['id']})\n";
        
        // Delete the lesson from the database
        $deleteStmt = $pdo->prepare("DELETE FROM lessons WHERE id = ?");
        if ($deleteStmt->execute([$lesson['id']])) {
            echo "Deleted lesson from database: {$lesson['filename']} (ID: {$lesson['id']})\n";
            $deleted++;
        } else {
            echo "Failed to delete lesson from database: {$lesson['filename']} (ID: {$lesson['id']})\n";
        }
    }
}

echo "Cleanup complete. Deleted $deleted lessons from the database.\n";
echo "Please run a new scan from the admin panel to update the available lessons.\n";
