<?php
namespace App\Models;

use App\Core\Database;

class ActivityTaskEdit
{
    public $id;
    public $task_id;
    public $editor_user_id;
    public $previous_values;
    public $edited_at;

    public static function logEdit($task_id, $editor_id, $prev)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO activity_task_edits (task_id, editor_user_id, previous_values)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $task_id,
            $editor_id,
            json_encode($prev)
        ]);
    }

    public static function getEdits($task_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activity_task_edits WHERE task_id = ? ORDER BY edited_at DESC");
        $stmt->execute([$task_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}

