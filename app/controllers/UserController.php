<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\User;
use App\Helpers\SessionHelper;
use App\Models\Department;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(); 
        Auth::handle();
    }

    public function index()
    {
        $users = User::allWithRelations();
        $this->view('users/index', ['users' => $users]);
    }

   public function create()
    {
        $departments = Department::all();
        $this->view('users/form', ['departments' => $departments]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => trim($_POST['name'] ?? ''),
                'email'          => trim($_POST['email'] ?? ''),
                'username'       => trim($_POST['username'] ?? ''),
                'password'       => password_hash(trim($_POST['password'] ?? ''), PASSWORD_DEFAULT),
                'phone_number'   => trim($_POST['phone_number'] ?? ''),
                'designation_id' => $_POST['designation_id'] ?? null,
            ];

            // echo '<pre>';
            // print_r($_POST);
            // exit;
            User::create($data);
            header("Location: {$this->baseUrl}users");
            exit;
        }

        // Optional fallback
        header("Location: {$this->baseUrl}users/create");
        exit;
    }


    public function edit($id)
    {
        $user = User::find($id);

         $departments = Department::all();
        $this->view('users/form', ['user' => $user,'departments' => $departments]);
        // $this->view('users/form', ['user' => $user]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // If not POST, redirect or show error
        header("Location: {$this->baseUrl}users");
        exit;
    }

    public function delete($id)
    {
        User::delete($id);
        header("Location: {$this->baseUrl}users");
        exit;
    }
}
