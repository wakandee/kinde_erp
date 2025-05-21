<?php
namespace App\Helpers;

use App\Core\Controller; // for loading config path if needed

class SessionHelper
{
    const TIMEOUT = 1500; // 15 minutes session timeout

    /**
     * Initialize session and enforce inactivity timeout.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(self::getSessionName());
            session_start();
        }
        // Enforce inactivity timeout
        self::checkActivity();
    }

    /**
     * Store a value in session.
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve a value from session, or null if not set.
     */
    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Destroy the session and its cookie.
     */
    public static function destroy(): void
    {
        // Clear session array
        $_SESSION = [];
        // Remove session cookie if used
        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000);
        }
        session_destroy();
    }

    /**
     * Enforce inactivity timeout and redirect to login if expired.
     */
    public static function checkActivity(): void
    {
        $now = time();
        if (isset($_SESSION['last_activity']) && ($now - $_SESSION['last_activity']) > self::TIMEOUT) {
            $baseUrl = self::getBaseUrl();
            self::destroy();
            header('Location: ' . $baseUrl . 'login');
            exit;
        }
        // Update last activity timestamp
        $_SESSION['last_activity'] = $now;
    }

    /**
     * Flash messaging: set or get a single-use message.
     */
    public static function flash(string $key, ?string $message = null)
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        if ($message !== null) {
            // Store flash message
            $_SESSION['flash'][$key] = $message;
        } else {
            // Retrieve and clear flash message
            $msg = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $msg;
        }
    }

    /**
     * Retrieve and clear a flash message.
     */
    public static function getFlash(string $key): ?string
    {
        self::start();
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }

    /**
     * Determine the base URL from environment, config file, or session.
     * @return string
     */
    protected static function getBaseUrl(): string
    {
        // 1. Try environment variable
        if (!empty($_ENV['BASE_URL'])) {
            return rtrim($_ENV['BASE_URL'], '/') . '/';
        }
        // 2. Try config file
        $configPath = __DIR__ . '/../../config/config.php';
        if (file_exists($configPath)) {
            $config = require $configPath;
            if (!empty($config['base_url'])) {
                return rtrim($config['base_url'], '/') . '/';
            }
        }
        // 3. Fallback to session value
        if (!empty($_SESSION['base_url'])) {
            return rtrim($_SESSION['base_url'], '/') . '/';
        }
        // 4. Last resort: root
        return '/';
    }

    /**
     * Get session name from config or default.
     * @return string
     */
    protected static function getSessionName(): string
    {
        // Check config for session name
        $configPath = __DIR__ . '/../../config/config.php';
        if (file_exists($configPath)) {
            $config = require $configPath;
            if (!empty($config['session']['name'])) {
                return $config['session']['name'];
            }
        }
        // Default session name
        return 'kinde_erp_session';
    }
}
