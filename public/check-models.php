<?php
echo "<h1>Model Diagnostics</h1>";

// Check if models directory exists
$modelsDir = '../app/models/';
echo "<h2>Checking Models Directory: $modelsDir</h2>";

if (is_dir($modelsDir)) {
    echo "<p style='color: green;'>✓ Models directory exists</p>";
    
    // List all files in models directory
    $files = scandir($modelsDir);
    echo "<h3>Files in models directory:</h3>";
    echo "<ul>";
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $modelsDir . $file;
            $color = is_file($filePath) ? 'green' : 'red';
            echo "<li style='color: $color;'>$file</li>";
        }
    }
    echo "</ul>";
    
    // Check specific model files
    $requiredModels = ['ProductModel.php', 'ClientModel.php', 'BlogModel.php'];
    foreach ($requiredModels as $modelFile) {
        $filePath = $modelsDir . $modelFile;
        if (file_exists($filePath)) {
            echo "<p style='color: green;'>✓ $modelFile exists</p>";
            
            // Check if class exists in file
            $content = file_get_contents($filePath);
            if (strpos($content, 'class ProductModel') !== false) {
                echo "<p style='color: green;'>✓ ProductModel class found in file</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ $modelFile is MISSING</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Models directory does not exist</p>";
}

// Check current working directory
echo "<h2>Current Working Directory</h2>";
echo "<p>" . getcwd() . "</p>";

// Check include path
echo "<h2>Include Path</h2>";
echo "<p>" . get_include_path() . "</p>";