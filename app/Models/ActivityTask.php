<?php

namespace App\Models;

use App\Core\Database;

class ActivityTask
{
    public $id;
    public $activity_id;
    public $task;
    public $assignee_id;
    public $deliverable;
    public $resource;
    public $status;
    public $status_date;
    public $status_comment;
    public $is_edited;
    public $created_at;

    public static function create($activity_id ,$task)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO activity_tasks 
            (activity_id, task, assignee_id, deliverable, resource, status, status_date, is_edited, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $activity_id,
            $task['task'],
            $task['assignee_id'],
            $task['deliverable'],
            $task['resource'],
            'Not started', // default status
            null,
            null,
            0
        ]);
    }

    // In app/Models/ActivityTask.php
    public static function getByUserId($userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT at.*, a.title AS activity_title, a.activity_date, a.week_number, u.name AS assignee_name
            FROM activity_tasks at
            JOIN activities a ON at.activity_id = a.activity_id
            LEFT JOIN users u ON at.assignee_id = u.id
            WHERE a.created_by = ? OR at.assignee_id = ?
            ORDER BY a.activity_date DESC
        ");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function getTaskComments($taskId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("
            SELECT atu.*, u.name AS user_name 
            FROM activity_task_updates atu
            LEFT JOIN users u ON atu.user_id = u.id
            WHERE atu.task_id = ?
            ORDER BY atu.created_at DESC
        ");
        $stmt->execute([$taskId]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function getLatestCommentsForTasks($taskIds)
    {
        if (empty($taskIds)) {
            return [];
        }

        $db = Database::getInstance();

        // Prepare placeholders (?, ?, ...) based on taskIds count
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));

        // Fetch latest comment per task_id using a subquery
        $sql = "
            SELECT atu.task_id, atu.comment
            FROM activity_task_updates atu
            INNER JOIN (
                SELECT task_id, MAX(created_at) as latest
                FROM activity_task_updates
                WHERE task_id IN ($placeholders)
                GROUP BY task_id
            ) latest_updates ON latest_updates.task_id = atu.task_id AND latest_updates.latest = atu.created_at
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($taskIds);

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Map by task_id
        $comments = [];
        foreach ($results as $row) {
            $comments[$row['task_id']] = $row['comment'];
        }

        return $comments;
    }





    public static function getByActivity($activityId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT at.*, u.name AS assignee_name
                              FROM activity_tasks at
                              LEFT JOIN users u ON at.assignee_id = u.id
                              WHERE at.activity_id = ?");
        $stmt->execute([$activityId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public static function findByActivity($activity_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activity_tasks WHERE activity_id = ?");
        $stmt->execute([$activity_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function updateStatus($taskId, $status, $comment = null)
    {
        $db = Database::getInstance();

        // Begin transaction
        $db->beginTransaction();

        try {
            // 1. Update the task status only
            $stmt1 = $db->prepare("
                UPDATE activity_tasks 
                SET status = ?, status_date = NOW()
                WHERE task_id = ?
            ");
            $stmt1->execute([$status, $taskId]);

            // 2. Insert comment into activity_task_updates (only if provided)
            if ($comment !== null && trim($comment) !== '') {
                $stmt2 = $db->prepare("
                    INSERT INTO activity_task_updates (task_id, status, comment, created_at)
                    VALUES (?, ?, ?, NOW())
                ");
                $stmt2->execute([$taskId, $status, $comment]);
            }

            // Commit transaction
            $db->commit();
            return true;

        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }




    public static function find($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activity_tasks WHERE task_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject(); // returns stdClass or false
    }

    public static function updateTask($taskId, $taskText, $deliverable, $resource)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE activity_tasks 
            SET task = ?, deliverable = ?, resource = ?, is_edited = 1, updated = NOW()
            WHERE task_id = ?
        ");
        return $stmt->execute([$taskText, $deliverable, $resource, $taskId]);
    }

    public static function logUpdate($taskId, $userId, $status, $comment)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO activity_task_updates (task_id, user_id, status, comment) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$taskId, $userId, $status, $comment]);
    }

    public static function getStatusEnumValues()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SHOW COLUMNS FROM activity_tasks LIKE 'status'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            $vals = str_getcsv($matches[1], ',', "'");
            return $vals;
        }

        return [];
    }

}
