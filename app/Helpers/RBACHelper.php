<?php
namespace App\Helpers;

class RBACHelper
{

    /**
     * Check if current user has a given action on a route.
     *
     * @param string $action      e.g. 'View','Create','Edit'
     * @param string $routePath   e.g. 'users' or 'departments/list'
     * @return bool
     */
     public static function has_permission(string $action, string $routePath = null): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $perms = $_SESSION['user_permissions'] ?? [];
        // auto-detect if not provided:
        if ($routePath === null) {
            // strip base and leading slash:
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $base = rtrim($_ENV['BASE_URL'] ?? '/', '/');
            if (strpos($uri, $base) === 0) {
                $uri = substr($uri, strlen($base));
            }
            $routePath = trim($uri, '/');
        }
        foreach ($perms as $p) {
            if ($p['path'] === $routePath && strcasecmp($p['action'], $action) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Echo $html only if user has permission
     */
      public static function show_if_has_permission(string $action, string $routePath, string $html): string
    {
        return has_permission($action, $routePath) ? $html : '';
    }
}
