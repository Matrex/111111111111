<?php
// includes/config.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

// Other configuration settings
define('GAME_TIME_LIMIT', 60); // in seconds
define('DEFAULT_WIN_CHANCE', 20); // in percentage

// Base URL for the application
define('BASE_URL', 'https://script.easelfire.com/');

// Directory paths
define('ROOT_DIR', dirname(dirname(__DIR__)) . '/');
define('PUBLIC_DIR', ROOT_DIR . 'public_html/script/');
define('INCLUDES_DIR', ROOT_DIR . 'includes/');
define('UPLOADS_DIR', PUBLIC_DIR . 'uploads/');

// Ensure error reporting is on during development
error_reporting(E_ALL);
ini_set('display_errors', 1);
