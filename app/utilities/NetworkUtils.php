<?php
/**
 * NetworkUtils Class
 * 
 * Provides utility methods for network operations.
 */
class NetworkUtils {
    /**
     * @var NetworkUtils Singleton instance
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
     * @return NetworkUtils
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get the client IP address
     * 
     * @return string IP address
     */
    public function getClientIp() {
        // Check for proxy forwarded IP
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        }
        
        // Check for other proxy headers
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED'
        ];
        
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                return trim($_SERVER[$header]);
            }
        }
        
        // Default to REMOTE_ADDR
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    /**
     * Check if an IP address is valid
     * 
     * @param string $ip IP address to check
     * @return bool Whether the IP address is valid
     */
    public function isValidIp($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    
    /**
     * Check if an IP address is in a CIDR range
     * 
     * @param string $ip IP address to check
     * @param string $range CIDR range (e.g., 192.168.1.0/24)
     * @return bool Whether the IP address is in the range
     */
    public function isIpInRange($ip, $range) {
        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }
    
    /**
     * Get the hostname from an IP address
     * 
     * @param string $ip IP address
     * @return string Hostname or the IP address if lookup fails
     */
    public function getHostname($ip) {
        $hostname = gethostbyaddr($ip);
        return $hostname !== false ? $hostname : $ip;
    }
    
    /**
     * Check if the current request is AJAX
     * 
     * @return bool Whether the request is AJAX
     */
    public function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Get the current URL
     * 
     * @param bool $includeQueryString Whether to include the query string (default: true)
     * @return string Current URL
     */
    public function getCurrentUrl($includeQueryString = true) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        
        if (!$includeQueryString && strpos($uri, '?') !== false) {
            $uri = strstr($uri, '?', true);
        }
        
        return $protocol . '://' . $host . $uri;
    }
    
    /**
     * Redirect to a URL
     * 
     * @param string $url URL to redirect to
     * @param int $statusCode HTTP status code (default: 302)
     * @return void
     */
    public function redirect($url, $statusCode = 302) {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
    
    /**
     * Check if a URL is valid
     * 
     * @param string $url URL to check
     * @return bool Whether the URL is valid
     */
    public function isValidUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Get a value from the query string
     * 
     * @param string $key Query parameter key
     * @param mixed $default Default value if key not found
     * @return mixed Query parameter value
     */
    public function getQueryParam($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Get a value from the POST data
     * 
     * @param string $key POST parameter key
     * @param mixed $default Default value if key not found
     * @return mixed POST parameter value
     */
    public function getPostParam($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
}
