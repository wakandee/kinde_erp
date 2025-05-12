<?php
namespace App\Controllers;

use App\Core\Controller;

class ThemeController extends Controller
{
    public function index()
    {
        // Example: Render a view to choose a theme
        $this->view('themes/index');
    }

    public function switch($theme)
    {
        $_SESSION['theme'] = $theme;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
