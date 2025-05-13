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
    }

    public function index()
    {
        $userId = SessionHelper::get('user_id');
        $user   = User::find($userId);
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
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = User::find($userId);

        if (!password_verify($currentPassword, $user->password)) {
            return $this->indexWithError('Current password is incorrect.');
        }
        if ($newPassword !== $confirmPassword) {
            return $this->indexWithError('New passwords do not match.');
        }

        User::updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));
        header("Location: {$this->baseUrl}profile");
        exit;
    }

    protected function indexWithError(string $error)
    {
        $user = User::find(SessionHelper::get('user_id'));
        $this->view('profile/index', ['user' => $user, 'error' => $error]);
    }
}
