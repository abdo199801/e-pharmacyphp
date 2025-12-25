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