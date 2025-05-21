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

    public static function create(int $activity_id, array $task, int $createdBy): bool
{
    $db = Database::getInstance();
    $stmt = $db->prepare("
        INSERT INTO activity_tasks
          (activity_id, task, assignee_id, deliverable, resource, due_date,
           status, status_date, is_edited, created_by)
        VALUES
          (:activity_id, :task, :assignee_id, :deliverable, :resource, :due_date,
           'Not started', NULL, NULL, :created_by)
    ");

    return $stmt->execute([
        'activity_id'  => $activity_id,
        'task'         => $task['task'],
        'assignee_id'  => $task['assignee_id'],
        'deliverable'  => $task['deliverable'],
        'resource'     => $task['resource'],
        'due_date'     => $task['due_date'],
        'created_by'   => $createdBy,
    ]);
}


    // In app/Models/ActivityTask.php
    public static function getByUserId($userId, $activityDate)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT at.*, a.title AS activity_title, a.activity_date, a.week_number, u.name AS assignee_name, at.created_by, at.assignee_id
            FROM activity_tasks at
            JOIN activities a ON at.activity_id = a.activity_id
            LEFT JOIN users u ON at.assignee_id = u.id
            WHERE (at.created_by = :userId OR at.assignee_id = :userId)
              AND a.activity_date = :activityDate
            ORDER BY at.created_at DESC
        ");
        $stmt->execute([
            'userId' => $userId,
            'activityDate' => $activityDate,
        ]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function getByUserIdAndDateRange(
    int $userId,
    string $start,
    string $end,
    string $status = ''
): array {
    $db = Database::getInstance();
    $sql = "SELECT
        at.*,
        a.title AS activity_title,
        a.activity_date,
        a.week_number,
        u.name AS assignee_name
    FROM activity_tasks at
    JOIN activities a ON at.activity_id = a.activity_id
    LEFT JOIN users u ON at.assignee_id = u.id
    WHERE (at.created_by = :u OR at.assignee_id = :u)
      AND a.activity_date BETWEEN :start AND :end";

    if ($status !== '') {
        $sql .= " AND at.status = :status";
    }

    $sql .= " ORDER BY at.created_at DESC";

    $stmt = $db->prepare($sql);
    $params = [
        'u'     => $userId,
        'start' => $start,
        'end'   => $end
    ];
    if ($status !== '') {
        $params['status'] = $status;
    }

    $stmt->execute($params);
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

   /**
 * Count all tasks for a user within a date range.
 *
 * @param int    $userId
 * @param string $start   YYYY-MM-DD
 * @param string $end     YYYY-MM-DD
 * @return int
 */
public static function countByUserAndDateRange(int $userId, string $start, string $end): int
{
    $db   = Database::getInstance();
    $stmt = $db->prepare("
        SELECT COUNT(*) 
          FROM activity_tasks at
          JOIN activities      a ON at.activity_id = a.activity_id
         WHERE (at.created_by = :u OR at.assignee_id = :u)
           AND a.activity_date BETWEEN :start AND :end
    ");
    $stmt->execute([
        'u'     => $userId,
        'start' => $start,
        'end'   => $end,
    ]);
    return (int)$stmt->fetchColumn();
}

/**
 * Get counts grouped by status for a user within a date range.
 *
 * @param int    $userId
 * @param string $start   YYYY-MM-DD
 * @param string $end     YYYY-MM-DD
 * @return array          e.g. ['Not Started'=>3, 'Done'=>5, ...]
 */
public static function countByStatusAndDateRange(int $userId, string $start, string $end): array
{
    $db   = Database::getInstance();
    $stmt = $db->prepare("
        SELECT at.status, COUNT(*) AS cnt
          FROM activity_tasks at
          JOIN activities      a ON at.activity_id = a.activity_id
         WHERE (at.created_by = :u OR at.assignee_id = :u)
           AND a.activity_date BETWEEN :start AND :end
         GROUP BY at.status
    ");
    $stmt->execute([
        'u'     => $userId,
        'start' => $start,
        'end'   => $end,
    ]);

    $results = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

    // ensure every status appears, even with zero
    $allStatuses = ['Not Started','In Progress','Done','Postponed','Cancelled'];
    foreach ($allStatuses as $st) {
        if (!isset($results[$st])) {
            $results[$st] = 0;
        }
    }

    return $results;
}

/**
 * Count overdue tasks for a user within a date range.
 * “Overdue” = due_date in [start..end] AND status != Done AND due_date < today.
 *
 * @param int    $userId
 * @param string $start   YYYY-MM-DD
 * @param string $end     YYYY-MM-DD
 * @return int
 */
public static function countOverdueInRange(int $userId, string $start, string $end): int
{
    $db   = Database::getInstance();
    $stmt = $db->prepare("
        SELECT COUNT(*) 
          FROM activity_tasks at
          JOIN activities      a ON at.activity_id = a.activity_id
         WHERE (at.created_by = :u OR at.assignee_id = :u)
           AND at.due_date BETWEEN :start AND :end
           AND at.status <> 'Done'
           AND at.due_date < CURDATE()
    ");
    $stmt->execute([
        'u'     => $userId,
        'start' => $start,
        'end'   => $end,
    ]);
    return (int)$stmt->fetchColumn();
}








/**
 * Fetch raw activity_date & status for all tasks belonging to a user
 * within a custom date range (inclusive).
 *
 * @param int    $userId
 * @param string $start  YYYY-MM-DD
 * @param string $end    YYYY-MM-DD
 * @return array        Each item is an object { activity_date, status }
 */
public static function getByUserAndDateRangeRaw(int $userId, string $start, string $end): array
{
    $db = Database::getInstance();
    $stmt = $db->prepare("
        SELECT a.activity_date, at.status
          FROM activity_tasks at
          JOIN activities      a ON at.activity_id = a.activity_id
         WHERE (at.created_by = :u OR at.assignee_id = :u)
           AND a.activity_date BETWEEN :start AND :end
    ");
    $stmt->execute([
        'u'     => $userId,
        'start' => $start,
        'end'   => $end,
    ]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}



/**
 * Count the number of tasks overdue as of a specific date.
 * A task is "overdue" if due_date < $date and status != 'Done'.
 *
 * @param int    $userId
 * @param string $date   YYYY-MM-DD
 * @return int
 */
public static function countOverdueByDate(int $userId, string $date): int
{
    $db = Database::getInstance();
    $stmt = $db->prepare("
        SELECT COUNT(*)
          FROM activity_tasks at
          JOIN activities      a ON at.activity_id = a.activity_id
         WHERE (at.created_by = :u OR at.assignee_id = :u)
           AND at.due_date     < :d
           AND at.status      <> 'Done'
    ");
    $stmt->execute([
        'u' => $userId,
        'd' => $date,
    ]);
    return (int)$stmt->fetchColumn();
}



}
