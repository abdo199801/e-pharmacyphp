<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Model.php';

echo "<h1>Testing Models</h1>";

// Test each model
$models = ['ProductModel', 'BlogModel', 'PageModel', 'PharmacyModel', 'DashboardModel', 'ClientModel'];

foreach ($models as $modelName) {
    $modelPath = "../app/models/{$modelName}.php";
    if (file_exists($modelPath)) {
        require_once $modelPath;
        if (class_exists($modelName)) {
            echo "<p style='color: green;'>✓ $modelName loaded successfully</p>";
            
            // Test instantiation
            try {
                $model = new $modelName();
                echo "<p style='color: green;'>✓ $modelName instantiated successfully</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ $modelName failed to instantiate: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ $modelName class not found</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ $modelName file not found at: $modelPath</p>";
    }
}

// Test database connection
try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}