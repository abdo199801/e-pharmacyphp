<?php
// Front Controller - Handle all requests

// Define application root path
define('APP_ROOT', dirname(__DIR__));

// Include required files
require_once APP_ROOT . '/app/config/config.php';
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Model.php';
require_once APP_ROOT . '/app/core/View.php';
require_once APP_ROOT . '/app/core/Database.php';

// Simple Router
$url = $_GET['url'] ?? 'home/index';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0] ?? 'home') . 'Controller';
$methodName = $urlParts[1] ?? 'index';
$params = array_slice($urlParts, 2);

$controllerPath = APP_ROOT . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        } else {
            // Method not found
            http_response_code(404);
            echo "Method $methodName not found in controller $controllerName";
        }
    } else {
        // Class not found
        http_response_code(404);
        echo "Controller class $controllerName not found";
    }
} else {
    // Controller file not found
    http_response_code(404);
    echo "Controller file not found: $controllerPath";
}