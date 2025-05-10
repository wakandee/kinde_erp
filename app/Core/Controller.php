<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        // Load config and extract data
        $config = require __DIR__ . '/../../config/config.php';
        $data['base_url'] = $config['base_url'];
        extract($data);

        $viewFile = "../app/views/{$view}.php";
        
        if (file_exists($viewFile)) {
            require_once "../app/views/layouts/main.php";
            require_once $viewFile;
        } else {
            http_response_code(404);
            echo "View {$view} not found.";
        }
    }

}
?>