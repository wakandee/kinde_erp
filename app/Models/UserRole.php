<?php
namespace App\Models;

use App\Core\Database;

class UserRole
{
    public $id, $designation_id, $route_id, $permission_id, $created_by;

    public static function all()
    {
        $db = Database::getInstance();
        $sql = "SELECT ur.*, 
                       d.name AS designation_name,
                       r.name AS route_name, 
                       r.slug AS route_slug,
                       p.name AS permission_name,
                       p.code AS permission_code
                FROM user_roles ur
                LEFT JOIN designations d ON ur.designation_id = d.id
                LEFT JOIN user_routes r ON ur.route_id = r.id
                LEFT JOIN user_permissions p ON ur.permission_id = p.id
                ORDER BY d.name ASC, r.name ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_roles WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO user_roles (designation_id, route_id, permission_id, created_by)
            VALUES (:designation_id, :route_id, :permission_id, :created_by)
        ");
        return $stmt->execute($data);
    }

    public static function deleteByDesignation(int $designationId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM user_roles WHERE designation_id = ?");
        return $stmt->execute([$designationId]);
    }
}
