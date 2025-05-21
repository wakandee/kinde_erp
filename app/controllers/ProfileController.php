<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\User;
use App\Helpers\SessionHelper;

class ProfileController extends Controller
{
    public function __construct()
    {
        Auth::handle();
        parent::__construct(); 
    }

    public function index()
    {
        $userId = SessionHelper::get('user_id');
        $user   = User::user_profile($userId);
        $this->view('profile/index', ['user' => $user]);
    }

    public function update()
    {
        $userId      = SessionHelper::get('user_id');
        $name        = trim($_POST['name'] ?? '');
        $phone       = trim($_POST['phone_number'] ?? '');
        // TODO: validate
        User::updateProfile($userId, $name, $phone);
        header("Location: {$this->baseUrl}profile");
        exit;
    }

    public function changePassword()
    {
        $userId          = SessionHelper::get('user_id');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password']     ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // 1) Fetch the user
        $user = User::find_user($userId);
        if (! $user) {
            SessionHelper::flash('error', 'User not found.');
            header("Location: {$this->baseUrl}change-password");
            exit;
        }

        // 2) Verify current password
        if (! password_verify($currentPassword, $user->password)) {
            SessionHelper::flash('error', 'Current password is incorrect.');
            header("Location: {$this->baseUrl}change-password");
            exit;
        }

        // 3) Check new vs confirm
        if ($newPassword !== $confirmPassword) {
            SessionHelper::flash('error', 'New passwords do not match.');
            header("Location: {$this->baseUrl}change-password");
            exit;
        }

        // 4) Attempt to update
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        if (User::updatePassword($userId, $hashed)) {
            SessionHelper::flash('success', 'Password changed successfully.');
            header("Location: {$this->baseUrl}profile");
        } else {
            SessionHelper::flash('error', 'An error occurred. Please try again.');
            header("Location: {$this->baseUrl}change-password");
        }
        exit;
    }



    /**
     * GET  /change-password
     */
    public function showChangePasswordForm()
    {
        // Pull any one‐time error message
        // $error = SessionHelper::pull('password_error');
        $this->view('profile/change-password');
    }
}
