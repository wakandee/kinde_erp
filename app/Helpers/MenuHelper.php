<?php
// app/Helpers/MenuHelper.php

namespace App\Helpers;

use App\Core\Database;
use App\Helpers\SessionHelper;

class MenuHelper
{
    /**
     * Returns an array of route paths (from user_routes.path)
     * that the current user’s designation has “View” permission for.
     *
     * @return string[]
     */
    public static function allowedViewRoutes(): array
    {
        SessionHelper::start();
        $userId = SessionHelper::get('user_id');
        if (! $userId) return [];

        // Find designation
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT designation_id
            FROM users
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        $designationId = $stmt->fetchColumn();
        if (! $designationId) return [];

        // Fetch all route paths for which this designation has permission 'View'
        $stmt = $db->prepare("
            SELECT TRIM(LEADING '/' FROM ur.path) AS path
            FROM user_designation_roles udr
            JOIN user_permissions up ON udr.permission_id = up.id
            JOIN user_routes ur      ON udr.route_id      = ur.id
            WHERE udr.designation_id = ?
              AND up.name            = 'View'
        ");
        $stmt->execute([$designationId]);
        return array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'path');
    }

    
}
