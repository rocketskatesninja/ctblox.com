<?php
/**
 * Helper Functions
 * 
 * This file contains global helper functions for the CTBlox application.
 */

/**
 * Get a configuration value
 * 
 * @param string $key Configuration key
 * @param mixed $default Default value if key not found
 * @return mixed Configuration value
 */
function config($key = null, $default = null) {
    $config = Config::getInstance();
    
    if ($key === null) {
        return $config->all();
    }
    
    return $config->get($key, $default);
}

/**
 * Check if the application is running in development environment
 * 
 * @return bool
 */
function is_development() {
    return Config::getInstance()->isDevelopment();
}

/**
 * Check if the application is running in testing environment
 * 
 * @return bool
 */
function is_testing() {
    return Config::getInstance()->isTesting();
}

/**
 * Check if the application is running in production environment
 * 
 * @return bool
 */
function is_production() {
    return Config::getInstance()->isProduction();
}

/**
 * Get the current environment
 * 
 * @return string Environment name
 */
function get_environment() {
    return Config::getInstance()->getEnvironment();
}

/**
 * Format a path for the current operating system
 * 
 * @param string $path Path to format
 * @return string Formatted path
 */
function path($path) {
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
}

/**
 * Get the absolute path to a resource
 * 
 * @param string $path Relative path
 * @return string Absolute path
 */
function resource_path($path = '') {
    return APP_PATH . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
}

/**
 * Get the URL for an asset
 * 
 * @param string $path Asset path
 * @return string Asset URL
 */
function asset($path) {
    $assetsUrl = config('ASSETS_URL', '/assets');
    return $assetsUrl . '/' . ltrim($path, '/');
}

/**
 * Get the URL for an upload
 * 
 * @param string $path Upload path
 * @return string Upload URL
 */
function upload_url($path) {
    $uploadsUrl = config('UPLOADS_URL', '/uploads');
    return $uploadsUrl . '/' . ltrim($path, '/');
}

/**
 * Sanitize output for HTML display
 * 
 * @param string $text Text to sanitize
 * @return string Sanitized text
 */
function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Set a flash message
 * 
 * @param string $message Flash message
 * @param string $type Message type (info, success, warning, error)
 */
function flash($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Generate a CSRF token
 * 
 * @return string CSRF token
 */
function csrf_token() {
    $tokenName = config('CSRF_TOKEN_NAME', 'csrf_token');
    
    if (!isset($_SESSION[$tokenName])) {
        $_SESSION[$tokenName] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION[$tokenName];
}

/**
 * Generate a CSRF token field
 * 
 * @return string HTML input field with CSRF token
 */
function csrf_field() {
    $token = csrf_token();
    return '<input type="hidden" name="' . config('CSRF_TOKEN_NAME', 'csrf_token') . '" value="' . $token . '">';
}
