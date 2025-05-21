<?php

namespace App\Models;

use App\Core\Database;

class UserPermission
{
    public $id, $name;

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM user_permissions ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function all_active()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM user_permissions WHERE status = 1 ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_permissions WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function findByName(string $name)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user_permissions WHERE name = ? LIMIT 1");
        $stmt->execute([$name]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO user_permissions (name) VALUES (:name)");
        return $stmt->execute($data);
    }

    public static function update(int $id, array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE user_permissions SET name = :name WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM user_permissions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
