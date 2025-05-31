<?php
class User {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Authenticate a user with username and password
     * 
     * @param string $username Username
     * @param string $password Password
     * @return array|bool User data if authenticated, false otherwise
     */
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
                // Temporarily disabled login activity logging
                // $this->logActivity($user['username'], 'login', null, "User logged in", $ipAddress);
                
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
     * @param string $activityType The type of activity
     * @param string|null $targetUsername The username of the target user (if applicable)
     * @param string|null $description Additional details about the activity
     * @param string|null $ipAddress IP address of the user
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
     * Clear the activity log
     * 
     * @return bool Whether the activity log was cleared successfully
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
    
    /**
     * Update the last login timestamp for a user
     * 
     * @param int $userId User ID
     * @return bool Whether the update was successful
     */
    private function updateLastLogin($userId) {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Error updating last login: " . $e->getMessage());
        }
    }
    
    /**
     * Store the user session
     * 
     * @param int $userId User ID
     * @return bool Whether the session was stored successfully
     */
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
    
    /**
     * Get a user by ID
     * 
     * @param int $id User ID
     * @return array|bool User data if found, false otherwise
     */
    public function getUserById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Error getting user by ID: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get a user by ID (alias for getUserById for backward compatibility)
     * 
     * @param int $id User ID
     * @return array|bool User data if found, false otherwise
     * @deprecated Use getUserById() instead
     */
    public function getById($id) {
        return $this->getUserById($id);
    }
    
    
    /**
     * Update a user's profile
     * 
     * @param int $id User ID
     * @param array $data Profile data
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
        } catch (Exception $e) {
            error_log("Error checking email existence: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify a user's password
     * 
     * @param int $userId The user ID
     * @param string $password The password to verify
     * @return bool Whether the password is correct
     */
    /**
     * Check if an email exists (alias for hasEmail for backward compatibility)
     * 
     * @param string $email Email to check
     * @param int|null $excludeUserId User ID to exclude from the check
     * @return bool Whether the email exists
     * @deprecated Use hasEmail() instead
     */
    public function emailExists($email, $excludeUserId = null) {
        return $this->hasEmail($email, $excludeUserId);
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
    /**
     * Update a user's password
     * 
     * @param int $userId User ID
     * @param string $newPassword New password
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
    /**
     * Check if an email is in use (alias for hasEmail for backward compatibility)
     * 
     * @param string $email Email to check
     * @param int|null $excludeUserId User ID to exclude from the check
     * @return bool Whether the email is in use
     * @deprecated Use hasEmail() instead
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
    
    /**
     * Create a new user
     * 
     * @param string $username Username
     * @param string $email Email
     * @param string $password Password
     * @param bool $isAdmin Whether the user is an admin
     * @param bool $isCoach Whether the user is a coach
     * @param int|null $coachId Coach ID if the user is a student
     * @return int|bool User ID if created, false otherwise
     */
    public function createUser($username, $email, $password, $isAdmin = false, $isCoach = false, $coachId = null) {
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
    
    /**
     * Create a new user (alias for createUser for backward compatibility)
     * 
     * @param string $username Username
     * @param string $email Email
     * @param string $password Password
     * @param bool $isAdmin Whether the user is an admin
     * @param bool $isCoach Whether the user is a coach
     * @param int|null $coachId Coach ID if the user is a student
     * @return int|bool User ID if created, false otherwise
     * @deprecated Use createUser() instead
     */
    public function create($username, $email, $password, $isAdmin = false, $isCoach = false, $coachId = null) {
        return $this->createUser($username, $email, $password, $isAdmin, $isCoach, $coachId);
    }
    
    /**
     * Update a user
     * 
     * @param int $id User ID
     * @param array $data User data
     * @return bool Whether the update was successful
     */
    public function updateUser($id, $data) {
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
    
    /**
     * Update a user (alias for updateUser for backward compatibility)
     * 
     * @param int $id User ID
     * @param array $data User data
     * @return bool Whether the update was successful
     * @deprecated Use updateUser() instead
     */
    public function update($id, $data) {
        return $this->updateUser($id, $data);
    }
    
    /**
     * Delete a user
     * 
     * @param int $id User ID
     * @return bool Whether the deletion was successful
     */
    public function deleteUser($id) {
        try {
            // Delete the user
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete a user (alias for deleteUser for backward compatibility)
     * 
     * @param int $id User ID
     * @return bool Whether the deletion was successful
     * @deprecated Use deleteUser() instead
     */
    public function delete($id) {
        return $this->deleteUser($id);
    }
    
    /**
     * Get all users
     * 
     * @return array Users
     */
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
    
    /**
     * Get all coaches
     * 
     * @return array Coaches
     */
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
    
    /**
     * Get students for a coach
     * 
     * @param int $coachId Coach ID
     * @return array Students
     */
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
    
    /**
     * Get active users
     * 
     * @return array Active users
     */
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
    /**
     * Get the client IP address
     * 
     * @return string IP address
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
    
    /**
     * Clean expired sessions
     * 
     * @return bool Whether the cleaning was successful
     */
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
