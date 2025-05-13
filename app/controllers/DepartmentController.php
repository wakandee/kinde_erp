<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\SessionHelper;
use App\Middleware\Auth;
use App\Models\Department;

class DepartmentController extends Controller
{
    // Load base_url from config
            
    public function __construct()
    {
        Auth::handle();  // Protect all DepartmentController actions
    }

    public function index()
    {
        $departments = Department::all();
        $this->view('departments/index', ['departments' => $departments]);
    }

    public function create()
    {
        $this->view('departments/form');
    }

    public function store()
    {
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            SessionHelper::flash('error', 'Department name is required.');
            header("Location: {$this->baseUrl}departments/create");
            exit;
        }

        Department::create($name, SessionHelper::get('user_id'));
        SessionHelper::flash('success', 'Department created successfully.');
        header("Location: {$this->baseUrl}departments");
        exit;
    }

    public function edit($id)
    {
        $department = Department::find($id);

        if (! $department) {
            SessionHelper::flash('error', 'Department not found.');
            header("Location: {$this->baseUrl}departments");
            exit;
        }

        $this->view('departments/form', ['department' => $department]);
    }

    public function update($id)
    {
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            SessionHelper::flash('error', 'Department name cannot be empty.');
            header("Location: {$this->baseUrl}departments");
            exit;
        }

        Department::update($id, $name);
        SessionHelper::flash('success', 'Department updated successfully.');
        header("Location: {$this->baseUrl}departments");
        exit;
    }

    public function destroy($id)
    {
        Department::delete($id);
        SessionHelper::flash('success', 'Department deleted successfully.');
        header("Location: {$this->baseUrl}departments");
        exit;
    }
}
