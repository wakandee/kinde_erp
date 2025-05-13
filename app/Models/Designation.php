<?php
namespace App\Models;

use App\Core\Database;

class Designation
{
    public $id;
    public $name;
    public $department_id;
    public $created_by;

    public static function all()
    {
        $db = Database::getInstance();
        $sql = "SELECT g.*, d.name AS department_name 
                FROM designations g
                LEFT JOIN departments d ON g.department_id = d.id
                ORDER BY g.name ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function all_designation()
    {
        $db = Database::getInstance();
        $sql = "SELECT g.*, 
                       d.name AS department_name,
                       COUNT(u.id) AS staff_count
                FROM designations g
                LEFT JOIN departments d ON g.department_id = d.id
                LEFT JOIN users u ON u.designation_id = g.id
                GROUP BY g.id, d.name
                ORDER BY g.name ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM designations WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(string $name, int $departmentId, int $createdBy)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO designations (name, department_id, created_by)
            VALUES (:name, :department_id, :created_by)
        ");
        return $stmt->execute([
            'name' => $name,
            'department_id' => $departmentId,
            'created_by' => $createdBy
        ]);
    }

    public static function update(int $id, string $name, int $departmentId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE designations SET name = :name, department_id = :department_id 
            WHERE id = :id
        ");
        return $stmt->execute([
            'name' => $name,
            'department_id' => $departmentId,
            'id' => $id
        ]);
    }

    public static function delete(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM designations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getByDepartment($departmentId)
{
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT id, name FROM designations WHERE department_id = ?");
    $stmt->execute([$departmentId]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

}
