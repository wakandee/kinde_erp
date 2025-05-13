<?php
// app/Models/Activity.php

namespace App\Models;

use App\Core\Database;

class Activity
{
    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO activities (user_id, week, title, date) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['user_id'],
            $data['week'],
            $data['title'],
            $data['date']
        ]);
        return $db->lastInsertId();
    }

    public static function allByUser($user_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activities WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
