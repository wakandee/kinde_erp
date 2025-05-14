<?php
namespace App\Models;

use App\Core\Database;

class ActivityWeeklyRemark
{
    public $id;
    public $activity_id;
    public $remark_type;
    public $remark;
    public $commenter_user_id;
    public $created_at;

    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO activity_weekly_remarks (activity_id, remark_type, remark, commenter_user_id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['activity_id'],
            $data['remark_type'],
            $data['remark'],
            $data['commenter_user_id']
        ]);
    }

    public static function getRemarks($activity_id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM activity_weekly_remarks WHERE activity_id = ?");
        $stmt->execute([$activity_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}

?>