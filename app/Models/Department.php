<?php
namespace App\Models;

use App\Core\Database;

class Department
{
    public $id;
    public $name;

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM departments ORDER BY name ASC");
        //$stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
        //return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function all_departments()
    {
        $db = Database::getInstance();
        $sql = "SELECT d.*, 
                       COUNT(u.id) AS staff_count
                FROM departments d
                LEFT JOIN designations des ON des.department_id = d.id
                LEFT JOIN users u ON u.designation_id = des.id
                GROUP BY d.id
                ORDER BY d.name ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM departments WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

 public static function create(string $name, int $user_id)
{
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO departments (name, created_by) VALUES (:name, :created_by)");
    return $stmt->execute(['name' => $name,'created_by' => $user_id]);
}


    public static function update(int $id, string $name)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE departments SET name = :name WHERE id = :id");
        return $stmt->execute(['name' => $name, 'id' => $id]);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM departments WHERE id = ?");

        try {
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                // Integrity constraint violation
                return false;
            }

            // Re-throw for other unhandled errors
            throw $e;
        }
    }

}
