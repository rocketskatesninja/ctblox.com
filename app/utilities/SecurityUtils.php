<?php
/**
 * SecurityUtils Class
 * 
 * Provides utility methods for security operations.
 */
class SecurityUtils {
    /**
     * @var SecurityUtils Singleton instance
     */
    private static $instance = null;
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {
        // Nothing to initialize
    }
    
    /**
     * Get singleton instance
     * 
     * @return SecurityUtils
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Generate a CSRF token
     * 
     * @return string CSRF token
     */
    public function generateCsrfToken() {
        $tokenName = config('CSRF_TOKEN_NAME', 'csrf_token');
        
        if (!isset($_SESSION[$tokenName])) {
            $_SESSION[$tokenName] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION[$tokenName];
    }
    
    /**
     * Validate a CSRF token
     * 
     * @param string $token Token to validate
     * @return bool Whether the token is valid
     */
    public function validateCsrfToken($token) {
        $tokenName = config('CSRF_TOKEN_NAME', 'csrf_token');
        
        if (!isset($_SESSION[$tokenName]) || empty($token)) {
            return false;
        }
        
        return hash_equals($_SESSION[$tokenName], $token);
    }
    
    /**
     * Hash a password
     * 
     * @param string $password Password to hash
     * @return string Hashed password
     */
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify a password against a hash
     * 
     * @param string $password Password to verify
     * @param string $hash Hash to verify against
     * @return bool Whether the password is valid
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Generate a secure random string
     * 
     * @param int $length Length of the string (default: 32)
     * @return string Random string
     */
    public function generateRandomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Sanitize input to prevent XSS attacks
     * 
     * @param string $input Input to sanitize
     * @return string Sanitized input
     */
    public function sanitizeInput($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Check if a user is logged in
     * 
     * @return bool Whether the user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Check if a user has a specific role
     * 
     * @param string $role Role to check (admin, coach, student)
     * @return bool Whether the user has the role
     */
    public function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        switch ($role) {
            case 'admin':
                return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
            case 'coach':
                return isset($_SESSION['is_coach']) && $_SESSION['is_coach'] === true;
            case 'student':
                return !isset($_SESSION['is_admin']) && !isset($_SESSION['is_coach']);
            default:
                return false;
        }
    }
    
    /**
     * Log out the current user
     * 
     * @return void
     */
    public function logout() {
        // Unset all session variables
        $_SESSION = [];
        
        // If it's desired to kill the session, also delete the session cookie.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Finally, destroy the session
        session_destroy();
    }
    
    /**
     * Generate a secure token for password reset or email verification
     * 
     * @param string $identifier User identifier (e.g., user ID or email)
     * @param int $expiry Expiry time in seconds (default: 1 hour)
     * @return string Secure token
     */
    public function generateSecureToken($identifier, $expiry = 3600) {
        $timestamp = time() + $expiry;
        $data = $identifier . '|' . $timestamp;
        $hash = hash_hmac('sha256', $data, config('APP_KEY', 'default_key'));
        
        return base64_encode($data . '|' . $hash);
    }
    
    /**
     * Validate a secure token
     * 
     * @param string $token Token to validate
     * @param string $identifier Expected user identifier
     * @return bool Whether the token is valid
     */
    public function validateSecureToken($token, $identifier) {
        $decoded = base64_decode($token);
        
        if ($decoded === false) {
            return false;
        }
        
        $parts = explode('|', $decoded);
        
        if (count($parts) !== 3) {
            return false;
        }
        
        list($tokenIdentifier, $timestamp, $hash) = $parts;
        
        // Check if the token has expired
        if (time() > $timestamp) {
            return false;
        }
        
        // Check if the identifier matches
        if ($tokenIdentifier !== $identifier) {
            return false;
        }
        
        // Verify the hash
        $data = $tokenIdentifier . '|' . $timestamp;
        $expectedHash = hash_hmac('sha256', $data, config('APP_KEY', 'default_key'));
        
        return hash_equals($expectedHash, $hash);
    }
}
