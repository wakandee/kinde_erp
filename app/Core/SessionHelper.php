<?php
namespace App\Core;

class SessionHelper
{
    const TIMEOUT = 300; // 5 minutes

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name('kinde_erp_session');
            session_start();
        }
        // Inactivity check
        self::checkActivity();
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000);
        }
        session_destroy();
    }

    public static function checkActivity(): void
    {
        $now = time();
        if (isset($_SESSION['last_activity']) && ($now - $_SESSION['last_activity']) > self::TIMEOUT) {
            self::destroy();
            header('Location: ' . ($_SESSION['base_url'] ?? '/login'));
            exit;
        }
        $_SESSION['last_activity'] = $now;
    }
}
