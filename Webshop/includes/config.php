<?php
// Central settings. Every page includes this file first.

// Address of the project on the web server. Change this if the folder name is different.
define('APPURL', 'http://localhost/webshop');

// Database settings (XAMPP defaults)
define('DB_HOST', 'localhost');
define('DB_NAME', 'web-shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Product categories: number in the database => name on the site
define('CATEGORIES', [
    1 => 'Fruit',
    2 => 'Groenten',
    3 => 'Dranken',
    4 => 'Brood',
    5 => 'Kruiden',
]);

// Start the session here, so every page knows who is logged in.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
