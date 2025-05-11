<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        Auth::handle();  // Protect all UserController actions
    }

    public function index()
    {
        // List users...
        $users = []; // fetch from User model
        $this->view('users/index', compact('users'));
    }

    // Other CRUD methods...
}
