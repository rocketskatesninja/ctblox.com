<?php
/**
 * Config Class
 * 
 * Provides a centralized configuration system that combines:
 * - Static configuration from config files
 * - Dynamic settings from the database
 * - Environment-specific configuration
 */
class Config {
    /**
     * @var Config Singleton instance
     */
    private static $instance = null;
    
    /**
     * @var array Configuration values
     */
    private $config = [];
    
    /**
     * @var Settings Settings model instance
     */
    private $settings;
    
    /**
     * @var string Current environment (development, testing, production)
     */
    private $environment;
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {
        // Determine environment
        $this->environment = $this->determineEnvironment();
        
        // Load static configuration
        $this->loadStaticConfig();
        
        // Load dynamic settings from database
        $this->loadDynamicSettings();
    }
    
    /**
     * Get singleton instance
     * 
     * @return Config
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Determine the current environment
     * 
     * @return string Environment name (development, testing, production)
     */
    private function determineEnvironment() {
        $serverName = $_SERVER['SERVER_NAME'] ?? '';
        
        if ($serverName === 'localhost' || $serverName === '127.0.0.1') {
            return 'development';
        } elseif (strpos($serverName, 'staging.') === 0 || strpos($serverName, 'test.') === 0) {
            return 'testing';
        } else {
            return 'production';
        }
    }
    
    /**
     * Load static configuration from config files
     */
    private function loadStaticConfig() {
        // Load base configuration
        $configPath = dirname(dirname(__DIR__)) . '/config/config.php';
        if (file_exists($configPath)) {
            // Get defined constants
            $constants = get_defined_constants(true);
            $userConstants = $constants['user'] ?? [];
            
            // Add constants to config array
            foreach ($userConstants as $key => $value) {
                $this->config[$key] = $value;
            }
        }
        
        // Load environment-specific configuration if available
        $envConfigPath = dirname(dirname(__DIR__)) . '/config/' . $this->environment . '.php';
        if (file_exists($envConfigPath)) {
            include $envConfigPath;
            
            // Get newly defined constants
            $newConstants = get_defined_constants(true);
            $newUserConstants = $newConstants['user'] ?? [];
            
            // Add new constants to config array
            foreach ($newUserConstants as $key => $value) {
                if (!isset($this->config[$key])) {
                    $this->config[$key] = $value;
                }
            }
        }
    }
    
    /**
     * Load dynamic settings from database
     */
    private function loadDynamicSettings() {
        // Only load settings if database connection is available
        if (class_exists('Settings')) {
            $this->settings = Settings::getInstance();
            
            // Add database settings to config array
            $dbSettings = $this->settings->getAll();
            foreach ($dbSettings as $key => $value) {
                // Database settings take precedence over file settings
                $this->config[$key] = $value;
            }
        }
    }
    
    /**
     * Get a configuration value
     * 
     * @param string $key Configuration key
     * @param mixed $default Default value if key not found
     * @return mixed Configuration value
     */
    public function get($key, $default = null) {
        return $this->config[$key] ?? $default;
    }
    
    /**
     * Set a dynamic configuration value
     * 
     * @param string $key Configuration key
     * @param mixed $value Configuration value
     * @return bool Success
     */
    public function set($key, $value) {
        if ($this->settings) {
            $result = $this->settings->set($key, $value);
            if ($result) {
                $this->config[$key] = $value;
            }
            return $result;
        }
        return false;
    }
    
    /**
     * Check if a configuration key exists
     * 
     * @param string $key Configuration key
     * @return bool Whether the key exists
     */
    public function has($key) {
        return isset($this->config[$key]);
    }
    
    /**
     * Get all configuration values
     * 
     * @return array All configuration values
     */
    public function all() {
        return $this->config;
    }
    
    /**
     * Get the current environment
     * 
     * @return string Environment name
     */
    public function getEnvironment() {
        return $this->environment;
    }
    
    /**
     * Check if we're in development environment
     * 
     * @return bool
     */
    public function isDevelopment() {
        return $this->environment === 'development';
    }
    
    /**
     * Check if we're in testing environment
     * 
     * @return bool
     */
    public function isTesting() {
        return $this->environment === 'testing';
    }
    
    /**
     * Check if we're in production environment
     * 
     * @return bool
     */
    public function isProduction() {
        return $this->environment === 'production';
    }
}
