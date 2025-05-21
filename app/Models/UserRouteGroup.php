<?php

namespace App\Models;

use App\Core\Database;

class UserRouteGroup
{
    public $id, $name;

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM user_route_groups ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_route_groups WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create( $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO user_route_groups (name) VALUES (:name)");
        return $stmt->execute($data);
    }

    public static function update(int $id, $name)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE user_route_groups SET name = :name WHERE id = :id");
        $data['name'] = $name;
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM user_route_groups WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
