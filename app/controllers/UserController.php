<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\User;
use App\Helpers\SessionHelper;
use App\Models\Department;
use App\Models\Designation;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handle();

        // Enforce “View” on all index/list actions by default
        $this->authorize('View');
    }

    public function index()
    {
        // List users
        $users = User::allWithRelations();
        $this->view('users/index', ['users' => $users]);
    }

    public function create()
    {
        // Only roles with “Create” on “users” may see the form
        $this->authorize('Create');
        $departments = Department::all();
        $this->view('users/form', ['departments' => $departments]);
    }

    public function store()
    {
        $this->authorize('Create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: {$this->baseUrl}users/create");
            exit;
        }

        $data = [
            'name'           => trim($_POST['name'] ?? ''),
            'email'          => trim($_POST['email'] ?? ''),
            'username'       => trim($_POST['username'] ?? ''),
            'password'       => password_hash(trim($_POST['password'] ?? ''), PASSWORD_DEFAULT),
            'phone_number'   => trim($_POST['phone_number'] ?? ''),
            'designation_id' => $_POST['designation_id'] ?? null,
        ];

        User::create($data);
        header("Location: {$this->baseUrl}users");
        exit;
    }

    public function edit($id)
    {
        $this->authorize('Edit','users');
        $user = User::find($id);

        $departments = Department::all();

        // Load designations only for user's current department
        $designations = [];
        
        if ($user && $user->department_id) {
            $designations = Designation::getByDepartment($user->department_id);
        }

        // var_dump($designations);exit();

        $this->view('users/form', [
            'user'         => $user,
            'departments'  => $departments,
            'designations' => $designations,
        ]);
    }


    public function update($id)
    {
        $this->authorize('Edit');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: {$this->baseUrl}users");
            exit;
        }

        $data = [
            'name'           => trim($_POST['name'] ?? ''),
            'email'          => trim($_POST['email'] ?? ''),
            'username'       => trim($_POST['username'] ?? ''),
            'phone_number'   => trim($_POST['phone_number'] ?? ''),
            'designation_id' => $_POST['designation_id'] ?? null,
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        }

        User::update($id, $data);
        header("Location: {$this->baseUrl}users");
        exit;
    }

    public function delete($id)
    {
        $this->authorize('Delete');
        User::delete($id);
        header("Location: {$this->baseUrl}users");
        exit;
    }
}
