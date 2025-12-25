<?php
class Controller {
    protected $models = [];
    protected $view;
    
    public function __construct() {
        $this->view = new View();
    }
    
    protected function loadModel($modelName) {
        // Define the correct path to models
        $modelPath = dirname(__DIR__) . '/models/' . $modelName . '.php';
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            
            // Check if the class exists after including the file
            if (class_exists($modelName)) {
                $modelInstance = new $modelName();
                $this->models[$modelName] = $modelInstance;
                return $modelInstance;
            } else {
                die("Class '$modelName' not found in file: $modelPath");
            }
        } else {
            // Show detailed error information
            die("Model file not found. Looking for: $modelPath<br>" .
                "Current directory: " . __DIR__ . "<br>" .
                "Make sure the model file exists in the correct location.");
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['client_id']);
    }
    
    protected function isAdmin() {
        return isset($_SESSION['client_role']) && $_SESSION['client_role'] === 'ADMINISTRATORCLIENT';
    }
}