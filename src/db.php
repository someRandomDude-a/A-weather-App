<?php
// Get environment variables set by docker-compose
$host = getenv('MYSQL_HOST') ?: 'db';  // MariaDB service hostname, defaults to 'db'
$db = getenv('MYSQL_DATABASE') ?: 'example_db';  // Database name
$user = getenv('MYSQL_USER') ?: 'root';  // Default root user
$pass = getenv('MYSQL_PASSWORD') ?: 'example';  // Password

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Success
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
