<?php
namespace App\Core;

class View {
    public static function render($view, $data = []) {
        // Load config and add base_url to view data
        $config = require '../config/config.php';
        $data['base_url'] = $config['base_url'];

        extract($data);

        $viewFile = "../app/views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once "../app/views/layouts/main.php"; // Assuming all views go through main layout
        } else {
            echo "View '{$view}' not found.";
        }
    }
}
