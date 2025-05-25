<?php
/**
 * ActivityLogger - Handles logging of user activities with automatic pruning
 * to maintain a maximum of 50 entries in the activity_log table
 */
class ActivityLogger {
    private $pdo;
    private $maxEntries = 50;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Log an activity and prune old entries if needed
     * 
     * @param string $username The username of the user performing the action
     * @param string $targetUsername The username of the target user (if applicable)
     * @param string $activityType The type of activity (e.g., 'login', 'user_created', 'lesson_completed')
     * @param string $description Additional details about the activity
     * @param string $ipAddress The IP address of the user (optional)
     * @return bool Whether the activity was logged successfully
     */
    public function log($username, $activityType, $targetUsername = null, $description = null, $ipAddress = null) {
        try {
            // Begin transaction
            $this->pdo->beginTransaction();
            
            // Get IP address if not provided
            if ($ipAddress === null && $activityType === 'login') {
                $ipAddress = $this->getClientIP();
            }
            
            // Insert the new activity log entry
            $stmt = $this->pdo->prepare("
                INSERT INTO activity_log (username, target_username, activity_type, description, ip_address) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $success = $stmt->execute([$username, $targetUsername, $activityType, $description, $ipAddress]);
            
            // Count the total number of entries
            $count = $this->pdo->query("SELECT COUNT(*) FROM activity_log")->fetchColumn();
            
            // If we have more than the maximum allowed entries, delete the oldest ones
            if ($count > $this->maxEntries) {
                $deleteCount = $count - $this->maxEntries;
                $this->pdo->exec("
                    DELETE FROM activity_log 
                    WHERE id IN (
                        SELECT id FROM activity_log 
                        ORDER BY activity_date ASC 
                        LIMIT {$deleteCount}
                    )
                ");
            }
            
            // Commit transaction
            $this->pdo->commit();
            return $success;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->pdo->rollBack();
            error_log("Error logging activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear all activity logs from the database
     * 
     * @return bool Whether the operation was successful
     */
    public function clearAll() {
        try {
            $stmt = $this->pdo->prepare("TRUNCATE TABLE activity_log");
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error clearing activity log: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get recent activity logs
     * 
     * @param int $limit Maximum number of entries to retrieve
     * @return array Array of activity log entries
     */
    public function getRecentActivity($limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM activity_log 
                ORDER BY activity_date DESC 
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting recent activity: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get the client's IP address
     * 
     * @return string The client's IP address
     */
    private function getClientIP() {
        // Check for proxy forwarded IP
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            // HTTP_X_FORWARDED_FOR can contain multiple IPs separated by comma
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            return $ip;
        }
        
        // Check for other proxy headers
        $headers = ['HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED'];
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                return $_SERVER[$header];
            }
        }
        
        // Default to REMOTE_ADDR
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
