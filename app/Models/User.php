<?php
namespace App\Models;

use App\Core\Database; // Assumes you have a Database wrapper

class User
{
    public $id;
    public $name;
    public $email;
    public $username;
    public $password;
    public $phone_number;
    public $designation_id;
    public $department_id;

    public static function findByEmailOrUsername(string $identifier)
    {
        $db = Database::getInstance();
        $sql = "SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $identifier]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }
}
