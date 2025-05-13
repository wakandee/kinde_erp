<?php
namespace App\Models;

use App\Core\Database;

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

    public static function allWithRelations()
    {
        $db = Database::getInstance();
        $sql = "SELECT u.*, d.name AS department_name, g.name AS designation_name
                FROM users u
                LEFT JOIN designations g ON u.designation_id = g.id
                LEFT JOIN departments d ON g.department_id = d.id
                ";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ); // Or map to custom class if needed
    }

    public static function all_users_names()
    {
        $db = Database::getInstance();
        $sql = "SELECT id,name
                FROM users u
                ";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ); // Or map to custom class if needed
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO users (name, email, username, password, phone_number, designation_id)
            VALUES (:name, :email, :username, :password, :phone_number, :designation_id)
        ");
        return $stmt->execute($data);
    }

    public static function update(int $id, array $data)
    {
        $db = Database::getInstance();
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $data['id'] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function findByEmailOrUsername(string $identifier)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :identifier OR username = :identifier LIMIT 1");
        $stmt->execute(['identifier' => $identifier]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }
}
