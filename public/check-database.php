<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';

echo "<h1>Database Setup Check</h1>";

try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check required tables
    $tables = ['pack_abonnement', 'dashboards', 'products', 'categories', 'clients'];
    
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            
            // Show some sample data
            $sample = $db->query("SELECT * FROM $table LIMIT 1");
            if ($sample->rowCount() > 0) {
                echo "<p style='color: blue;'>   - Has data</p>";
            } else {
                echo "<p style='color: orange;'>   - No data</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Table '$table' does NOT exist</p>";
        }
    }
    
    // Check if we have any subscription packs
    $stmt = $db->query("SELECT COUNT(*) as count FROM pack_abonnement WHERE status = 'active'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Active subscription packs: " . $result['count'] . "</p>";
    
    // Check if we have any categories
    $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Categories: " . $result['count'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}