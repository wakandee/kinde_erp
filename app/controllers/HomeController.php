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