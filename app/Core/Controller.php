<?php
namespace App\Core;

use App\Core\View;
use App\Helpers\SessionHelper;

abstract class Controller
{
    protected string $baseUrl;

    public function __construct()
    {
        // Ensure session is always started for each controller
        SessionHelper::start();
        $this->baseUrl = $_ENV['BASE_URL'] ?? $_SESSION['base_url'] ?? '/';
    }

    protected function view(string $view, array $data = []): void
    {
        // Inject base_url globally into views
        $data['base_url'] = $_ENV['BASE_URL'] ?? $_SESSION['base_url'] ?? '/'; // fallback
        View::render($view, $data);
    }
}
