<?php
// Base configuration
define('BASE_URL', 'http://localhost/pharmacy-platform/public/');
define('SITE_NAME', 'PharmaPlatform');

// Session configuration
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
