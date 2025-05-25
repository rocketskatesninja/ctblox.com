<?php
class User {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    public function authenticate($username, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Update last login
                $this->updateLastLogin($user['id']);
                
                // Log the login activity with IP address
                $ipAddress = $this->getClientIP();
                $this->logActivity($user['username'], 'login', null, "User logged in from IP: {$ipAddress}", $ipAddress);
                
                return $user; // Return the user data instead of true
            }
            return false;
        } catch (Exception $e) {
            error_log("Authentication error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log a user activity
     * 
     * @param string $username The username of the user performing the action
     * @param string $targetUsername The username of the target user (if applicable)
     * @param string $activityType The type of activity
     * @param string $description Additional details about the activity
     * @return bool Whether the activity was logged successfully
     */
    public function logActivity($username, $activityType, $targetUsername = null, $description = null, $ipAddress = null) {
        try {
            // Use the ActivityLogger class if it exists
            if (class_exists('ActivityLogger')) {
                $logger = new ActivityLogger();
                return $logger->log($username, $activityType, $targetUsername, $description, $ipAddress);
            }
            
            // Fallback to direct database insert if ActivityLogger doesn't exist
            $stmt = $this->pdo->prepare("
                INSERT INTO activity_log (username, target_username, activity_type, description, ip_address) 
                VALUES (?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$username, $targetUsername, $activityType, $description, $ipAddress]);
        } catch (Exception $e) {
            error_log("Error logging activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear all activity logs from the database
     * 
     * @return bool Whether the operation was successful
     */
    public function clearActivityLog() {
        try {
            // Use the ActivityLogger class if it exists
            if (class_exists('ActivityLogger')) {
                $logger = new ActivityLogger();
                return $logger->clearAll();
            }
            
            // Fallback to direct database truncate if ActivityLogger doesn't exist
            $stmt = $this->pdo->prepare("TRUNCATE TABLE activity_log");
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error clearing activity log: " . $e->getMessage());
            return false;
        }
    }
    
    private function updateLastLogin($userId) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Error updating last login: " . $e->getMessage());
        }
    }
    
    private function storeSession($userId) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO active_sessions (user_id, session_id)
                VALUES (?, ?)
            ");
            $stmt->execute([$userId, session_id()]);
        } catch (PDOException $e) {
            error_log("Error storing session: " . $e->getMessage());
        }
    }
    
    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting user: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user by ID with additional profile information
     * 
     * @param int $id The user ID
     * @return array|false The user data or false on failure
     */
    public function getUserById($id) {
        return $this->getById($id);
    }
    
    /**
     * Update user profile information
     * 
     * @param int $id The user ID
     * @param array $data The profile data to update
     * @return bool Whether the update was successful
     */
    public function updateProfile($id, $data) {
        try {
            // Validate email uniqueness if it's being updated
            if (isset($data['email'])) {
                if ($this->emailExists($data['email'], $id)) {
                    return false;
                }
            }
            
            $fields = [];
            $values = [];
            
            // Only update fields that are provided
            foreach (['name', 'email', 'bio'] as $field) {
                if (isset($data[$field])) {
                    $fields[] = "$field = ?";
                    $values[] = $data[$field];
                }
            }
            
            if (empty($fields)) {
                return true; // Nothing to update
            }
            
            // Add user ID to values
            $values[] = $id;
            
            $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Error updating profile: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if an email exists (excluding the specified user)
     * 
     * @param string $email The email to check
     * @param int $excludeUserId The user ID to exclude from the check
     * @return bool Whether the email exists
     */
    public function emailExists($email, $excludeUserId = null) {
        return $this->isEmailInUse($email, $excludeUserId);
    }
    
    /**
     * Verify a user's password
     * 
     * @param int $userId The user ID
     * @param string $password The password to verify
     * @return bool Whether the password is correct
     */
    public function verifyPassword($userId, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Error verifying password: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update a user's password
     * 
     * @param int $userId The user ID
     * @param string $newPassword The new password
     * @return bool Whether the update was successful
     */
    public function updatePassword($userId, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $userId]);
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if an email address is already in use
     * 
     * @param string $email The email address to check
     * @param int|null $excludeUserId Optional user ID to exclude from the check (for updates)
     * @return bool True if the email is already in use, false otherwise
     */
    public function isEmailInUse($email, $excludeUserId = null) {
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
            error_log("Error checking email uniqueness: " . $e->getMessage());
            return false; // Assume it's not in use to avoid blocking legitimate operations
        }
    }
    
    public function create($username, $email, $password, $isAdmin = false, $isCoach = false, $coachId = null) {
        try {
            // Check user limit
            $userCount = $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
            $maxUsers = $this->pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'max_users'")->fetchColumn();
            
            if ($userCount >= $maxUsers) {
                throw new Exception("Maximum user limit reached");
            }
            
            // Check for duplicate email
            if ($this->isEmailInUse($email)) {
                throw new Exception("Email address is already in use");
            }
            
            // Ensure boolean values are integers (1 or 0)
            $isAdmin = (int)$isAdmin;
            $isCoach = (int)$isCoach;
            
            // Validate coach_id if provided
            if ($coachId !== null) {
                // Check if the coach exists and is actually a coach
                $coachCheck = $this->pdo->prepare("SELECT id FROM users WHERE id = ? AND is_coach = 1");
                $coachCheck->execute([$coachId]);
                if (!$coachCheck->fetch()) {
                    $coachId = null; // Reset if invalid coach
                }
            }
            
            $stmt = $this->pdo->prepare("
                INSERT INTO users (username, email, password, is_admin, is_coach, coach_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $isAdmin,
                $isCoach,
                $coachId
            ]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }
    
    public function update($id, $data) {
        try {
            // Check for duplicate email if email is being updated
            if (isset($data['email']) && !empty($data['email'])) {
                if ($this->isEmailInUse($data['email'], $id)) {
                    throw new Exception("Email address is already in use by another account");
                }
            }
            
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                // Special handling for password
                if ($key === 'password' && !empty($value)) {
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                
                // Special handling for boolean fields (can be 0 which is falsy)
                if ($key === 'is_admin' || $key === 'is_coach' || !empty($value)) {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            if (empty($fields)) return true;
            
            $values[] = $id;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($id) {
        try {
            // Delete the user
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllUsers() {
        try {
            return $this->pdo->query("
                SELECT u.id, u.username, u.email, u.is_admin, u.is_coach, u.coach_id,
                       c.username as coach_name, u.last_login, u.created_at 
                FROM users u
                LEFT JOIN users c ON u.coach_id = c.id
                ORDER BY u.created_at DESC
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting users: " . $e->getMessage());
            return [];
        }
    }
    
    public function getCoaches() {
        try {
            return $this->pdo->query("
                SELECT id, username, email
                FROM users
                WHERE is_coach = 1
                ORDER BY username ASC
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting coaches: " . $e->getMessage());
            return [];
        }
    }
    
    public function getStudents($coachId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, username, email, last_login, created_at
                FROM users
                WHERE coach_id = ?
                ORDER BY username ASC
            ");
            $stmt->execute([$coachId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting students: " . $e->getMessage());
            return [];
        }
    }
    
    public function getActiveUsers() {
        try {
            return $this->pdo->query("
                SELECT u.username, u.email, s.last_activity
                FROM active_sessions s
                JOIN users u ON s.user_id = u.id
                WHERE s.last_activity > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
                ORDER BY s.last_activity DESC
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting active users: " . $e->getMessage());
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
    
    public function cleanExpiredSessions() {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM active_sessions 
                WHERE last_activity < DATE_SUB(NOW(), INTERVAL ? SECOND)
            ");
            $stmt->execute([SESSION_LIFETIME]);
        } catch (PDOException $e) {
            error_log("Error cleaning sessions: " . $e->getMessage());
        }
    }
}
