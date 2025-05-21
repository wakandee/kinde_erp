<?php
namespace App\Models;

use App\Core\Database;

class UserDesignationRole
{
    public $id, $designation_id, $route_id, $permission_id;

    // RbacController.php

public function getMatrix($designationId)
{
    $db = Database::getInstance();
    $sql = "SELECT route_id, permission_id 
            FROM user_roles 
            WHERE designation_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$designationId]);
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($roles);
}


    public static function getByDesignation(int $designationId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_designation_roles WHERE designation_id = ?");
        $stmt->execute([$designationId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function updateMatrix(int $designationId, array $roles)
    {
        $db = Database::getInstance();

        $db->beginTransaction();
        try {
            $db->prepare("DELETE FROM user_designation_roles WHERE designation_id = ?")
               ->execute([$designationId]);

            $stmt = $db->prepare("
                INSERT INTO user_designation_roles (designation_id, route_id, permission_id)
                VALUES (:designation_id, :route_id, :permission_id)
            ");

            foreach ($roles as [$routeId, $permId]) {
                $stmt->execute([
                    'designation_id' => $designationId,
                    'route_id'       => (int) $routeId,
                    'permission_id'  => (int) $permId,
                ]);
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function hasAccess(int $designationId, int $routeId, int $permissionId): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM user_designation_roles 
            WHERE designation_id = :designation_id 
              AND route_id = :route_id 
              AND permission_id = :permission_id
        ");
        $stmt->execute([
            'designation_id' => $designationId,
            'route_id'       => $routeId,
            'permission_id'  => $permissionId
        ]);
        return (bool)$stmt->fetchColumn();
    }

     /**
     * Fetch all { path, action } pairs that this designation can perform.
     *
     * @param int $designationId
     * @return array [ ['path' => 'users', 'action' => 'View'], … ]
     */
    public static function getPermByDesignation(int $designationId): array
    {
        $db = Database::getInstance();
        $sql = <<<SQL
SELECT ur.path       AS path,
       up.name       AS action
FROM user_designation_roles udr
JOIN user_routes           ur ON udr.route_id       = ur.id
JOIN user_permissions      up ON udr.permission_id  = up.id
WHERE udr.designation_id = ?
  AND up.Status = 1
SQL;
        $stmt = $db->prepare($sql);
        $stmt->execute([$designationId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>