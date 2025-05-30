<?php
/**
 * Settings Model
 * 
 * Handles all operations related to application settings
 */
class Settings {
    private $pdo;
    private static $instance = null;
    private $cache = [];
    
    /**
     * Constructor
     */
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->loadSettings();
    }
    
    /**
     * Get singleton instance
     * 
     * @return Settings
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Load all settings into cache
     */
    private function loadSettings() {
        try {
            $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM settings");
            while ($row = $stmt->fetch()) {
                $this->cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (PDOException $e) {
            error_log("Error loading settings: " . $e->getMessage());
        }
    }
    
    /**
     * Get a setting value
     * 
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed Setting value
     */
    public function get($key, $default = null) {
        return isset($this->cache[$key]) ? $this->cache[$key] : $default;
    }
    
    /**
     * Get all settings
     * 
     * @return array All settings
     */
    public function getAll() {
        return $this->cache;
    }
    
    /**
     * Set a setting value
     * 
     * @param string $key Setting key
     * @param mixed $value Setting value
     * @return bool Success
     */
    public function set($key, $value) {
        try {
            // Update in database
            $stmt = $this->pdo->prepare("
                INSERT INTO settings (setting_key, setting_value) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?
            ");
            $result = $stmt->execute([$key, $value, $value]);
            
            // Update in cache
            if ($result) {
                $this->cache[$key] = $value;
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error setting setting: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Set multiple settings at once
     * 
     * @param array $settings Associative array of settings
     * @return bool Success
     */
    public function setMultiple($settings) {
        try {
            $this->pdo->beginTransaction();
            
            foreach ($settings as $key => $value) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO settings (setting_key, setting_value) 
                    VALUES (?, ?) 
                    ON DUPLICATE KEY UPDATE setting_value = ?
                ");
                $stmt->execute([$key, $value, $value]);
                $this->cache[$key] = $value;
            }
            
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error setting multiple settings: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete a setting
     * 
     * @param string $key Setting key
     * @return bool Success
     */
    public function delete($key) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM settings WHERE setting_key = ?");
            $result = $stmt->execute([$key]);
            
            if ($result && isset($this->cache[$key])) {
                unset($this->cache[$key]);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error deleting setting: " . $e->getMessage());
            return false;
        }
    }
}
