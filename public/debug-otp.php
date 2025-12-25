<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>OTP Debug Information</h2>";

try {
    // Include the Database class with correct path
    require_once __DIR__ . '/../app/config/Database.php';
    
    // Check if Database class exists
    if (!class_exists('Database')) {
        die("Database class not found. Check the file path.");
    }
    
    // Get database instance
    $db = Database::getInstance();
    
    // Check session data
    echo "<h3>Session Data:</h3>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    
    // Check database structure
    echo "<h3>Database Structure for 'clients' table:</h3>";
    $stmt = $db->prepare("DESCRIBE clients");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>" . print_r($columns, true) . "</pre>";
    
    // Check if we have a temp user
    if (isset($_SESSION['temp_user'])) {
        $email = $_SESSION['temp_user']['email'];
        echo "<h3>Client Data for: $email</h3>";
        
        $stmt = $db->prepare("SELECT id, email, firstname, is_verified, otp_code, otp_expires_at FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($client) {
            echo "<pre>" . print_r($client, true) . "</pre>";
            
            echo "<h3>OTP Status:</h3>";
            $currentTime = time();
            $expiresTime = !empty($client['otp_expires_at']) ? strtotime($client['otp_expires_at']) : 0;
            
            echo "Current Time: " . date('Y-m-d H:i:s', $currentTime) . "<br>";
            echo "Expires Time: " . ($client['otp_expires_at'] ?: 'NOT SET') . "<br>";
            if ($client['otp_expires_at']) {
                echo "Time Left: " . ($expiresTime - $currentTime) . " seconds<br>";
                echo "Is Expired: " . (($expiresTime <= $currentTime) ? 'YES' : 'NO') . "<br>";
            }
            echo "Is Verified: " . ($client['is_verified'] ? 'YES' : 'NO') . "<br>";
        } else {
            echo "No client found with email: $email";
        }
    } else {
        echo "No temp user in session.";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>Stack trace: " . $e->getTraceAsString();
}
?>