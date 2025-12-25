<?php
require_once __DIR__ . '/../app/config/Database.php';

echo "<h2>Database Connection Test</h2>";

try {
    $db = Database::getInstance();
    echo "✅ Database connected successfully!<br>";
    
    // Test query
    $stmt = $db->query("SELECT COUNT(*) as count FROM clients");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Clients table exists with " . $result['count'] . " records<br>";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>