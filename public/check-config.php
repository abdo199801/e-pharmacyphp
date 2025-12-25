<?php
require_once __DIR__ . '/../app/config/config.php';

echo "<h2>Current Email Configuration</h2>";
echo "<pre>";
print_r($config['email']);
echo "</pre>";

// Mask password for security
$maskedPassword = isset($config['email']['smtp_password']) 
    ? str_repeat('*', strlen($config['email']['smtp_password']))
    : 'NOT SET';

echo "<h3>Configuration Check:</h3>";
echo "<ul>";
echo "<li>SMTP Host: " . ($config['email']['smtp_host'] ?? 'NOT SET') . "</li>";
echo "<li>SMTP Username: " . ($config['email']['smtp_username'] ?? 'NOT SET') . "</li>";
echo "<li>SMTP Password: " . $maskedPassword . "</li>";
echo "<li>SMTP Port: " . ($config['email']['smtp_port'] ?? 'NOT SET') . "</li>";
echo "<li>SMTP Secure: " . ($config['email']['smtp_secure'] ?? 'NOT SET') . "</li>";
echo "</ul>";

if (empty($config['email']['smtp_password']) || $config['email']['smtp_password'] === 'your-app-password-here') {
    echo "<h3 style='color: red;'>❌ ERROR: You need to set your Gmail App Password in app/config/env.php</h3>";
} else {
    echo "<h3 style='color: green;'>✅ Configuration looks good!</h3>";
}
?>