<?php
// Database installation script
header('Content-Type: text/plain');

define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/app/config/database.php';

$config = require APP_ROOT . '/app/config/database.php';

$host = $config['host'];
$username = $config['username'];
$password = $config['password'];
$database = $config['dbname'];

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
    $pdo->exec("USE `$database`");
    
    echo "Database created successfully!\n";
    
    // Read and execute schema
    $schema = file_get_contents('schema.sql');
    $pdo->exec($schema);
    echo "Schema imported successfully!\n";
    
    // Insert seed data
    $seed = file_get_contents('seed-data.sql');
    $pdo->exec($seed);
    echo "Seed data imported successfully!\n";
    
    echo "\n=== INSTALLATION COMPLETE ===\n";
    echo "Database: $database\n";
    echo "You can now access the application at: http://localhost/pharmacy-platform/public/\n";
    
} catch(PDOException $e) {
    die("Installation failed: " . $e->getMessage());
}