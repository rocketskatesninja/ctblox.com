<?php
/**
 * Log Rotation Script
 * 
 * This script handles log rotation for the CTBlox application:
 * - Rotates error logs to prevent them from growing too large
 * - Archives old logs with timestamps
 * - Compresses older logs to save space
 * 
 * Recommended to run as a daily cron job
 */

class LogRotation {
    private $logFile;
    private $maxSize; // in bytes
    private $maxBackups;
    private $compressAfterDays;
    
    /**
     * Constructor
     * 
     * @param string $logFile Path to the log file
     * @param int $maxSize Maximum size in bytes before rotation
     * @param int $maxBackups Maximum number of backup files to keep
     * @param int $compressAfterDays Number of days after which to compress logs
     */
    public function __construct($logFile, $maxSize = 5242880, $maxBackups = 10, $compressAfterDays = 7) {
        $this->logFile = $logFile;
        $this->maxSize = $maxSize; // 5MB default
        $this->maxBackups = $maxBackups;
        $this->compressAfterDays = $compressAfterDays;
    }
    
    /**
     * Run the log rotation process
     */
    public function rotate() {
        // Check if log file exists
        if (!file_exists($this->logFile)) {
            echo "Log file {$this->logFile} does not exist.\n";
            return false;
        }
        
        // Check if log file needs rotation (size > maxSize)
        if (filesize($this->logFile) < $this->maxSize) {
            echo "Log file {$this->logFile} does not need rotation yet.\n";
            return false;
        }
        
        // Rotate logs
        $this->rotateLogFile();
        
        // Compress old logs
        $this->compressOldLogs();
        
        // Clean up excess backups
        $this->cleanupExcessBackups();
        
        return true;
    }
    
    /**
     * Rotate the current log file
     */
    private function rotateLogFile() {
        $timestamp = date('Ymd_His');
        $backupFile = "{$this->logFile}.{$timestamp}";
        
        // Copy current log to backup
        if (copy($this->logFile, $backupFile)) {
            // Truncate the current log file
            file_put_contents($this->logFile, '');
            echo "Rotated log file to {$backupFile}\n";
            
            // Add rotation notice to the new log
            file_put_contents(
                $this->logFile, 
                "[" . date('Y-m-d H:i:s') . " UTC] Log file rotated. Previous log saved as " . basename($backupFile) . "\n",
                FILE_APPEND
            );
            
            return true;
        } else {
            echo "Failed to rotate log file.\n";
            return false;
        }
    }
    
    /**
     * Compress logs that are older than the specified days
     */
    private function compressOldLogs() {
        $pattern = "{$this->logFile}.*";
        $logFiles = glob($pattern);
        
        foreach ($logFiles as $file) {
            // Skip already compressed files
            if (pathinfo($file, PATHINFO_EXTENSION) === 'gz') {
                continue;
            }
            
            // Check file age
            $fileAge = time() - filemtime($file);
            $fileAgeDays = $fileAge / 86400; // Convert seconds to days
            
            if ($fileAgeDays > $this->compressAfterDays) {
                $compressedFile = "{$file}.gz";
                $fileContent = file_get_contents($file);
                
                // Compress the file
                file_put_contents($compressedFile, gzencode($fileContent, 9));
                
                // Verify compression was successful
                if (file_exists($compressedFile)) {
                    unlink($file);
                    echo "Compressed old log file: {$file} -> {$compressedFile}\n";
                }
            }
        }
    }
    
    /**
     * Clean up excess backup files
     */
    private function cleanupExcessBackups() {
        // Get all backup files (both compressed and uncompressed)
        $pattern = "{$this->logFile}.*";
        $logFiles = glob($pattern);
        
        // Sort by modification time (oldest first)
        usort($logFiles, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        
        // Remove oldest files if we have too many
        $filesToDelete = count($logFiles) - $this->maxBackups;
        
        if ($filesToDelete > 0) {
            for ($i = 0; $i < $filesToDelete; $i++) {
                if (file_exists($logFiles[$i])) {
                    unlink($logFiles[$i]);
                    echo "Deleted old log file: {$logFiles[$i]}\n";
                }
            }
        }
    }
}

// Run log rotation for the error log
$errorLog = '/var/www/ctblox.com/logs/error.log';
$rotation = new LogRotation($errorLog);
$rotation->rotate();

echo "Log rotation completed.\n";
