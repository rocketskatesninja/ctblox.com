<?php
// Include database connection
require_once __DIR__ . '/app/includes/database.php';

// Check if the activity_log table exists
$tableExists = $pdo->query("SHOW TABLES LIKE 'activity_log'")->rowCount() > 0;
echo "Activity log table exists: " . ($tableExists ? "Yes" : "No") . "\n";

if ($tableExists) {
    // Count entries in the activity_log table
    $count = $pdo->query("SELECT COUNT(*) FROM activity_log")->fetchColumn();
    echo "Number of entries in activity_log: $count\n";
    
    // Get the first 5 entries
    $entries = $pdo->query("SELECT * FROM activity_log ORDER BY activity_date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($entries) > 0) {
        echo "Recent entries:\n";
        foreach ($entries as $entry) {
            echo "ID: {$entry['id']}, Username: {$entry['username']}, Type: {$entry['activity_type']}, Date: {$entry['activity_date']}\n";
        }
    } else {
        echo "No entries found in the activity_log table.\n";
    }
} else {
    // Check if the table is defined in the create_database.sql file
    echo "Checking if activity_log is defined in create_database.sql...\n";
    $sqlFile = file_get_contents(__DIR__ . '/database/create_database.sql');
    echo "Table definition found: " . (strpos($sqlFile, 'CREATE TABLE IF NOT EXISTS activity_log') !== false ? "Yes" : "No") . "\n";
}

// Check the AdminController's dashboard method
echo "\nChecking AdminController implementation:\n";
$adminController = file_get_contents(__DIR__ . '/app/controllers/AdminController.php');
$activityLoggerUsed = strpos($adminController, 'ActivityLogger') !== false;
echo "ActivityLogger is used in AdminController: " . ($activityLoggerUsed ? "Yes" : "No") . "\n";

// Check if the old activity collection method is still being used
$oldMethodUsed = strpos($adminController, '$recentActivity = array_merge($completedLessons, $newUsers, $deletedUsers);') !== false;
echo "Old activity collection method is still used: " . ($oldMethodUsed ? "Yes" : "No") . "\n";

// Check if the ActivityLogger class exists
echo "\nChecking if ActivityLogger class exists:\n";
$activityLoggerExists = file_exists(__DIR__ . '/app/classes/ActivityLogger.php');
echo "ActivityLogger.php file exists: " . ($activityLoggerExists ? "Yes" : "No") . "\n";

if ($activityLoggerExists) {
    $activityLoggerContent = file_get_contents(__DIR__ . '/app/classes/ActivityLogger.php');
    echo "ActivityLogger class has log method: " . (strpos($activityLoggerContent, 'public function log') !== false ? "Yes" : "No") . "\n";
}
