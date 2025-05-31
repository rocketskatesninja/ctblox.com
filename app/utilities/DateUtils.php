<?php
/**
 * DateUtils Class
 * 
 * Provides utility methods for date and time operations.
 */
class DateUtils {
    /**
     * @var DateUtils Singleton instance
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
     * @return DateUtils
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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
     * Get the current date and time
     * 
     * @param string $format Date format (default: Y-m-d H:i:s)
     * @return string Formatted current date and time
     */
    public function getCurrentDateTime($format = 'Y-m-d H:i:s') {
        return date($format);
    }
    
    /**
     * Get the current date
     * 
     * @param string $format Date format (default: Y-m-d)
     * @return string Formatted current date
     */
    public function getCurrentDate($format = 'Y-m-d') {
        return date($format);
    }
    
    /**
     * Get the current time
     * 
     * @param string $format Time format (default: H:i:s)
     * @return string Formatted current time
     */
    public function getCurrentTime($format = 'H:i:s') {
        return date($format);
    }
    
    /**
     * Calculate the difference between two dates
     * 
     * @param string|int $date1 First date
     * @param string|int $date2 Second date (default: current date)
     * @param string $unit Unit of time (days, hours, minutes, seconds)
     * @return int Difference in the specified unit
     */
    public function getDateDifference($date1, $date2 = null, $unit = 'days') {
        if (is_numeric($date1)) {
            $timestamp1 = (int)$date1;
        } else {
            $timestamp1 = strtotime($date1);
        }
        
        if ($date2 === null) {
            $timestamp2 = time();
        } elseif (is_numeric($date2)) {
            $timestamp2 = (int)$date2;
        } else {
            $timestamp2 = strtotime($date2);
        }
        
        $difference = $timestamp2 - $timestamp1;
        
        switch ($unit) {
            case 'days':
                return floor($difference / (60 * 60 * 24));
            case 'hours':
                return floor($difference / (60 * 60));
            case 'minutes':
                return floor($difference / 60);
            case 'seconds':
                return $difference;
            default:
                return floor($difference / (60 * 60 * 24));
        }
    }
    
    /**
     * Check if a date is in the past
     * 
     * @param string|int $date Date to check
     * @return bool Whether the date is in the past
     */
    public function isPast($date) {
        if (is_numeric($date)) {
            $timestamp = (int)$date;
        } else {
            $timestamp = strtotime($date);
        }
        
        return $timestamp < time();
    }
    
    /**
     * Check if a date is in the future
     * 
     * @param string|int $date Date to check
     * @return bool Whether the date is in the future
     */
    public function isFuture($date) {
        if (is_numeric($date)) {
            $timestamp = (int)$date;
        } else {
            $timestamp = strtotime($date);
        }
        
        return $timestamp > time();
    }
    
    /**
     * Add a time interval to a date
     * 
     * @param string|int $date Base date
     * @param int $amount Amount to add
     * @param string $unit Unit of time (days, hours, minutes, seconds)
     * @param string $format Date format for the result (default: Y-m-d H:i:s)
     * @return string Formatted date after adding the interval
     */
    public function addTime($date, $amount, $unit, $format = 'Y-m-d H:i:s') {
        if (is_numeric($date)) {
            $timestamp = (int)$date;
        } else {
            $timestamp = strtotime($date);
        }
        
        switch ($unit) {
            case 'days':
                $timestamp += $amount * 24 * 60 * 60;
                break;
            case 'hours':
                $timestamp += $amount * 60 * 60;
                break;
            case 'minutes':
                $timestamp += $amount * 60;
                break;
            case 'seconds':
                $timestamp += $amount;
                break;
            default:
                $timestamp += $amount * 24 * 60 * 60;
        }
        
        return date($format, $timestamp);
    }
    
    /**
     * Subtract a time interval from a date
     * 
     * @param string|int $date Base date
     * @param int $amount Amount to subtract
     * @param string $unit Unit of time (days, hours, minutes, seconds)
     * @param string $format Date format for the result (default: Y-m-d H:i:s)
     * @return string Formatted date after subtracting the interval
     */
    public function subtractTime($date, $amount, $unit, $format = 'Y-m-d H:i:s') {
        return $this->addTime($date, -$amount, $unit, $format);
    }
    
    /**
     * Format a date as a relative time string (e.g., "2 days ago")
     * 
     * @param string|int $date Date to format
     * @return string Relative time string
     */
    public function getRelativeTime($date) {
        if (is_numeric($date)) {
            $timestamp = (int)$date;
        } else {
            $timestamp = strtotime($date);
        }
        
        $difference = time() - $timestamp;
        $periods = [
            'decade' => 315360000,
            'year' => 31536000,
            'month' => 2628000,
            'week' => 604800, 
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1
        ];
        
        if ($difference < 5) {
            return 'just now';
        }
        
        if ($difference < 0) {
            return 'in the future';
        }
        
        foreach ($periods as $name => $seconds) {
            $count = floor($difference / $seconds);
            if ($count > 0) {
                $plural = $count > 1 ? 's' : '';
                return "$count $name$plural ago";
            }
        }
        
        return 'just now';
    }
}
