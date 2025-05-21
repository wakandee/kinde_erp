<?php
// app/Middleware/Rbac.php

namespace App\Middleware;

use App\Core\Database;
use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;

class Rbac
{
    /**
     * Return the normalized current route path (matching user_routes.path).
     */

    protected static function currentRoutePath(): string
    {
        // 1) Figure out your base‐URL path, e.g. "/kinde_erp/public"
        $baseUrl  = UrlHelper::getBaseUrl();
        $basePath = parse_url($baseUrl, PHP_URL_PATH) ?: '';

        // 2) Grab the request URI path, e.g. "/kinde_erp/public/rbac_editRoute/163"
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';

        // 3) If it starts with your base path, strip that off
        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // 4) Clean up leading/trailing slashes, then split
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);

        // 5) Return the first segment (or empty string if none)
        return $segments[0] ?? '';
    }



    /**
     * Ensure we have a designation_id in session.
     * If not present, fetch it from the users table and store it.
     *
     * @return int|null  The designation_id or null if it can't be determined.
     */
    protected static function ensureDesignation(): ?int
    {
        SessionHelper::start();
        $designationId = SessionHelper::get('designation_id');

        if (! $designationId) {
            // No designation in session—fetch from DB
            $userId = SessionHelper::get('user_id');
            if (! $userId) {
                return null;
            }

            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT designation_id FROM users WHERE id = ? LIMIT 1");
            $stmt->execute([$userId]);
            $designationId = (int)$stmt->fetchColumn();

            if (! $designationId) {
                return null;
            }

            // Store for future use
            SessionHelper::set('designation_id', $designationId);
        }

        return $designationId;
    }

    /**
     * Check if current user has $permissionName on $routePath.
     * If $routePath is omitted, uses the current request URI.
     *
     * @return bool
     */
    public static function check(string $permissionName = 'View', string $routePath = null): bool
    {
        // 1) Make sure we have designation_id
        $designationId = self::ensureDesignation();
        if (! $designationId) {
            return false;
        }

        // 2) Resolve route path to its ID
        $path = $routePath ?? self::currentRoutePath();
        $db   = Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM user_routes WHERE path = ? LIMIT 1");
        $stmt->execute([$path]);
        $routeId = (int)$stmt->fetchColumn();
        if (! $routeId) {
            // Deny by default if route isn't registered
            return false;
        }

        // 3) Check assignment in the pivot table
        $sql = <<<SQL
SELECT COUNT(*) 
FROM user_designation_roles udr
JOIN user_permissions       up ON udr.permission_id = up.id
WHERE udr.designation_id = ?
  AND udr.route_id       = ?
  AND up.name            = ?
SQL;
        $stmt = $db->prepare($sql);
        $stmt->execute([$designationId, $routeId, $permissionName]);
        return (int)$stmt->fetchColumn() > 0;
    }


    /**
     * Enforce that current user has $permissionName on the current route.
     * If not, send HTTP 403 and die.
     */
    public static function enforce(string $permissionName = 'View', string $routePath = null): void
    {
        if (! self::check($permissionName, $routePath)) {
            http_response_code(403);
            echo "<h2>403 – Forbidden</h2>";
            echo "<p>You don’t have permission (“{$permissionName}”) to access (“{$routePath}”) this resource.</p>";
            exit;
        }
    }

    /**
     * Middleware entry point. Call this in your controllers' constructors:
     *
     *     Auth::handle();
     *     Rbac::handle('Edit'); // or whichever permission
     */
    public static function handle(string $permissionName = 'View', string $routePath = null): void
    {
        self::enforce($permissionName, $routePath);
    }
}
