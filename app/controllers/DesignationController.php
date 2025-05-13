<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\Designation;
use App\Models\Department;
use App\Core\SessionHelper;

class DesignationController extends Controller
{
    public function __construct()
    {
        Auth::handle();
    }

    public function index()
    {
        $designations = Designation::all();
        $this->view('designations/index', ['designations' => $designations]);
    }

    public function create()
    {
        $departments = Department::all();
        $this->view('designations/form', ['departments' => $departments]);
    }

    public function store()
    {
        $name         = trim($_POST['name'] ?? '');
        $departmentId = (int)($_POST['department_id'] ?? 0);
        Designation::create($name, $departmentId, SessionHelper::get('user_id'));
        header("Location: {$this->baseUrl}designations");
        exit;
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        $departments = Department::all();
        $this->view('designations/form', [
            'designation' => $designation,
            'departments' => $departments
        ]);
    }

    public function update($id)
    {
        $name         = trim($_POST['name'] ?? '');
        $departmentId = (int)($_POST['department_id'] ?? 0);
        Designation::update($id, $name, $departmentId);
        header("Location: {$this->baseUrl}designations");
        exit;
    }

    public function destroy($id)
    {
        Designation::delete($id);
        header("Location: {$this->baseUrl}designations");
        exit;
    }

    public function getByDepartment($departmentId)
    {
        header('Content-Type: application/json');
        $designations = Designation::getByDepartment($departmentId);
        echo json_encode($designations);
        exit;
    }

}
