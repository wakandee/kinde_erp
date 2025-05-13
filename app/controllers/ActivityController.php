<?php

// app/Controllers/ActivityController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\SessionHelper;
use App\Middleware\Auth;
use App\Models\Activity;
use App\Models\ActivityTask;
use App\Models\User;

class ActivityController extends Controller
{
    public function __construct()
    {
        Auth::handle();
        parent::__construct();
    }

    public function index()
    {
        $userId = SessionHelper::get('user_id');
        $activities = Activity::allByUser($userId);
        $this->view('tracker/index', ['activities' => $activities]);
    }

    public function create()
    {
        $currentUserId = SessionHelper::get('user_id');
        $users = User::all_users_names();

        // Self comes first
        usort($users, fn($a, $b) => ($a->id === $currentUserId) ? -1 : (($b->id === $currentUserId) ? 1 : 0));

        $this->view('activity/create', [
            'users' => $users,
            'currentUserId' => $currentUserId
        ]);
    }


    public function store()
    {
        $userId = SessionHelper::get('user_id');
        $activityDate = $_POST['activity_date'] ?? null;
        $week = $_POST['week'] ?? null;
        $title = $_POST['title'] ?? null;

        if (!$activityDate || !$title || !$userId) {
            SessionHelper::flash('error', 'Missing required fields.');
            header("Location: {$this->baseUrl}tracker/create");
            exit;
        }

        // Insert activity
        $db = \App\Core\Database::getInstance();
        $stmt = $db->prepare("INSERT INTO activities (user_id, title, activity_date, week) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $activityDate, $week]);

        $activityId = $db->lastInsertId();

        // Insert tasks (loop through rows)
        if (isset($_POST['tasks']) && is_array($_POST['tasks'])) {
            foreach ($_POST['tasks'] as $task) {
                $taskTitle = trim($task['title'] ?? '');
                $assigneeId = $task['assignee'] ?? null;
                $deliverable = trim($task['deliverable'] ?? '');
                $resource = trim($task['resource'] ?? '');

                if  ($taskTitle && $assigneeId) {
                    $taskStmt = $db->prepare("INSERT INTO activity_tasks 
                        (activity_id, task, assignee_id, deliverable, resource, status) 
                        VALUES (?, ?, ?, ?, ?, 'Not started')");
                    $taskStmt->execute([$activityId, $taskTitle, $assigneeId, $deliverable, $resource]);
                }
            }
        }

        SessionHelper::flash('success', 'Activity and tasks added successfully.');
        header("Location: {$this->baseUrl}tracker");
        exit;
    }

}

?>