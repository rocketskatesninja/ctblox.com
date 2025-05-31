<?php
/**
 * Utilities Class
 * 
 * Provides common utility functions for the CTBlox application.
 * This class follows the standardized naming conventions outlined in the coding standards.
 */
class Utilities {
    /**
     * @var Utilities Singleton instance
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
     * @return Utilities
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Sanitize text for HTML output
     * 
     * @param string $text Text to sanitize
     * @return string Sanitized text
     */
    public function sanitizeText($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Format a date according to the specified format
     * 
     * @param string|int $date Date string or timestamp
     * @param string $format Date format (default: Y-m-d H:i:s)
     * @return string Formatted date
     */
    public function formatDate($date, $format = 'Y-m-d H:i:s') {
        if (is_numeric($date)) {
            $timestamp = (int)$date;
        } else {
            $timestamp = strtotime($date);
        }
        
        return date($format, $timestamp);
    }
    
    /**
     * Format a file size in a human-readable format
     * 
     * @param int $bytes Size in bytes
     * @param int $precision Decimal precision (default: 2)
     * @return string Formatted size
     */
    public function formatFileSize($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    
    /**
     * Generate a random string
     * 
     * @param int $length Length of the string (default: 10)
     * @param string $characters Characters to use (default: alphanumeric)
     * @return string Random string
     */
    public function generateRandomString($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
    
    /**
     * Generate a slug from a string
     * 
     * @param string $text Text to convert to slug
     * @return string Slug
     */
    public function generateSlug($text) {
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // Trim
        $text = trim($text, '-');
        
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        
        // Lowercase
        $text = strtolower($text);
        
        return $text;
    }
    
    /**
     * Get client IP address
     * 
     * @return string IP address
     */
    public function getClientIp() {
        $ipAddress = '';
        
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipAddress = 'UNKNOWN';
        }
        
        return $ipAddress;
    }
    
    /**
     * Truncate text to a specified length
     * 
     * @param string $text Text to truncate
     * @param int $length Maximum length
     * @param string $append String to append if truncated (default: ...)
     * @return string Truncated text
     */
    public function truncateText($text, $length, $append = '...') {
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length) . $append;
        }
        
        return $text;
    }
    
    /**
     * Check if a string starts with a specific substring
     * 
     * @param string $haystack String to check
     * @param string $needle Substring to search for
     * @return bool Whether the string starts with the substring
     */
    public function startsWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
    
    /**
     * Check if a string ends with a specific substring
     * 
     * @param string $haystack String to check
     * @param string $needle Substring to search for
     * @return bool Whether the string ends with the substring
     */
    public function endsWith($haystack, $needle) {
        return substr($haystack, -strlen($needle)) === $needle;
    }
    
    /**
     * Convert a string to title case
     * 
     * @param string $string String to convert
     * @return string Title case string
     */
    public function toTitleCase($string) {
        return ucwords(strtolower($string));
    }
    
    /**
     * Clean a filename to ensure it's safe for use
     * 
     * @param string $filename Filename to clean
     * @return string Cleaned filename
     */
    public function cleanFilename($filename) {
        // Remove any path information
        $filename = basename($filename);
        
        // Replace any non-alphanumeric characters except for periods and hyphens
        $filename = preg_replace('/[^a-zA-Z0-9\.\-]/', '_', $filename);
        
        return $filename;
    }
}
