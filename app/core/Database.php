<?php
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        // Use absolute path to config file
        $configPath = dirname(__DIR__) . '/config/database.php';
        
        if (!file_exists($configPath)) {
            die("Database configuration file not found: " . $configPath);
        }
        
        $config = require $configPath;
        
        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['username'],
                $config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}