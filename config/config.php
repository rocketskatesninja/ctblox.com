<?php
/**
 * Main Configuration File
 * 
 * This file contains the base configuration for the CTBlox application.
 * Environment-specific configuration should be placed in the corresponding
 * environment file (development.php, testing.php, production.php).
 */

// Base paths
define('APP_PATH', dirname(__DIR__));
define('PUBLIC_PATH', APP_PATH . '/public');
define('LOGS_PATH', APP_PATH . '/logs');
define('LESSONS_PATH', APP_PATH . '/app/lessons');

// Application configuration
define('APP_NAME', 'CTBlox Training Platform');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://test');
define('APP_DEBUG', false); // Override in environment-specific config

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ctblox');
define('DB_USER', 'ctblox_user');
define('DB_PASS', 'ctblox_password');

// Security configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 300); // 5 minutes
define('CSRF_TOKEN_NAME', 'csrf_token');

// Email configuration
define('SMTP_HOST', '');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_FROM', 'noreply@corporatetools.com');
define('SMTP_FROM_NAME', 'CTBlox Training');

// Upload configuration
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');
define('ASSETS_URL', '/assets');
define('UPLOADS_URL', '/uploads');

// Default error reporting
define('ERROR_REPORTING_LEVEL', E_ALL);
define('DISPLAY_ERRORS', false); // Override in environment-specific config
define('LOG_ERRORS', true);
define('ERROR_LOG', LOGS_PATH . '/error.log');

// Apply error reporting settings
error_reporting(ERROR_REPORTING_LEVEL);
ini_set('display_errors', DISPLAY_ERRORS ? 1 : 0);
ini_set('log_errors', LOG_ERRORS ? 1 : 0);
ini_set('error_log', ERROR_LOG);

// Initialize database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please check the configuration.");
}

// Include the DatabaseSessionHandler
require_once APP_PATH . '/app/classes/DatabaseSessionHandler.php';

// Session configuration
ini_set('session.cookie_httponly', 1);
// Session security settings
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Session timeout settings
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

// Configure session parameters before starting the session
ini_set('session.gc_maxlifetime', SESSION_LIFETIME); // Server-side session timeout

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => SESSION_LIFETIME,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Initialize the database session handler
$sessionHandler = new DatabaseSessionHandler($pdo);
session_set_save_handler($sessionHandler, true);

// Start the session
session_start();

// Check if we need to refresh the session expiry time
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    // Update last activity time stamp
    $_SESSION['last_activity'] = time();
}

// Set last activity timestamp if not set
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}
