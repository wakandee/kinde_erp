<?php
namespace App\Models;

use App\Core\Database;

class Activity
{
        public $id;
    public $user_id;
    public $title;
    public $activity_date;
    public $week_number;
    public $created_at;

    /**
     * Create a new Activity record.
     *
     * @param string $title
     * @param string $activity_date  YYYY-MM-DD
     * @param int    $week_number    ISO week number
     * @param int    $user_id        Creator user ID
     * @return int|false             The new activity_id or false on failure
     */
    public static function create(string $title, string $activity_date, int $week_number, int $user_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO activities (user_id, title, activity_date, week_number) VALUES (?, ?, ?, ?)"
        );

        if ($stmt->execute([$user_id, $title, $activity_date, $week_number])) {
            return (int)$db->lastInsertId();
        }

        return false;
    }

    
    // app/Models/Activity.php

    public static function getByUser($userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activities WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function find($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activities WHERE activity_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function byUserAndWeek($user_id, $week_number)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activities WHERE user_id = ? AND week_number = ?");
        $stmt->execute([$user_id, $week_number]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
