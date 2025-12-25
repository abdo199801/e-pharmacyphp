<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Model.php';
require_once '../app/models/ProductModel.php';

echo "<h1>Product Creation Debug</h1>";

// Test database connection
try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if products table exists
    $stmt = $db->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Products table exists</p>";
        
        // Check table structure
        $stmt = $db->query("DESCRIBE products");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Products Table Structure:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "<td>{$column['Default']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>✗ Products table does NOT exist</p>";
    }
    
    // Check categories table
    $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Categories in database: " . $result['count'] . "</p>";
    
    // Check dashboards table
    $stmt = $db->query("SELECT COUNT(*) as count FROM dashboards");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Dashboards in database: " . $result['count'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

// Test ProductModel
echo "<h2>Testing ProductModel</h2>";
try {
    $productModel = new ProductModel();
    echo "<p style='color: green;'>✓ ProductModel instantiated successfully</p>";
    
    // Test creating a sample product
    $testData = [
        'name' => 'Test Product',
        'price' => 10.99,
        'description' => 'Test description',
        'category_id' => 'test-category-id',
        'dashboard_id' => 'test-dashboard-id',
        'stock_quantity' => 10
    ];
    
    echo "<h3>Test Product Data:</h3>";
    echo "<pre>" . print_r($testData, true) . "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ ProductModel error: " . $e->getMessage() . "</p>";
}

// Check uploads directory
echo "<h2>Checking Uploads Directory</h2>";
$uploadsDir = '../uploads';
if (is_dir($uploadsDir)) {
    echo "<p style='color: green;'>✓ Uploads directory exists</p>";
    if (is_writable($uploadsDir)) {
        echo "<p style='color: green;'>✓ Uploads directory is writable</p>";
    } else {
        echo "<p style='color: red;'>✗ Uploads directory is NOT writable</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Uploads directory does NOT exist</p>";
    if (mkdir($uploadsDir, 0755, true)) {
        echo "<p style='color: green;'>✓ Uploads directory created successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to create uploads directory</p>";
    }
}