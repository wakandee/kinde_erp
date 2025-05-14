<?php
namespace App\Controllers;

use App\Helpers\SessionHelper;

class UiPreferenceController
{
    public function setTheme()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
            $theme = $_POST['theme'] === 'dark' ? 'dark' : 'light';
            SessionHelper::start();
            $_SESSION['theme'] = $theme;
            http_response_code(200);
            echo json_encode(['status' => 'success', 'theme' => $theme]);
        } else {
            http_response_code(400);
        }
    }

    // In the future, add methods like:
    // public function setSidebarLayout() { ... }
    // public function setFontSize() { ... }
}


// namespace App\Controllers;

// class UiPreferenceController
// {
//     public function setTheme()
//     {
//         if (session_status() === PHP_SESSION_NONE) session_start();

//         $theme = $_POST['theme'] ?? 'light';
//         $_SESSION['theme'] = $theme;

//         http_response_code(200);
//         echo json_encode(['status' => 'success', 'theme' => $theme]);
//     }
// }
