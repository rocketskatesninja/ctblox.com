<?php
/**
 * ErrorHandler
 * 
 * Provides centralized error handling for the application
 */
class ErrorHandler {
    /**
     * @var array Error levels with corresponding names
     */
    private static $errorLevels = [
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parse Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Strict Standards',
        E_RECOVERABLE_ERROR => 'Recoverable Error',
        E_DEPRECATED => 'Deprecated',
        E_USER_DEPRECATED => 'User Deprecated',
        E_ALL => 'All Errors'
    ];
    
    /**
     * @var string Log file path
     */
    private static $logFile = '/var/www/ctblox.com/logs/error.log';
    
    /**
     * Initialize the error handler
     */
    public static function init() {
        // Create logs directory if it doesn't exist
        $logsDir = dirname(self::$logFile);
        if (!is_dir($logsDir)) {
            mkdir($logsDir, 0755, true);
        }
        
        // Set error handler
        set_error_handler([self::class, 'handleError']);
        
        // Set exception handler
        set_exception_handler([self::class, 'handleException']);
        
        // Register shutdown function to catch fatal errors
        register_shutdown_function([self::class, 'handleShutdown']);
    }
    
    /**
     * Handle PHP errors
     * 
     * @param int $errno Error level
     * @param string $errstr Error message
     * @param string $errfile File where the error occurred
     * @param int $errline Line where the error occurred
     * @return bool Whether the error was handled
     */
    public static function handleError($errno, $errstr, $errfile, $errline) {
        // Don't handle errors that are suppressed with @
        if (!(error_reporting() & $errno)) {
            return false;
        }
        
        $errorType = isset(self::$errorLevels[$errno]) ? self::$errorLevels[$errno] : 'Unknown Error';
        
        self::logError($errorType, $errstr, $errfile, $errline);
        
        // If it's a fatal error, redirect to error page
        if ($errno == E_ERROR || $errno == E_USER_ERROR) {
            self::displayErrorPage($errstr);
        }
        
        // Don't execute PHP's internal error handler
        return true;
    }
    
    /**
     * Handle uncaught exceptions
     * 
     * @param Throwable $exception The exception object
     */
    public static function handleException($exception) {
        $errorType = get_class($exception);
        $errstr = $exception->getMessage();
        $errfile = $exception->getFile();
        $errline = $exception->getLine();
        
        self::logError($errorType, $errstr, $errfile, $errline);
        
        // Include stack trace in log
        self::logError('Stack Trace', $exception->getTraceAsString(), '', '');
        
        // Display error page
        self::displayErrorPage($errstr);
    }
    
    /**
     * Handle fatal errors
     */
    public static function handleShutdown() {
        $error = error_get_last();
        
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $errorType = isset(self::$errorLevels[$error['type']]) ? self::$errorLevels[$error['type']] : 'Fatal Error';
            
            self::logError($errorType, $error['message'], $error['file'], $error['line']);
            
            // Display error page
            self::displayErrorPage($error['message']);
        }
    }
    
    /**
     * Log error to file
     * 
     * @param string $errorType Type of error
     * @param string $errstr Error message
     * @param string $errfile File where the error occurred
     * @param string $errline Line where the error occurred
     */
    private static function logError($errorType, $errstr, $errfile, $errline) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$errorType] $errstr";
        
        if ($errfile && $errline) {
            $logMessage .= " in $errfile on line $errline";
        }
        
        // Add request information
        $logMessage .= "\nRequest: " . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
        
        // Add user information if available
        if (isset($_SESSION['user_id'])) {
            $logMessage .= "\nUser ID: " . $_SESSION['user_id'];
        }
        
        $logMessage .= "\n\n";
        
        // Write to log file
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }
    
    /**
     * Display error page to user
     * 
     * @param string $message Error message
     */
    private static function displayErrorPage($message) {
        // Only show detailed error message in development
        $isDevelopment = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1');
        
        // Clean output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set HTTP response code
        http_response_code(500);
        
        // Redirect to error page
        header('Location: /error?code=500' . ($isDevelopment ? '&message=' . urlencode($message) : ''));
        exit;
    }
    
    /**
     * Format database errors for consistent handling
     * 
     * @param PDOException $e The PDO exception
     * @return string Formatted error message
     */
    public static function formatDatabaseError(PDOException $e) {
        $errorInfo = $e->errorInfo ?? null;
        
        if ($errorInfo) {
            $sqlState = $errorInfo[0] ?? 'Unknown';
            $driverCode = $errorInfo[1] ?? 'Unknown';
            $message = $errorInfo[2] ?? $e->getMessage();
            
            return "Database Error ($sqlState:$driverCode): $message";
        }
        
        return "Database Error: " . $e->getMessage();
    }
    
    /**
     * Log database errors
     * 
     * @param PDOException $e The PDO exception
     * @param string $query The SQL query that caused the error
     */
    public static function logDatabaseError(PDOException $e, $query = '') {
        $errorMessage = self::formatDatabaseError($e);
        
        if ($query) {
            $errorMessage .= "\nQuery: $query";
        }
        
        self::logError('Database Error', $errorMessage, $e->getFile(), $e->getLine());
    }
}
