<?php
/**
 * Production Environment Configuration
 * 
 * This file contains configuration values specific to the production environment.
 * Values defined here will override the default values in config.php.
 */

// Production-specific application configuration
if (!defined('APP_DEBUG')) define('APP_DEBUG', false);
if (!defined('DISPLAY_ERRORS')) define('DISPLAY_ERRORS', false);
if (!defined('ERROR_REPORTING_LEVEL')) define('ERROR_REPORTING_LEVEL', E_ERROR | E_PARSE);

// Production-specific email configuration
// if (!defined('SMTP_HOST')) define('SMTP_HOST', 'smtp.example.com');
// if (!defined('SMTP_PORT')) define('SMTP_PORT', 587);
// if (!defined('SMTP_USER')) define('SMTP_USER', 'your_smtp_username');
// if (!defined('SMTP_PASS')) define('SMTP_PASS', 'your_smtp_password');

// Production-specific paths
if (!defined('ASSETS_URL')) define('ASSETS_URL', '/assets');
if (!defined('UPLOADS_URL')) define('UPLOADS_URL', '/uploads');

// Production-specific features
if (!defined('ENABLE_PROFILING')) define('ENABLE_PROFILING', false);
if (!defined('MINIFY_ASSETS')) define('MINIFY_ASSETS', true);
if (!defined('CACHE_LIFETIME')) define('CACHE_LIFETIME', 3600); // 1 hour
