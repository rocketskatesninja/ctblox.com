<?php
/**
 * UserRepository Class
 * 
 * Provides database operations specific to the User model.
 * Extends the DatabaseRepository class for common database operations.
 */
class UserRepository extends DatabaseRepository {
    /**
     * Constructor
     * 
     * @param PDO $pdo Optional PDO connection (uses global $pdo if not provided)
     */
    public function __construct($pdo = null) {
        parent::__construct('users', $pdo);
    }
    
    /**
     * Get a user by username
     * 
     * @param string $username Username
     * @return array|bool User data if found, false otherwise
     */
    public function getByUsername($username) {
        return $this->findBy('username', $username);
    }
    
    /**
     * Get a user by email
     * 
     * @param string $email Email
     * @return array|bool User data if found, false otherwise
     */
    public function getByEmail($email) {
        return $this->findBy('email', $email);
    }
    
    /**
     * Check if an email exists
     * 
     * @param string $email Email to check
     * @param int|null $excludeUserId User ID to exclude from the check
     * @return bool Whether the email exists
     */
    public function hasEmail($email, $excludeUserId = null) {
        try {
            if ($excludeUserId) {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $excludeUserId]);
            } else {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                $stmt->execute([$email]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            $this->logError("Error checking email existence", $e);
            return false;
        }
    }
    
    /**
     * Get all coaches
     * 
     * @return array Coaches
     */
    public function getCoaches() {
        return $this->findWhere(['is_coach' => 1], ['*'], 'username ASC');
    }
    
    /**
     * Get students for a coach
     * 
     * @param int $coachId Coach ID
     * @return array Students
     */
    public function getStudents($coachId) {
        return $this->findWhere(['coach_id' => $coachId], ['*'], 'username ASC');
    }
    
    /**
     * Get active users
     * 
     * @return array Active users
     */
    public function getActiveUsers() {
        return $this->findWhere(['active' => 1], ['*'], 'last_login DESC');
    }
    
    /**
     * Update a user's last login timestamp
     * 
     * @param int $userId User ID
     * @return bool Whether the update was successful
     */
    public function updateLastLogin($userId) {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
    
    /**
     * Verify a user's password
     * 
     * @param int $userId User ID
     * @param string $password Password to verify
     * @return bool Whether the password is correct
     */
    public function verifyPassword($userId, $password) {
        try {
            $user = $this->find($userId, ['password']);
            
            if (!$user) {
                return false;
            }
            
            return password_verify($password, $user['password']);
        } catch (PDOException $e) {
            $this->logError("Error verifying password", $e);
            return false;
        }
    }
    
    /**
     * Update a user's password
     * 
     * @param int $userId User ID
     * @param string $newPassword New password
     * @return bool Whether the update was successful
     */
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
    
    /**
     * Create a new user
     * 
     * @param array $userData User data
     * @return int|bool User ID if created, false otherwise
     */
    public function createUser($userData) {
        // Hash the password if provided
        if (isset($userData['password'])) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }
        
        // Set default values
        $userData['created_at'] = $userData['created_at'] ?? date('Y-m-d H:i:s');
        $userData['active'] = $userData['active'] ?? 1;
        
        return $this->insert($userData);
    }
    
    /**
     * Clean expired sessions
     * 
     * @param int $lifetime Session lifetime in seconds
     * @return bool Whether the cleaning was successful
     */
    public function cleanExpiredSessions($lifetime = 3600) {
        try {
            $expiryTime = date('Y-m-d H:i:s', time() - $lifetime);
            $stmt = $this->pdo->prepare("DELETE FROM active_sessions WHERE created_at < ?");
            return $stmt->execute([$expiryTime]);
        } catch (PDOException $e) {
            $this->logError("Error cleaning expired sessions", $e);
            return false;
        }
    }
    
    /**
     * Log a user activity
     * 
     * @param string $username The username of the user performing the action
     * @param string $activityType The type of activity
     * @param string|null $targetUsername The username of the target user (if applicable)
     * @param string|null $description Additional details about the activity
     * @param string|null $ipAddress IP address of the user
     * @return bool Whether the activity was logged successfully
     */
    public function logActivity($username, $activityType, $targetUsername = null, $description = null, $ipAddress = null) {
        try {
            $data = [
                'username' => $username,
                'activity_type' => $activityType,
                'target_username' => $targetUsername,
                'description' => $description,
                'ip_address' => $ipAddress,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $activityRepo = new DatabaseRepository('activity_log');
            return $activityRepo->insert($data) !== false;
        } catch (PDOException $e) {
            $this->logError("Error logging activity", $e);
            return false;
        }
    }
    
    /**
     * Clear the activity log
     * 
     * @return bool Whether the activity log was cleared successfully
     */
    public function clearActivityLog() {
        try {
            $activityRepo = new DatabaseRepository('activity_log');
            return $activityRepo->execute("TRUNCATE TABLE activity_log");
        } catch (PDOException $e) {
            $this->logError("Error clearing activity log", $e);
            return false;
        }
    }
}
