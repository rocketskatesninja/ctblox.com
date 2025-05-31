<?php
/**
 * Development Environment Configuration
 * 
 * This file contains configuration values specific to the development environment.
 * Values defined here will override the default values in config.php.
 */

// Development-specific database configuration
// if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
// if (!defined('DB_NAME')) define('DB_NAME', 'ctblox_dev');
// if (!defined('DB_USER')) define('DB_USER', 'ctblox_dev_user');
// if (!defined('DB_PASS')) define('DB_PASS', 'ctblox_dev_password');

// Development-specific application configuration
if (!defined('APP_DEBUG')) define('APP_DEBUG', true);
if (!defined('DISPLAY_ERRORS')) define('DISPLAY_ERRORS', true);
if (!defined('ERROR_REPORTING_LEVEL')) define('ERROR_REPORTING_LEVEL', E_ALL);

// Development-specific email configuration
if (!defined('SMTP_HOST')) define('SMTP_HOST', 'localhost');
if (!defined('SMTP_PORT')) define('SMTP_PORT', 1025); // Typical port for MailHog or similar local SMTP server
if (!defined('SMTP_USER')) define('SMTP_USER', '');
if (!defined('SMTP_PASS')) define('SMTP_PASS', '');

// Development-specific paths
if (!defined('ASSETS_URL')) define('ASSETS_URL', '/assets');
if (!defined('UPLOADS_URL')) define('UPLOADS_URL', '/uploads');

// Development-specific features
if (!defined('ENABLE_PROFILING')) define('ENABLE_PROFILING', true);
if (!defined('MINIFY_ASSETS')) define('MINIFY_ASSETS', false);
