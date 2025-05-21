<?php

// app/Controllers/ActivityController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\SessionHelper;
use App\Middleware\Auth;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityTask;
// use App\Helpers\AuthHelper;
use App\Middleware\Rbac;
use App\Helpers\RBACHelper; 

// use App\Models\ActivityTaskEdit;
use App\Models\ActivityTaskHistory; 
use App\Models\ActivityWeeklyRemark;

class ActivityController extends Controller
{
    public function __construct()
    {
        Auth::handle();  // Protect all activity routes
        // Auth::handle();             // ensure logged in
        // Rbac::handle('View');       // enforce “View” permission
        parent::__construct();      // load base URL, etc.
    }


public function index()
    {
        $userId = SessionHelper::get('user_id');

        // Read filters
        $interval  = $_GET['interval']  ?? 'daily';
        $picker    = $_GET['picker']    ?? date('Y-m-d');
        $status    = $_GET['status']    ?? '';    // status filter

        // Persist into session for reload
        SessionHelper::set('interval', $interval);
        SessionHelper::set('picker',   $picker);
        SessionHelper::set('status',   $status);

        // Compute date range
        switch ($interval) {
            case 'weekly':
                if (strpos($picker, '-W') !== false) {
                    list($year, $week) = explode('-W', $picker);
                    $dto = new \DateTime();
                    $dto->setISODate((int)$year, (int)$week);
                    $start = $dto->format('Y-m-d');
                    $end = $dto->modify('+6 days')->format('Y-m-d');
                } else {
                    // Fallback to today's week if invalid input
                    $dto = new \DateTime();
                    $dto->setISODate((int)date('Y'), (int)date('W'));
                    $start = $dto->format('Y-m-d');
                    $end = $dto->modify('+6 days')->format('Y-m-d');
                }
                break;

            case 'monthly':
                list($year, $month) = explode('-', $picker);
                $start = sprintf('%04d-%02d-01', $year, $month);
                $end = (new \DateTime($start))->modify('last day of this month')->format('Y-m-d');
                break;
            default:
                $start = $picker;
                $end = $picker;
        }

        // Fetch tasks
        $tasks = ActivityTask::getByUserIdAndDateRange($userId, $start, $end, $status);

        $taskIds = array_map(fn($t) => $t->task_id, $tasks);
        $latestComments = ActivityTask::getLatestCommentsForTasks($taskIds);

        $this->view('activities/index', [
        'tasks'          => $tasks,
        'latestComments' => $latestComments,
        'interval'       => $interval,
        'pickerValue'    => $picker,
        'startDate'      => $start,
        'endDate'        => $end,
        'statusFilter'   => $status,
    ]);
    }





    public function create()
    {
        $currentUserId = SessionHelper::get('user_id');

        if (RBACHelper::has_permission('Assign', 'activities_assign')) {
            // Fetch all users
            $allUsers = User::all_users_names();

            // Sort so that the current user appears first
            usort($allUsers, function ($a, $b) use ($currentUserId) {
                if ($a->id === $currentUserId) return -1;
                if ($b->id === $currentUserId) return 1;
                return 0;
            });
        } else {
            // No assign permission → only allow self
            $user          = new \stdClass();
            $user->id      = $currentUserId;
            $user->name    = SessionHelper::get('user_name')  // or fetch via User::find($currentUserId)
                             ?? 'SELF';

            $allUsers = [ $user ];
        }

        // Pass to the form view
        $this->view('activities/form', [
            'users'         => $allUsers,
            'currentUserId' => $currentUserId,
        ]);
    }


   public function store()
    {
        $userId       = SessionHelper::get('user_id');
        $activityDate = $_POST['activity_date'];
        $weekNumber   = $_POST['week'];

        if (!empty($_POST['tasks']) && is_array($_POST['tasks'])) {
            foreach ($_POST['tasks'] as $task) {
                // 1) Create one Activity per task row, using that row’s title
                $activityId = Activity::create(
                    trim($task['title']),
                    $activityDate,
                    $weekNumber,
                    $userId
                );

                // 2) Create the Task under that newly created Activity
                ActivityTask::create($activityId, $task, $userId);
            }
        }

        SessionHelper::flash('success', 'Activities and Tasks created.');
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
    $task = ActivityTask::find($taskId);

    if (!$task) {
        SessionHelper::flash('error', 'Task not found.');
        header("Location: {$this->baseUrl}activities");
        exit;
    }

    // Prevent updates if already edited or status not 'Not Started'
    if (!empty($task->is_edited) || $task->status !== 'Not Started') {
        SessionHelper::flash('error', 'Task can no longer be updated.');
        header("Location: {$this->baseUrl}activities");
        exit;
    }

    // Get input
    $taskText = trim($_POST['task'] ?? '');
    $deliverable = trim($_POST['deliverable'] ?? '');
    $resource = trim($_POST['resource'] ?? '');

    if (empty($taskText) || empty($deliverable)) {
        SessionHelper::flash('error', 'Task and deliverable are required.');
        header("Location: {$this->baseUrl}activities/tasks/{$taskId}/edit");
        exit;
    }

    // Check if anything has changed
    $hasChanges = (
        $taskText !== $task->task ||
        $deliverable !== $task->deliverable ||
        $resource !== $task->resource
    );

    if ($hasChanges) {
        // Save original values into history
        $historyInserted = ActivityTaskHistory::logEdit([
            'task_id' => $task->task_id,
            'activity_id' => $task->activity_id,
            'edited_by' => SessionHelper::get('user_id'), // Get current user ID
            'old_task_title' => $task->task,
            'old_assignee_id' => $task->assignee_id,
            'old_deliverable' => $task->deliverable,
            'old_resource' => $task->resource,
            'old_status' => $task->status,
            'old_comments' => $task->status_comment ?? null,
        ]);
    }

    // Proceed to update the task
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

        // Prevent update if final status
        if (in_array($task->status, ['Done', 'Postponed', 'Cancelled'])) {
            SessionHelper::flash('error', 'Cannot update this task further.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        // $statusOptions = ActivityTask::getStatusEnumValues();

        // Define allowed status options
        $statusOptions = ['Not Started', 'In Progress', 'Done', 'Postponed', 'Cancelled'];

        // $this->view('activities/update_status', [
        //     'task' => $task,
        //     'statusOptions' => $statusOptions
        // ]);

        $this->view('activities/edit_status', [
            'task' => $task,
            'statusOptions' => $statusOptions,
            'base_url' => $this->baseUrl
        ]);
    }

    // app/Controllers/ActivityController.php

    public function view_task_history($taskId)
    {
        $task = ActivityTask::find($taskId);

        if (!$task) {
            SessionHelper::flash('error', 'Task not found.');
            header("Location: {$this->baseUrl}activities");
            exit;
        }

        $history = ActivityTaskHistory::getHistoryByTaskId($taskId);

        $this->view('activities/task_history', [
            'task' => $task,
            'history' => $history,
            'base_url' => $this->baseUrl
        ]);
    }



}
?>