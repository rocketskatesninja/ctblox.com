<?php
/**
 * Application Configuration Bootstrap
 * 
 * This file bootstraps the application configuration and includes common helpers.
 */

// Include the main config
require_once dirname(dirname(__DIR__)) . '/config/config.php';

// Include the ErrorHandler class
require_once __DIR__ . '/../classes/ErrorHandler.php';

// Common functions
function generate_csrf_token() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function sanitize($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function flash($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

// Set default timezone
date_default_timezone_set('America/New_York');

// Configure error display based on environment
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    // Development environment
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Production environment
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Always log errors
ini_set('log_errors', 1);
ini_set('error_log', APP_PATH . '/logs/error.log');

// Initialize database connection if not already done
if (!isset($pdo)) {
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
}
