<?php
// app/config/env.php
return [
    'app' => [
        'name' => 'PharmaPlatform',
        'version' => '1.0.0',
        'url' => 'http://localhost/pharmaplatform',
        'timezone' => 'UTC'
    ],
    'email' => [
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_username' => 'abdobaq777@gmail.com',
        'smtp_password' => 'eteo zyja tbvd ckfo', // You'll generate this
        'smtp_secure' => 'tls',
        'from_email' => 'abdobaq777@gmail.com',
        'from_name' => 'PharmaPlatform'
    ],
    'app' => [
        'base_url' => 'http://localhost/pharmacy-platform',
        'debug' => true
    ],
    'uploads' => [
        'path' => 'uploads/',
        'max_size' => 5242880, // 5MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp']
    ]
];
?>