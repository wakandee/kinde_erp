<?php

// app/Models/ActivityTask.php

namespace App\Models;

use App\Core\Database;

class ActivityTask
{
    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO activity_tasks (activity_id, task, assignee_id, deliverable, resource, status, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['activity_id'],
            $data['task'],
            $data['assignee_id'],
            $data['deliverable'],
            $data['resource'],
            'Not started',
            null
        ]);
    }

    public static function allByActivity($activity_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activity_tasks WHERE activity_id = ?");
        $stmt->execute([$activity_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}