<?php

// app/Controllers/ActivityController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\SessionHelper;
use App\Middleware\Auth;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityTask;
use App\Models\ActivityTaskEdit;
use App\Models\ActivityWeeklyRemark;

class ActivityController extends Controller
{
    public function __construct()
    {
        Auth::handle();  // Protect all activity routes
        parent::__construct();
    }

    public function index()
    {
        $userId = SessionHelper::get('user_id');

        // Get tasks assigned to this user
        $tasks = ActivityTask::getByUserId($userId);

        // Extract task IDs
        $taskIds = array_map(fn($task) => $task->task_id, $tasks);

        // Get latest comments from the model
        $latestComments = ActivityTask::getLatestCommentsForTasks($taskIds);

        // Pass data to view
        $this->view('activities/index', [
            'tasks' => $tasks,
            'latestComments' => $latestComments,
        ]);
    }




    public function create()
    {
        $currentUserId = SessionHelper::get('user_id');
        $allUsers = User::all_users_names();

        usort($allUsers, function ($a, $b) use ($currentUserId) {
            return ($a->id === $currentUserId) ? -1 : (($b->id === $currentUserId) ? 1 : 0);
        });

        $this->view('activities/form', ['users' => $allUsers, 'currentUserId' => $currentUserId]);
    }

    public function store()
    {
        $title = trim($_POST['title']);
        $date = $_POST['activity_date'];
        $week = $_POST['week'];
        $userId = SessionHelper::get('user_id');

        $activityId = Activity::create($title, $date, $week, $userId);

        if (isset($_POST['tasks']) && is_array($_POST['tasks'])) {
            foreach ($_POST['tasks'] as $task) {
                // var_dump($task); 
                ActivityTask::create($activityId, $task);
            }
        }

        SessionHelper::flash('success', 'Activity created.');
        header("Location: {$this->baseUrl}activities");
        exit;
    }

    public function edit_task($taskId)
    {
        $task = ActivityTask::find($taskId);

        if (!$task) {
            SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // Restrict editing if status is already changed or it's already edited
        if (!empty($task->is_edited) || $task->status !== 'Not Started') {
            SessionHelper::flash('error', 'Task cannot be edited anymore.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        $this->view('activities/edit_task', ['task' => $task]);
    }

    public function view_task_comments($taskId)
    {
        $task = ActivityTask::find($taskId);

        if (!$task) {
            SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        $updates = ActivityTask::getTaskComments($taskId);

        $this->view('activities/task_comments', [
            'task' => $task,
            'updates' => $updates,
        ]);
    }


    public function update_task($taskId)
    {
        // Fetch the task via the model
        $task = ActivityTask::find($taskId);

        if (!$task) {
            SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // Prevent updates if task has already been edited or status is not 'Not Started'
        if (!empty($task->is_edited) || $task->status !== 'Not Started') {
            SessionHelper::flash('error', 'Task can no longer be updated.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        $taskText = trim($_POST['task'] ?? '');
        $deliverable = trim($_POST['deliverable'] ?? '');
        $resource = trim($_POST['resource'] ?? '');

        if (empty($taskText) || empty($deliverable)) {
            SessionHelper::flash('error', 'Task and deliverable are required.');
            header("Location: {$this->baseUrl}activities/tasks/{$taskId}/edit");
            exit;
        }

        // Now call the model method to update the task
        $updateSuccess = ActivityTask::updateTask($taskId, $taskText, $deliverable, $resource);

        if ($updateSuccess) {
            SessionHelper::flash('success', 'Task updated successfully.');
            header("Location: {$this->baseUrl}activities");
        } else {
            SessionHelper::flash('error', 'Failed to update task.');
            header("Location: {$this->baseUrl}activities/tasks/{$taskId}/edit");
        }
        exit;
    }




    public function update_status($id)
    {
        $status = $_POST['status'] ?? null;
        $comment = trim($_POST['comment'] ?? '');
        $userId = SessionHelper::get('user_id');

        $task = ActivityTask::find($id);
        if (!$task) {
            SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // Prevent update if final status
        if (in_array($task->status, ['Done', 'Postponed', 'Cancelled'])) {
            SessionHelper::flash('error', 'Cannot update this task further.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // Require comment for all status changes except Done
        if ($status !== 'Done' && empty($comment)) {
            SessionHelper::flash('error', 'Comment is required for this status.');
            header("Location: {$this->baseUrl}activities/update_status/$id");
            exit;
        }

        // Update main task status
        ActivityTask::updateStatus($id, $status);

        // Log the update
        ActivityTask::logUpdate($id, $userId, $status, $comment);

        SessionHelper::flash('success', 'Task status updated.');
        header("Location: {$this->baseUrl}activities");
        exit;
    }


    public function show($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            SessionHelper::flash('error', 'Activity not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        $activity->tasks = ActivityTask::getByActivity($activity->activity_id);
        $this->view('activities/view', ['activity' => $activity]);
    }

    public function edit_status($id)
    {
        $task = ActivityTask::find($id);
        // var_dump($task);
        if (!$task) {
             SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // $statusOptions = ActivityTask::getStatusEnumValues();

        // Define allowed status options
        $statusOptions = ['Not Started', 'In Progress', 'Done', 'Postponed', 'Cancelled'];

        $this->view('activities/update_status', [
            'task' => $task,
            'statusOptions' => $statusOptions
        ]);

        $this->view('activities/edit_status', [
            'task' => $task,
            'statusOptions' => $statusOptions,
            'base_url' => $this->baseUrl
        ]);
    }


//     public function update_status($id)
// {
//     $status = $_POST['status'] ?? null;

//     if ($status) {
//         ActivityTask::updateStatus($id, $status);
//         SessionHelper::flash('success', 'Task status updated.');
//     }

//     header("Location: {$this->baseUrl}activities");
//     exit;
// }


}
?>