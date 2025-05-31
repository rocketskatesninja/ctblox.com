<?php
/**
 * SettingsRepository Class
 * 
 * Provides database operations specific to application settings.
 * Extends the DatabaseRepository class for common database operations.
 */
class SettingsRepository extends DatabaseRepository {
    /**
     * @var array Settings cache
     */
    private $cache = [];
    
    /**
     * @var bool Whether the settings have been loaded
     */
    private $loaded = false;
    
    /**
     * Constructor
     * 
     * @param PDO $pdo Optional PDO connection (uses global $pdo if not provided)
     */
    public function __construct($pdo = null) {
        parent::__construct('settings', $pdo);
    }
    
    /**
     * Load all settings into cache
     * 
     * @return void
     */
    private function loadSettings() {
        if ($this->loaded) {
            return;
        }
        
        try {
            $settings = $this->getAll();
            
            foreach ($settings as $setting) {
                $this->cache[$setting['key']] = $this->unserializeValue($setting['value'], $setting['type']);
            }
            
            $this->loaded = true;
        } catch (PDOException $e) {
            $this->logError("Error loading settings", $e);
        }
    }
    
    /**
     * Unserialize a setting value based on its type
     * 
     * @param string $value Serialized value
     * @param string $type Value type
     * @return mixed Unserialized value
     */
    private function unserializeValue($value, $type) {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'array':
            case 'object':
                return json_decode($value, true);
            case 'string':
            default:
                return $value;
        }
    }
    
    /**
     * Serialize a setting value based on its type
     * 
     * @param mixed $value Value to serialize
     * @return array Serialized value and type
     */
    private function serializeValue($value) {
        $type = gettype($value);
        
        switch ($type) {
            case 'array':
            case 'object':
                return [json_encode($value), $type];
            case 'boolean':
                return [(int) $value, $type];
            default:
                return [$value, $type];
        }
    }
    
    /**
     * Get a setting value
     * 
     * @param string $key Setting key
     * @param mixed $default Default value if key not found
     * @return mixed Setting value
     */
    public function get($key, $default = null) {
        $this->loadSettings();
        
        return $this->cache[$key] ?? $default;
    }
    
    /**
     * Get all settings
     * 
     * @return array All settings
     */
    public function getAll() {
        if ($this->loaded) {
            return $this->cache;
        }
        
        return parent::getAll();
    }
    
    /**
     * Set a setting value
     * 
     * @param string $key Setting key
     * @param mixed $value Setting value
     * @return bool Whether the setting was set successfully
     */
    public function set($key, $value) {
        // Serialize the value
        list($serializedValue, $type) = $this->serializeValue($value);
        
        // Check if the setting exists
        $setting = $this->findBy('key', $key);
        
        if ($setting) {
            // Update existing setting
            $result = $this->update($setting['id'], [
                'value' => $serializedValue,
                'type' => $type,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Create new setting
            $result = $this->insert([
                'key' => $key,
                'value' => $serializedValue,
                'type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]) !== false;
        }
        
        // Update cache if successful
        if ($result) {
            $this->cache[$key] = $value;
        }
        
        return $result;
    }
    
    /**
     * Set multiple settings at once
     * 
     * @param array $settings Settings (key => value pairs)
     * @return bool Whether all settings were set successfully
     */
    public function setMultiple($settings) {
        $success = true;
        
        // Begin transaction
        $this->beginTransaction();
        
        try {
            foreach ($settings as $key => $value) {
                if (!$this->set($key, $value)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $this->commit();
            } else {
                $this->rollback();
            }
            
            return $success;
        } catch (Exception $e) {
            $this->rollback();
            $this->logError("Error setting multiple settings", $e);
            return false;
        }
    }
    
    /**
     * Delete a setting
     * 
     * @param string $key Setting key
     * @return bool Whether the setting was deleted successfully
     */
    public function delete($key) {
        // Check if the setting exists
        $setting = $this->findBy('key', $key);
        
        if (!$setting) {
            return false;
        }
        
        // Delete the setting
        $result = parent::delete($setting['id']);
        
        // Update cache if successful
        if ($result) {
            unset($this->cache[$key]);
        }
        
        return $result;
    }
    
    /**
     * Reset the settings cache
     * 
     * @return void
     */
    public function resetCache() {
        $this->cache = [];
        $this->loaded = false;
    }
}
