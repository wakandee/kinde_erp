<?php

namespace App\Models;

use App\Core\Database;

class UserRoute
{
    public $id, $name, $path, $group_id, $group_name;

    public static function allWithGroup()
    {
        $db = Database::getInstance();
        $sql = "SELECT r.*, g.name AS group_name 
                FROM user_routes r 
                LEFT JOIN user_route_groups g ON r.group_id = g.id 
                ORDER BY g.name ASC, r.name ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function all()
    {
        $db = Database::getInstance();
        $sql = "SELECT ur.*, g.name AS group_name
                FROM user_routes ur
                LEFT JOIN user_route_groups g ON ur.group_id = g.id
                ORDER BY g.name, ur.name";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_routes WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO user_routes (name, path, group_id)
            VALUES (:name, :path, :group_id)
        ");
        return $stmt->execute($data);
    }

    public static function update(int $id, array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE user_routes
            SET name = :name, path = :path, group_id = :group_id
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM user_routes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
