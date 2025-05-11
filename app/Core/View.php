<?php
namespace App\Core;

class View {
    /**
     * Render a view within the main layout, passing data variables.
     *
     * @param string $view  Path to view file under app/Views (without .php extension)
     * @param array  $data  Key-value pairs available inside the view
     */
    public static function render(string $view, array $data = []): void {
        // Load config for base_url
        $config = require __DIR__ . '/../../config/config.php';
        $data['base_url'] = $config['base_url'];

        // Extract data variables into scope
        extract($data);

        // Determine view and layout paths
        $viewFile   = __DIR__ . "/../Views/{$view}.php";
        $layoutFile = __DIR__ . "/../Views/layouts/main.php";

        if (!file_exists($viewFile) || !file_exists($layoutFile)) {
            http_response_code(500);
            echo "View or layout file not found.";
            return;
        }

        // Capture the view output
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render within the layout
        require $layoutFile;
    }
}
