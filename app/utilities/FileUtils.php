<?php
/**
 * FileUtils Class
 * 
 * Provides utility methods for file operations.
 */
class FileUtils {
    /**
     * @var FileUtils Singleton instance
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
     * @return FileUtils
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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
     * Get the file extension
     * 
     * @param string $filename Filename
     * @return string File extension
     */
    public function getFileExtension($filename) {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
    
    /**
     * Check if a file exists and is readable
     * 
     * @param string $path File path
     * @return bool Whether the file exists and is readable
     */
    public function isReadable($path) {
        return file_exists($path) && is_readable($path);
    }
    
    /**
     * Check if a directory exists and is writable
     * 
     * @param string $path Directory path
     * @return bool Whether the directory exists and is writable
     */
    public function isWritable($path) {
        return file_exists($path) && is_writable($path);
    }
    
    /**
     * Create a directory if it doesn't exist
     * 
     * @param string $path Directory path
     * @param int $permissions Directory permissions (default: 0755)
     * @param bool $recursive Whether to create parent directories (default: true)
     * @return bool Whether the directory was created or already exists
     */
    public function createDirectory($path, $permissions = 0755, $recursive = true) {
        if (file_exists($path) && is_dir($path)) {
            return true;
        }
        
        return mkdir($path, $permissions, $recursive);
    }
    
    /**
     * Delete a file
     * 
     * @param string $path File path
     * @return bool Whether the file was deleted
     */
    public function deleteFile($path) {
        if (file_exists($path) && is_file($path)) {
            return unlink($path);
        }
        
        return false;
    }
    
    /**
     * Read a file's contents
     * 
     * @param string $path File path
     * @return string|bool File contents or false on failure
     */
    public function readFile($path) {
        if ($this->isReadable($path)) {
            return file_get_contents($path);
        }
        
        return false;
    }
    
    /**
     * Write contents to a file
     * 
     * @param string $path File path
     * @param string $contents File contents
     * @param bool $createDirectory Whether to create the directory if it doesn't exist (default: true)
     * @return bool Whether the file was written
     */
    public function writeFile($path, $contents, $createDirectory = true) {
        if ($createDirectory) {
            $directory = dirname($path);
            $this->createDirectory($directory);
        }
        
        return file_put_contents($path, $contents) !== false;
    }
    
    /**
     * Get all files in a directory
     * 
     * @param string $directory Directory path
     * @param string $extension File extension filter (default: empty)
     * @param bool $recursive Whether to search recursively (default: false)
     * @return array Files
     */
    public function getFiles($directory, $extension = '', $recursive = false) {
        $files = [];
        
        if (!file_exists($directory) || !is_dir($directory)) {
            return $files;
        }
        
        $items = scandir($directory);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            
            $path = $directory . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($path) && $recursive) {
                $files = array_merge($files, $this->getFiles($path, $extension, true));
            } elseif (is_file($path)) {
                if (empty($extension) || $this->getFileExtension($path) === strtolower($extension)) {
                    $files[] = $path;
                }
            }
        }
        
        return $files;
    }
    
    /**
     * Copy a file
     * 
     * @param string $source Source file path
     * @param string $destination Destination file path
     * @param bool $createDirectory Whether to create the destination directory if it doesn't exist (default: true)
     * @return bool Whether the file was copied
     */
    public function copyFile($source, $destination, $createDirectory = true) {
        if (!$this->isReadable($source)) {
            return false;
        }
        
        if ($createDirectory) {
            $directory = dirname($destination);
            $this->createDirectory($directory);
        }
        
        return copy($source, $destination);
    }
}
