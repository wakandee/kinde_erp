<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\SessionHelper;

class HomeController extends Controller
{
    public function index()
    {
        // Ensure only logged-in users can access home
        if (!SessionHelper::get('user_id')) {
            header("Location: {$data['base_url']}login");
            exit;
        }

        $this->view('home'); // 'base_url' is automatically injected from Controller
    }
}
