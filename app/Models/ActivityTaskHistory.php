<?php
// app/Models/ActivityTaskHistory.php

namespace App\Models;

use App\Core\Database;

class ActivityTaskHistory
{
    public static function getHistoryByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT h.*, u.name AS editor_name
            FROM activity_task_history h
            LEFT JOIN users u ON h.edited_by = u.id
            WHERE h.task_id = ?
            ORDER BY h.edited_at DESC
        ");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function logEdit($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO activity_task_history 
            (task_id, activity_id, edited_by, old_task_title, old_assignee_id, old_deliverable, old_resource, old_status, old_comments) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['task_id'],
            $data['activity_id'],
            $data['edited_by'],
            $data['old_task_title'],
            $data['old_assignee_id'],
            $data['old_deliverable'],
            $data['old_resource'],
            $data['old_status'],
            $data['old_comments']
        ]);
    }

}

?>