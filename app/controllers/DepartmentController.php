<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
        Auth::handle();  // Protect all DepartmentController actions
    }

    public function index()
    {
        $departments = Department::all();  // Assumes you’ll add a Department::all() method
        $this->view('departments/index', ['departments' => $departments]);
    }

    public function create()
    {
        $this->view('departments/form');
    }

    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        // TODO: validate and save
        Department::create($name, SessionHelper::get('user_id'));
        header("Location: {$this->baseUrl}departments");
        exit;
    }

    public function edit($id)
    {
        $department = Department::find($id);
        $this->view('departments/form', ['department' => $department]);
    }

    public function update($id)
    {
        $name = trim($_POST['name'] ?? '');
        Department::update($id, $name);
        header("Location: {$this->baseUrl}departments");
        exit;
    }

    public function destroy($id)
    {
        Department::delete($id);
        header("Location: {$this->baseUrl}departments");
        exit;
    }
}
