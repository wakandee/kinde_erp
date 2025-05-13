<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\SessionHelper;
use App\Middleware\Auth;
use App\Models\Department;
use App\Models\User;

class TrackerController extends Controller
{
    // Load base_url from config
            
    public function __construct()
    {
        Auth::handle();  // Protect all TrackerController actions
        parent::__construct(); // ✅ Call this first
    }

    public function index()
    {
        $tracker = Department::all();
        $this->view('tracker/index', ['tracker' => $tracker]);
    }

    public function create()
    {
        $currentUserId = SessionHelper::get('user_id');
        $allUsers = User::all_users_names();

        // Reorder: current user first
        usort($allUsers, function ($a, $b) use ($currentUserId) {
            return ($a->id === $currentUserId) ? -1 : (($b->id === $currentUserId) ? 1 : 0);
        });

        $this->view('tracker/form', ['users' => $allUsers, 'currentUserId' => $currentUserId]);
    }


    public function store()
    {
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            SessionHelper::flash('error', 'Department name is required.');
            header("Location: {$this->baseUrl}tracker/create");
            exit;
        }

        Department::create($name, SessionHelper::get('user_id'));
        SessionHelper::flash('success', 'Department created successfully.');
        header("Location: {$this->baseUrl}tracker");
        exit;
    }

    public function edit($id)
    {
        $department = Department::find($id);

        if (! $department) {
            SessionHelper::flash('error', 'Department not found.');
            header("Location: {$this->baseUrl}tracker");
            exit;
        }

        $this->view('tracker/form', ['department' => $department]);
    }

    public function update($id)
    {
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            SessionHelper::flash('error', 'Department name cannot be empty.');
            header("Location: {$this->baseUrl}tracker");
            exit;
        }

        Department::update($id, $name);
        SessionHelper::flash('success', 'Department updated successfully.');
        header("Location: {$this->baseUrl}tracker");
        exit;
    }

    public function destroy($id)
    {
        $success = Department::delete($id);

        if (! $success) {
            SessionHelper::flash('error', 'Cannot delete department. It is linked to one or more designations.');
            header("Location: {$this->baseUrl}tracker");
            exit;
        }

        SessionHelper::flash('success', 'Department deleted successfully.');
        header("Location: {$this->baseUrl}tracker");
        exit;
    }

}
