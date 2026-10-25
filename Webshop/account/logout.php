<?php
require_once __DIR__ . '/../includes/config.php';

// Empty the session data, remove the session cookie and end the session.
$_SESSION = [];
setcookie(session_name(), '', time() - 3600, '/');
session_destroy();

redirect('index.php');
