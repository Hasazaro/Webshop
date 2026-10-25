<?php
// One database connection for the whole site, available as $pdo.

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Save the technical error in the PHP log, show the visitor a friendly message.
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('De webshop is tijdelijk niet beschikbaar. Probeer het later opnieuw.');
}
