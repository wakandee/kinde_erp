<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        Auth::handle(); // Centralized authentication check
    }

    public function index()
    {
        $this->view('home'); // View gets 'base_url' from Controller
    }
}

Implement centralized authorization middleware - Added Auth middleware to protect routes - Applied Auth::handle() in HomeController and DepartmentController - Ensured only logged-in users access protected pages