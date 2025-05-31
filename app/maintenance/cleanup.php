<?php
/**
 * Database Cleanup Script
 * 
 * This script performs maintenance tasks to prevent database bloat:
 * - Removes old session data beyond PHP's garbage collection
 * - Archives and purges old user progress data
 * - Cleans up other temporary data
 * 
 * Recommended to run as a daily cron job
 */

// Include necessary files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classes/ErrorHandler.php';

// Initialize error handler
ErrorHandler::init();

class DatabaseCleanup {
    private $pdo;
    
    /**
     * Constructor
     */
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Run all cleanup tasks
     */
    public function runAll() {
        $this->cleanupSessions();
        $this->archiveInactiveUserData();
        $this->cleanupTemporaryData();
        $this->logCleanupActivity();
    }
    
    /**
     * Clean up old session data
     * 
     * Removes sessions that are older than the specified time
     * This complements PHP's garbage collection
     */
    public function cleanupSessions() {
        try {
            // Get session count before cleanup
            $beforeCount = $this->pdo->query("SELECT COUNT(*) FROM sessions")->fetchColumn();
            
            // Delete sessions older than 7 days (604800 seconds)
            $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE last_accessed < DATE_SUB(NOW(), INTERVAL 7 DAY)");
            $stmt->execute();
            $deletedCount = $stmt->rowCount();
            
            // Log the result
            error_log("Session cleanup: Removed {$deletedCount} old sessions out of {$beforeCount}");
            
            return $deletedCount;
        } catch (PDOException $e) {
            error_log("Error cleaning up sessions: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Archive inactive user data
     * 
     * Archives progress data for users who haven't been active for a long time
     * and creates a summary record
     */
    public function archiveInactiveUserData() {
        try {
            // Find users who haven't logged in for 90 days
            $stmt = $this->pdo->prepare("
                SELECT id, username 
                FROM users 
                WHERE last_login < DATE_SUB(NOW(), INTERVAL 90 DAY)
            ");
            $stmt->execute();
            $inactiveUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $archivedCount = 0;
            
            foreach ($inactiveUsers as $user) {
                // Begin transaction
                $this->pdo->beginTransaction();
                
                try {
                    // Get user's progress data
                    $progressStmt = $this->pdo->prepare("
                        SELECT lesson_id, COUNT(*) as total_chapters,
                               SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed_chapters
                        FROM progress
                        WHERE user_id = ?
                        GROUP BY lesson_id
                    ");
                    $progressStmt->execute([$user['id']]);
                    $progressData = $progressStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Create archive record
                    $archiveData = [
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'archived_at' => date('Y-m-d H:i:s'),
                        'progress_summary' => json_encode($progressData)
                    ];
                    
                    // Insert into user_data_archive table (create if not exists)
                    $this->ensureArchiveTableExists();
                    
                    $archiveStmt = $this->pdo->prepare("
                        INSERT INTO user_data_archive 
                        (user_id, username, archived_at, progress_summary)
                        VALUES (?, ?, ?, ?)
                    ");
                    $archiveStmt->execute([
                        $archiveData['user_id'],
                        $archiveData['username'],
                        $archiveData['archived_at'],
                        $archiveData['progress_summary']
                    ]);
                    
                    // Delete detailed progress data
                    $deleteStmt = $this->pdo->prepare("DELETE FROM progress WHERE user_id = ?");
                    $deleteStmt->execute([$user['id']]);
                    $deletedRows = $deleteStmt->rowCount();
                    
                    // Commit transaction
                    $this->pdo->commit();
                    $archivedCount++;
                    
                    error_log("Archived data for inactive user {$user['username']} (ID: {$user['id']}). Removed {$deletedRows} progress records.");
                } catch (PDOException $e) {
                    // Rollback on error
                    $this->pdo->rollBack();
                    error_log("Error archiving data for user {$user['username']}: " . $e->getMessage());
                }
            }
            
            error_log("User data archiving: Processed {$archivedCount} inactive users");
            return $archivedCount;
        } catch (PDOException $e) {
            error_log("Error archiving inactive user data: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Ensure the archive table exists
     */
    private function ensureArchiveTableExists() {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS user_data_archive (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                username VARCHAR(50) NOT NULL,
                archived_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                progress_summary TEXT,
                INDEX (user_id),
                INDEX (username)
            )
        ");
    }
    
    /**
     * Clean up temporary data
     * 
     * Removes any temporary data that might accumulate
     */
    public function cleanupTemporaryData() {
        try {
            // Clean up any temporary files or data
            // For now, just a placeholder
            return true;
        } catch (PDOException $e) {
            error_log("Error cleaning up temporary data: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log cleanup activity
     */
    private function logCleanupActivity() {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO activity_log 
                (username, activity_type, description) 
                VALUES ('system', 'maintenance', 'Database cleanup performed')
            ");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error logging cleanup activity: " . $e->getMessage());
            return false;
        }
    }
}

// Run the cleanup
$cleanup = new DatabaseCleanup();
$cleanup->runAll();

echo "Database cleanup completed successfully.\n";
