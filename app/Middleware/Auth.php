<?php
namespace App\Middleware;
use App\Helpers\SessionHelper;

class Auth
{
    public static function handle(): void
    {
        SessionHelper::start();
        if (! SessionHelper::get('user_id')) {
            $config = require __DIR__ . '/../../config/config.php';
            header('Location: ' . rtrim($config['base_url'], '/') . '/login');
            exit;
        }
    }
}
