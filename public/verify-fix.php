<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';

echo "<h1>Verification Script</h1>";

// Check if SubscriptionModel exists
$subscriptionModelPath = '../app/models/SubscriptionModel.php';
if (file_exists($subscriptionModelPath)) {
    echo "<p style='color: green;'>✓ SubscriptionModel.php exists</p>";
    
    // Test if it loads correctly
    require_once $subscriptionModelPath;
    if (class_exists('SubscriptionModel')) {
        echo "<p style='color: green;'>✓ SubscriptionModel class loads correctly</p>";
        
        try {
            $model = new SubscriptionModel();
            echo "<p style='color: green;'>✓ SubscriptionModel instantiated successfully</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ SubscriptionModel instantiation failed: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ SubscriptionModel class not found</p>";
    }
} else {
    echo "<p style='color: red;'>✗ SubscriptionModel.php still missing</p>";
}

// Test database connection
try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if we have subscription packs
    $stmt = $db->query("SELECT COUNT(*) as count FROM pack_abonnement WHERE status = 'active'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Active subscription packs: " . $result['count'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<p>1. Login to your account</p>";
echo "<p>2. Go to Dashboard > Products</p>";
echo "<p>3. Try creating a product</p>";