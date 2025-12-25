<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Model.php';

echo "<h1>Debug Models</h1>";

// Test BlogModel specifically
$blogModelPath = '../app/models/BlogModel.php';
echo "<h2>Testing BlogModel</h2>";

if (file_exists($blogModelPath)) {
    echo "<p style='color: green;'>✓ BlogModel.php exists</p>";
    
    // Read the file content to check if method exists
    $content = file_get_contents($blogModelPath);
    if (strpos($content, 'getBlogsCountByClient') !== false) {
        echo "<p style='color: green;'>✓ getBlogsCountByClient method found in file</p>";
    } else {
        echo "<p style='color: red;'>✗ getBlogsCountByClient method NOT found in file</p>";
        echo "<h3>File Content:</h3>";
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    }
    
    // Try to load the class
    require_once $blogModelPath;
    if (class_exists('BlogModel')) {
        echo "<p style='color: green;'>✓ BlogModel class exists</p>";
        
        try {
            $blogModel = new BlogModel();
            $methods = get_class_methods($blogModel);
            
            if (in_array('getBlogsCountByClient', $methods)) {
                echo "<p style='color: green;'>✓ getBlogsCountByClient method exists in class</p>";
            } else {
                echo "<p style='color: red;'>✗ getBlogsCountByClient method NOT found in class</p>";
                echo "<h3>Available methods in BlogModel:</h3>";
                echo "<pre>";
                print_r($methods);
                echo "</pre>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error creating BlogModel: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ BlogModel class not found</p>";
    }
} else {
    echo "<p style='color: red;'>✗ BlogModel.php not found at: $blogModelPath</p>";
}