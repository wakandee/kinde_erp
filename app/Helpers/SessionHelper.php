<?php
namespace App\Helpers;

class SessionHelper
{
    const TIMEOUT = 300; // 5 minutes
    // public function __construct()
    // {
    //     $config = require __DIR__ . '/../../config/config.php';
    //     $config = $config['base_url'];
    // }

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
            $base_url = $_ENV['BASE_URL'] ?? $_SESSION['base_url'];
            self::destroy();
            header('Location: ' . $base_url.'login');
            exit;
        }
        $_SESSION['last_activity'] = $now;
    }

    public static function flash(string $key, ?string $message = null)
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        if ($message !== null) {
            $_SESSION['flash'][$key] = $message;
        } else {
            $msg = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $msg;
        }
    }

    public static function setFlash(string $key, string $message): void
    {
        self::start();
        $_SESSION['flash'][$key] = $message;
    }


    public static function getFlash(string $key): ?string
    {
        self::start();
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]); // Flash messages should only show once
            return $value;
        }
        return null;
    }



}
