<?php
namespace App\Middleware;

use App\Helpers\SessionHelper;

class Auth
{
    /**
     * Ensure the user is logged in; otherwise redirect to login.
     */
    public static function handle(): void
    {
        SessionHelper::start();

        if (! SessionHelper::get('user_id')) {
            // Load base_url from config
            $config = require __DIR__ . '/../../config/config.php';
            $loginUrl = rtrim($config['base_url'], '/') . '/login';
            header('Location: ' . $loginUrl);
            exit;
        }
    }
}
