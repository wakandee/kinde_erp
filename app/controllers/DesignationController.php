<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\Designation;
use App\Models\Department;
use App\Helpers\SessionHelper;

class DesignationController extends Controller
{
    public function __construct()
    {
        parent::__construct(); 
        Auth::handle();
    }

    public function index()
    {
        $designations = Designation::all_designation();
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
        $name = trim($_POST['name'] ?? '');
        $departmentId = (int)($_POST['department_id'] ?? 0);

        if (!$name || $departmentId <= 0) {
            SessionHelper::flash('error','Name and valid Department are required.' );
            header("Location: {$this->baseUrl}designations/edit/{$id}");
            exit;
        }

        try {
            Designation::update($id, $name, $departmentId);
            SessionHelper::flash('success', 'Designation updated successfully.');
        } catch (\PDOException $e) {
            SessionHelper::flash('error', 'Failed to update designation: ' . $e->getMessage());
        }

        header("Location: {$this->baseUrl}designations");
        exit;
    }


    public function destroy($id)
    {
        try {
            Designation::delete($id);
            SessionHelper::flash('success', 'Designation deleted successfully.');
        } catch (\PDOException $e) {
            SessionHelper::flash('error', 'Cannot delete designation: it is in use.');
        }

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
