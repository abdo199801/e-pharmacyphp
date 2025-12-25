<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$emailConfig = $config['email'];

try {
    $mail = new PHPMailer(true);
    
    $mail->isSMTP();
    $mail->Host       = $emailConfig['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $emailConfig['smtp_username'];
    $mail->Password   = $emailConfig['smtp_password'];
    $mail->SMTPSecure = $emailConfig['smtp_secure'];
    $mail->Port       = $emailConfig['smtp_port'];
    
    $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
    $mail->addAddress('abdobaq777@gmail.com', 'Test User');
    
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PharmaPlatform';
    $mail->Body    = '<h1>Test Email</h1><p>If you received this, email is working!</p>';
    
    if ($mail->send()) {
        echo "✅ Test email sent successfully! Check your Gmail.";
    } else {
        echo "❌ Failed to send test email: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>