<?php
namespace App\Middleware;

use App\Core\SessionHelper;

class Auth
{
    /**
     * Ensure the user is logged in; otherwise redirect to login.
     */
    public static function handle(): void
    {
        SessionHelper::start();
        if (! SessionHelper::get('user_id')) {
            // Not authenticated — redirect to login
            header('Location: ' . ($_ENV['BASE_URL'] ?? '/login'));
            exit;
        }
    }
}
