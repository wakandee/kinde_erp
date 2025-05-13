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
        $data = [
            'user_id' => SessionHelper::get('user_id'),
            'week' => $_POST['week'],
            'title' => $_POST['title'],
            'date' => $_POST['activity_date']
        ];

        $activity_id = Activity::create($data);

        foreach ($_POST['tasks'] as $task) {
            ActivityTask::create([
                'activity_id' => $activity_id,
                'task' => $task['task'],
                'assignee_id' => $task['assignee'],
                'deliverable' => $task['deliverable'],
                'resource' => $task['resource']
            ]);
        }

        SessionHelper::flash('success', 'Activity successfully created.');
        header("Location: {$this->baseUrl}tracker");
        exit;
    }
}

?>