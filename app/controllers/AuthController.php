<?php
// Include PHPMailer
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller {
    private $clientModel;
    
    public function __construct() {
        parent::__construct();
        $this->clientModel = $this->loadModel('ClientModel');
    }
    
    public function register() {
        // If user is already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }
        
        $data = [
            'title' => 'Register - Pharmacy Platform',
            'errors' => [],
            'old_input' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input data
            $input = [
                'firstname' => trim($_POST['firstname'] ?? ''),
                'lastname' => trim($_POST['lastname'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'pharmacy_name' => trim($_POST['pharmacy_name'] ?? ''),
                'license_number' => trim($_POST['license_number'] ?? ''),
                'city' => trim($_POST['city'] ?? ''),
                'country' => trim($_POST['country'] ?? ''),
                'role' => (!empty($_POST['pharmacy_name'])) ? 'ADMINISTRATORCLIENT' : 'NORMALCLIENT'
            ];
            
            // Validate input
            $errors = $this->validateRegistration($input);
            
            if (empty($errors)) {
                // Check if email already exists
                if ($this->clientModel->getClientByEmail($input['email'])) {
                    $errors['email'] = 'Email is already registered';
                } else {
                    // Create client
                    $clientData = [
                        'firstname' => $input['firstname'],
                        'lastname' => $input['lastname'],
                        'email' => $input['email'],
                        'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                        'phone' => $input['phone'],
                        'address' => $input['address'],
                        'role' => $input['role'],
                        'is_verified' => 0,
                        'otp_code' => null,
                        'otp_expires_at' => null
                    ];
                    
                    if ($this->clientModel->createClient($clientData)) {
                        $clientId = $this->clientModel->getLastInsertId();
                        
                        // Debug: Verify client was created
                        error_log("✅ Client created with ID: $clientId");
                        $newClient = $this->clientModel->getClientById($clientId);
                        error_log("📋 New client data: " . print_r($newClient, true));
                        
                        // Generate and send OTP
                        $otp = $this->generateOTP($clientId, $input['email']);
                        $this->sendOTPEmail($input['email'], $otp, $input['firstname']);
                        
                        // If it's a pharmacy, create pharmacy business information
                        if ($input['role'] === 'ADMINISTRATORCLIENT') {
                            $this->loadModel('PharmacyModel');
                            $pharmacyData = [
                                'pharmacy_name' => $input['pharmacy_name'],
                                'address' => $input['address'],
                                'city' => $input['city'],
                                'country' => $input['country'],
                                'license_number' => $input['license_number'],
                                'phone' => $input['phone'],
                                'client_id' => $clientId
                            ];
                            $this->model->PharmacyModel->createPharmacyInfo($pharmacyData);
                        }
                        
                        // Store temp user data for OTP verification
                        $_SESSION['temp_user'] = [
                            'id' => $clientId,
                            'email' => $input['email'],
                            'firstname' => $input['firstname'],
                            'lastname' => $input['lastname'],
                            'role' => $input['role']
                        ];
                        
                        $_SESSION['success'] = 'Registration successful! Please verify your email with the OTP sent to your inbox.';
                        $this->redirect('auth/verifyOtp');
                        return;
                    } else {
                        $errors['general'] = 'Registration failed. Please try again.';
                        error_log("❌ Failed to create client in database");
                    }
                }
            }
            
            $data['errors'] = $errors;
            $data['old_input'] = $input;
        }
        
        $this->view->render('auth/register', $data);
    }
    
    public function login() {
        // If user is already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }
        
        $data = [
            'title' => 'Login - Pharmacy Platform',
            'errors' => [],
            'old_input' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $errors = $this->validateLogin($email, $password);
            
            if (empty($errors)) {
                $client = $this->clientModel->getClientByEmail($email);
                
                // Fix: Check if client exists and has the required array keys
                if ($client && isset($client['password']) && password_verify($password, $client['password'])) {
                    // Check if user is verified
                    if (!$client['is_verified']) {
                        // Generate and send OTP for unverified user
                        $otp = $this->generateOTP($client['id'], $email);
                        $firstName = $client['firstname'] ?? 'User'; // Fallback if firstname doesn't exist
                        $this->sendOTPEmail($email, $otp, $firstName);
                        
                        $_SESSION['temp_user'] = [
                            'id' => $client['id'],
                            'email' => $email,
                            'firstname' => $client['firstname'] ?? 'User',
                            'lastname' => $client['lastname'] ?? '',
                            'role' => $client['role'] ?? 'NORMALCLIENT'
                        ];
                        
                        $_SESSION['info'] = 'Please verify your email with the OTP sent to your inbox.';
                        $this->redirect('auth/verifyOtp');
                        return;
                    }
                    
                    // Set session variables for verified user
                    $_SESSION['client_id'] = $client['id'];
                    $_SESSION['client_email'] = $client['email'];
                    $_SESSION['client_name'] = ($client['firstname'] ?? '') . ' ' . ($client['lastname'] ?? '');
                    $_SESSION['client_role'] = $client['role'] ?? 'NORMALCLIENT';
                    $_SESSION['logged_in'] = true;
                    
                    // Set success message
                    $_SESSION['success'] = 'Welcome back, ' . ($client['firstname'] ?? 'User') . '!';
                    
                    // Redirect to dashboard
                    $this->redirect('dashboard');
                    return;
                } else {
                    $errors['general'] = 'Invalid email or password';
                }
            }
            
            $data['errors'] = $errors;
            $data['old_input'] = ['email' => $email];
        }
        
        $this->view->render('auth/login', $data);
    }
    
    public function verifyOtp() {
        // If user is already logged in and verified, redirect to dashboard
        if ($this->isLoggedIn() && $this->isVerified()) {
            $this->redirect('dashboard');
            return;
        }
        
        // Check if temp user session exists
        if (!isset($_SESSION['temp_user'])) {
            $_SESSION['error'] = 'Session expired. Please login or register again.';
            $this->redirect('auth/login');
            return;
        }
        
        $data = [
            'title' => 'Verify OTP - Pharmacy Platform',
            'errors' => [],
            'email' => $_SESSION['temp_user']['email']
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = trim($_POST['otp'] ?? '');
            
            $errors = $this->validateOTP($otp);
            
            if (empty($errors)) {
                $email = $_SESSION['temp_user']['email'];
                $client = $this->verifyOTPCode($email, $otp);
                
                if ($client) {
                    // OTP verified successfully
                    $_SESSION['client_id'] = $client['id'];
                    $_SESSION['client_email'] = $client['email'];
                    $_SESSION['client_name'] = ($client['firstname'] ?? '') . ' ' . ($client['lastname'] ?? '');
                    $_SESSION['client_role'] = $client['role'] ?? 'NORMALCLIENT';
                    $_SESSION['logged_in'] = true;
                    
                    // Clear temp session
                    unset($_SESSION['temp_user']);
                    
                    $_SESSION['success'] = 'Email verified successfully! Welcome to PharmaPlatform.';
                    $this->redirect('dashboard');
                    return;
                } else {
                    $errors['otp'] = 'Invalid OTP or OTP has expired.';
                }
            }
            
            $data['errors'] = $errors;
        }
        
        $this->view->render('auth/verify-otp', $data);
    }
    
    public function resendOtp() {
        // Check if temp user session exists
        if (!isset($_SESSION['temp_user'])) {
            $_SESSION['error'] = 'Session expired. Please login or register again.';
            $this->redirect('auth/login');
            return;
        }
        
        $email = $_SESSION['temp_user']['email'];
        $client = $this->clientModel->getClientByEmail($email);
        
        if ($client) {
            $otp = $this->generateOTP($client['id'], $email);
            $firstName = $client['firstname'] ?? 'User';
            $this->sendOTPEmail($email, $otp, $firstName);
            
            $_SESSION['success'] = 'New OTP has been sent to your email.';
        } else {
            $_SESSION['error'] = 'User not found. Please try again.';
        }
        
        $this->redirect('auth/verifyOtp');
    }
    
    // Magic method to handle dashed URLs
    public function __call($name, $arguments) {
        // Convert dashed method names to camelCase
        if ($name === 'verify-otp') {
            return $this->verifyOtp();
        }
        if ($name === 'resend-otp') {
            return $this->resendOtp();
        }
        
        throw new Exception("Method $name not found in controller " . get_class($this));
    }
    
    public function logout() {
        // Clear all session variables including temp data
        session_unset();
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page
        $_SESSION['success'] = 'You have been logged out successfully.';
        $this->redirect('home');
    }
    
    // Helper method to check if user is verified
    private function isVerified() {
        if (!isset($_SESSION['client_id'])) {
            return false;
        }
        
        $client = $this->clientModel->getClientById($_SESSION['client_id']);
        return $client && isset($client['is_verified']) && $client['is_verified'];
    }
    
    // OTP-related methods - ENHANCED VERSION
    private function generateOTP($clientId, $email) {
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        error_log("🔄 Generating OTP:");
        error_log("Client ID: $clientId");
        error_log("Email: $email");
        error_log("OTP: $otp");
        error_log("Expires At: $expiresAt");
        
        // Update client with OTP data - FIXED PARAMETER NAMES
        $updateData = [
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
            'is_verified' => 0
        ];
        
        error_log("Update Data: " . print_r($updateData, true));
        
        // Debug: Check client existence before update
        $currentClient = $this->clientModel->getClientById($clientId);
        if (!$currentClient) {
            error_log("❌ CLIENT NOT FOUND with ID: $clientId");
            // Try to find by email as fallback
            $clientByEmail = $this->clientModel->getClientByEmail($email);
            if ($clientByEmail) {
                error_log("📧 Found client by email, ID: " . $clientByEmail['id']);
                $clientId = $clientByEmail['id'];
                $currentClient = $clientByEmail;
            }
        }
        
        if ($currentClient) {
            error_log("📋 Current client data before update: " . print_r($currentClient, true));
        } else {
            error_log("❌ Could not find client with ID: $clientId or email: $email");
            return $otp; // Return OTP anyway for fallback
        }
        
        $updateResult = $this->clientModel->updateClient($clientId, $updateData);
        error_log("Update Result: " . ($updateResult ? 'SUCCESS' : 'FAILED'));
        
        if (!$updateResult) {
            error_log("❌ FAILED to update OTP in database for client: $clientId");
            
            // Try alternative update methods
            error_log("🔄 Attempting alternative update methods...");
            
            // Method 1: Try with different parameter format
            $updateResult2 = $this->clientModel->updateClient(['id' => $clientId], $updateData);
            error_log("Alternative Update Result: " . ($updateResult2 ? 'SUCCESS' : 'FAILED'));
            
            if (!$updateResult2) {
                // Method 2: Try direct database connection as last resort
                error_log("🚨 All update methods failed for client: $clientId");
                error_log("💡 OTP for manual use: $otp");
            }
        } else {
            // Verify the update worked
            $updatedClient = $this->clientModel->getClientById($clientId);
            if ($updatedClient) {
                error_log("✅ After update - OTP in DB: " . ($updatedClient['otp_code'] ?? 'NULL'));
                error_log("✅ After update - Expires at: " . ($updatedClient['otp_expires_at'] ?? 'NULL'));
                error_log("✅ After update - Is verified: " . ($updatedClient['is_verified'] ?? 'NULL'));
                
                // Double-check the values match
                $otpMatch = ($updatedClient['otp_code'] ?? '') === $otp;
                $expiryMatch = ($updatedClient['otp_expires_at'] ?? '') === $expiresAt;
                
                error_log("🔍 Verification Check:");
                error_log("   OTP Match: " . ($otpMatch ? 'YES' : 'NO'));
                error_log("   Expiry Match: " . ($expiryMatch ? 'YES' : 'NO'));
                
                if (!$otpMatch || !$expiryMatch) {
                    error_log("⚠️ WARNING: Database values don't match intended values!");
                    error_log("   Intended OTP: $otp, Got: " . ($updatedClient['otp_code'] ?? 'NULL'));
                    error_log("   Intended Expiry: $expiresAt, Got: " . ($updatedClient['otp_expires_at'] ?? 'NULL'));
                } else {
                    error_log("🎉 SUCCESS: OTP saved correctly to database!");
                }
            } else {
                error_log("❌ Could not retrieve updated client data");
            }
        }
        
        return $otp;
    }
    
    // Add this method to debug database issues
    private function debugClientData($clientId) {
        error_log("🔍 DEBUG CLIENT DATA FOR ID: $clientId");
        
        $client = $this->clientModel->getClientById($clientId);
        if ($client) {
            error_log("Client exists in database:");
            error_log(" - ID: " . ($client['id'] ?? 'NULL'));
            error_log(" - Email: " . ($client['email'] ?? 'NULL'));
            error_log(" - OTP Code: " . ($client['otp_code'] ?? 'NULL'));
            error_log(" - OTP Expires: " . ($client['otp_expires_at'] ?? 'NULL'));
            error_log(" - Is Verified: " . ($client['is_verified'] ?? 'NULL'));
            error_log(" - Full data: " . print_r($client, true));
        } else {
            error_log("❌ Client not found in database!");
        }
        
        return $client;
    }
    
    // Enhanced OTP verification with better debugging
    private function verifyOTPCode($email, $otp) {
        $client = $this->clientModel->getClientByEmail($email);
        
        error_log("🔍 OTP Verification Debug:");
        error_log("Email: $email");
        error_log("OTP Provided: $otp");
        error_log("Client Found: " . ($client ? 'YES' : 'NO'));
        
        if ($client) {
            error_log("Database OTP: " . ($client['otp_code'] ?? 'NULL'));
            error_log("OTP Expires: " . ($client['otp_expires_at'] ?? 'NULL'));
            error_log("Is Verified: " . ($client['is_verified'] ?? '0'));
            error_log("Current Time: " . date('Y-m-d H:i:s'));
            
            // Check if OTP exists and matches
            $otpMatches = isset($client['otp_code']) && strval($client['otp_code']) === strval($otp);
            error_log("OTP Matches: " . ($otpMatches ? 'YES' : 'NO'));
            
            // Check if OTP is not expired
            $isExpired = true;
            if (isset($client['otp_expires_at']) && !empty($client['otp_expires_at'])) {
                $expiresTime = strtotime($client['otp_expires_at']);
                $currentTime = time();
                $isExpired = $expiresTime <= $currentTime;
                error_log("Current Time: " . date('Y-m-d H:i:s', $currentTime));
                error_log("Expires Time: " . date('Y-m-d H:i:s', $expiresTime));
                error_log("Is Expired: " . ($isExpired ? 'YES' : 'NO'));
                error_log("Time Difference: " . ($expiresTime - $currentTime) . " seconds");
            } else {
                error_log("❌ OTP expiration time is missing or invalid");
            }
            
            // Check if user is not already verified
            $isNotVerified = isset($client['is_verified']) && $client['is_verified'] == 0;
            error_log("Is Not Verified: " . ($isNotVerified ? 'YES' : 'NO'));
            
            if ($otpMatches && !$isExpired && $isNotVerified) {
                // Mark as verified and clear OTP
                $updateResult = $this->clientModel->updateClient($client['id'], [
                    'is_verified' => 1,
                    'otp_code' => null,
                    'otp_expires_at' => null
                ]);
                
                error_log("Update Result: " . ($updateResult ? 'SUCCESS' : 'FAILED'));
                
                if ($updateResult) {
                    // Return updated client data
                    $updatedClient = $this->clientModel->getClientByEmail($email);
                    error_log("User verified: " . ($updatedClient['is_verified'] ?? 'UNKNOWN'));
                    
                    // Double-check verification
                    if ($updatedClient && $updatedClient['is_verified'] == 1) {
                        error_log("🎉 OTP verification successful!");
                        return $updatedClient;
                    } else {
                        error_log("❌ User verification status not updated correctly");
                    }
                } else {
                    error_log("❌ Failed to update user verification status");
                }
            } else {
                error_log("❌ OTP Verification Failed:");
                if (!$otpMatches) error_log(" - OTP doesn't match");
                if ($isExpired) error_log(" - OTP expired");
                if (!$isNotVerified) error_log(" - User already verified");
            }
        } else {
            error_log("❌ Client not found for email: $email");
        }
        
        return false;
    }
    
    private function sendOTPEmail($email, $otp, $name) {
        // Load email configuration
        $emailConfig = $this->getEmailConfig();
        
        // Check if email configuration is properly set
        if (empty($emailConfig['smtp_password']) || $emailConfig['smtp_password'] === 'your-app-password-here') {
            error_log("❌ Email configuration not set - using demo OTP");
            $this->fallbackToDemoOTP($otp);
            return false;
        }
        
        try {
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $emailConfig['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $emailConfig['smtp_username'];
            $mail->Password   = $emailConfig['smtp_password'];
            $mail->SMTPSecure = $emailConfig['smtp_secure'];
            $mail->Port       = $emailConfig['smtp_port'];
            
            // Enable verbose debug output
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer debug level $level: $str");
            };

            // Recipients
            $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
            $mail->addAddress($email, $name);
            $mail->addReplyTo($emailConfig['from_email'], $emailConfig['from_name']);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code - PharmaPlatform';
            $mail->Body    = $this->getEmailTemplate($otp, $name);
            $mail->AltBody = "Hello $name,\n\nYour OTP code is: $otp\n\nThis OTP will expire in 10 minutes.\n\nBest regards,\nPharmaPlatform Team";
            
            // Add headers to prevent spam marking
            $mail->addCustomHeader('X-Mailer', 'PHPMailer ' . PHPMailer::VERSION);
            $mail->addCustomHeader('X-Priority', '1');
            $mail->addCustomHeader('Importance', 'High');

            // Send email
            if ($mail->send()) {
                error_log("✅ OTP email sent successfully to: $email");
                $_SESSION['success'] = 'OTP has been sent to your email address. Please check your inbox and spam folder.';
                
                // Also show OTP on screen for backup
                $_SESSION['demo_otp'] = $otp;
                $_SESSION['info'] = 'For testing, you can also use this OTP: ' . $otp;
                
                return true;
            } else {
                error_log("❌ Failed to send OTP email to: $email - " . $mail->ErrorInfo);
                $this->fallbackToDemoOTP($otp);
                return false;
            }
            
        } catch (Exception $e) {
            error_log("❌ PHPMailer Exception for $email: " . $e->getMessage());
            $this->fallbackToDemoOTP($otp);
            return false;
        }
    }
    
    private function getEmailConfig() {
        // Load environment configuration
        try {
            $envConfig = require_once __DIR__ . '/../config/env.php';
            return $envConfig['email'];
        } catch (Exception $e) {
            error_log("❌ Failed to load email configuration: " . $e->getMessage());
            return [
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_username' => 'abdobaq777@gmail.com',
                'smtp_password' => '',
                'smtp_secure' => 'tls',
                'from_email' => 'abdobaq777@gmail.com',
                'from_name' => 'PharmaPlatform'
            ];
        }
    }
    
    private function getEmailTemplate($otp, $name) {
        return "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        background-color: #f4f4f4; 
                        margin: 0; 
                        padding: 20px; 
                    }
                    .container { 
                        max-width: 600px; 
                        margin: 0 auto; 
                        background: white; 
                        padding: 30px; 
                        border-radius: 10px; 
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
                    }
                    .header { 
                        text-align: center; 
                        color: #667eea; 
                        margin-bottom: 30px; 
                    }
                    .otp-code { 
                        font-size: 32px; 
                        font-weight: bold; 
                        text-align: center; 
                        color: #667eea; 
                        margin: 20px 0; 
                        padding: 15px; 
                        background: #f8f9fa; 
                        border-radius: 5px; 
                        letter-spacing: 5px; 
                    }
                    .footer { 
                        margin-top: 30px; 
                        padding-top: 20px; 
                        border-top: 1px solid #eee; 
                        color: #666; 
                        font-size: 14px; 
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>PharmaPlatform</h1>
                        <h2>OTP Verification</h2>
                    </div>
                    
                    <p>Hello <strong>$name</strong>,</p>
                    
                    <p>Your One-Time Password (OTP) for email verification is:</p>
                    
                    <div class='otp-code'>$otp</div>
                    
                    <p>This OTP will expire in <strong>10 minutes</strong>.</p>
                    
                    <p><strong>Important:</strong> Do not share this OTP with anyone. If you didn't request this verification, please ignore this email.</p>
                    
                    <div class='footer'>
                        <p>Best regards,<br><strong>PharmaPlatform Team</strong></p>
                        <p><small>This is an automated message. Please do not reply to this email.</small></p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }
    
    private function fallbackToDemoOTP($otp) {
        $_SESSION['demo_otp'] = $otp;
        $_SESSION['info'] = 'Email service temporarily unavailable. Use this OTP: ' . $otp;
        error_log("📧 Demo OTP generated: $otp - Email service failed");
    }
    
    // Validation methods
    private function validateRegistration($input) {
        $errors = [];
        
        // Firstname validation
        if (empty($input['firstname'])) {
            $errors['firstname'] = 'First name is required';
        } elseif (strlen($input['firstname']) < 2) {
            $errors['firstname'] = 'First name must be at least 2 characters';
        }
        
        // Lastname validation
        if (empty($input['lastname'])) {
            $errors['lastname'] = 'Last name is required';
        } elseif (strlen($input['lastname']) < 2) {
            $errors['lastname'] = 'Last name must be at least 2 characters';
        }
        
        // Email validation
        if (empty($input['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        // Password validation
        if (empty($input['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($input['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        // Confirm password validation
        if (empty($input['confirm_password'])) {
            $errors['confirm_password'] = 'Please confirm your password';
        } elseif ($input['password'] !== $input['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
        
        // Pharmacy validation (if pharmacy registration)
        if (!empty($input['pharmacy_name'])) {
            if (empty($input['license_number'])) {
                $errors['license_number'] = 'License number is required for pharmacies';
            }
            if (empty($input['city'])) {
                $errors['city'] = 'City is required';
            }
            if (empty($input['country'])) {
                $errors['country'] = 'Country is required';
            }
        }
        
        return $errors;
    }
    
    private function validateLogin($email, $password) {
        $errors = [];
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }
        
        return $errors;
    }
    
    private function validateOTP($otp) {
        $errors = [];
        
        if (empty($otp)) {
            $errors['otp'] = 'OTP is required';
        } elseif (strlen($otp) !== 6 || !is_numeric($otp)) {
            $errors['otp'] = 'OTP must be a 6-digit number';
        }
        
        return $errors;
    }
}