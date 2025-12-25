<?php
class View {
    public function render($view, $data = []) {
        $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }
    
    public function partial($partial, $data = []) {
        $partialPath = dirname(__DIR__) . '/views/partials/' . $partial . '.php';
        if (file_exists($partialPath)) {
            extract($data);
            require_once $partialPath;
        }
    }
}