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

   public static function user_profile(int $user_id)
    {
        $db = Database::getInstance();

        // Prepare SQL with a WHERE clause to limit by the provided user ID
        $sql = "
            SELECT 
                u.*, 
                d.name AS department_name, 
                g.name AS designation_name
            FROM users u
            LEFT JOIN designations g ON u.designation_id = g.id
            LEFT JOIN departments d ON g.department_id = d.id
            WHERE u.id = :user_id
            LIMIT 1
        ";

        $stmt = $db->prepare($sql);

        // Bind the user_id parameter to prevent SQL injection
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);

        $stmt->execute();

        // Fetch a single object (or null if not found)
        return $stmt->fetch(\PDO::FETCH_OBJ);
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
        $stmt = $db->prepare("SELECT u.id,u.name,u.email,u.username,u.phone_number,u.designation_id, d.department_id FROM users u LEFT JOIN designations d 
    ON u.designation_id = d.id WHERE u.id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function find_user(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users id WHERE id = ?");
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

    /**
     * Update a user’s password.
     *
     * @param int    $id             The user’s ID
     * @param string $hashedPassword The new password, already hashed
     * @return bool                  True on success, false on failure
     */
    public static function updatePassword(int $id, string $hashedPassword): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE users
               SET password   = :password,
                   updated_at = NOW()
             WHERE id         = :id
        ");

        return $stmt->execute([
            'id'       => $id,
            'password' => $hashedPassword,
        ]);
    }
}
