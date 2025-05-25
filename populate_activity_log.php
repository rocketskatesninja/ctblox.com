<?php
// Include the config file to get database connection
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/classes/ActivityLogger.php';

// Check if the activity_log table exists
$tableExists = $pdo->query("SHOW TABLES LIKE 'activity_log'")->rowCount() > 0;
echo "Activity log table exists: " . ($tableExists ? "Yes" : "No") . "\n";

if (!$tableExists) {
    // Create the activity_log table if it doesn't exist
    echo "Creating activity_log table...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS activity_log (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL,
            target_username VARCHAR(50),
            activity_type VARCHAR(50) NOT NULL,
            description TEXT,
            activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Table created successfully.\n";
}

// Create ActivityLogger instance
$logger = new ActivityLogger();

// Get some sample data to populate the activity log
$users = $pdo->query("SELECT username FROM users LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
$lessons = $pdo->query("SELECT title FROM lessons LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);

if (empty($users)) {
    echo "No users found to create sample activities.\n";
    exit;
}

echo "Populating activity log with sample data...\n";

// Sample activities
$activityTypes = ['login', 'completed_lesson', 'new_user', 'user_deleted'];
$descriptions = [
    'login' => 'User logged in',
    'completed_lesson' => 'Completed lesson',
    'new_user' => 'New user registration',
    'user_deleted' => 'User account deleted'
];

// Add some sample activities
for ($i = 0; $i < 20; $i++) {
    $username = $users[array_rand($users)];
    $activityType = $activityTypes[array_rand($activityTypes)];
    $description = $descriptions[$activityType];
    
    if ($activityType === 'completed_lesson' && !empty($lessons)) {
        $description .= ': ' . $lessons[array_rand($lessons)];
    }
    
    $targetUsername = ($activityType === 'user_deleted' || $activityType === 'new_user') 
        ? 'user' . rand(1, 100) 
        : null;
    
    // Add activity with a random timestamp within the last 7 days
    $timestamp = date('Y-m-d H:i:s', time() - rand(0, 7 * 24 * 60 * 60));
    
    $stmt = $pdo->prepare("
        INSERT INTO activity_log (username, target_username, activity_type, description, activity_date) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$username, $targetUsername, $activityType, $description, $timestamp]);
    
    echo "Added activity: $username - $activityType - $description\n";
}

echo "\nActivity log populated successfully.\n";

// Count entries in the activity_log table
$count = $pdo->query("SELECT COUNT(*) FROM activity_log")->fetchColumn();
echo "Total entries in activity_log: $count\n";
