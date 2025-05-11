<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use App\Core\SessionHelper;

class AuthController extends Controller
{
    public function showLoginForm(array $data = [])
    {
        // No POST data yet, just render form
        $this->view('auth/login', $data);
    }

    public function login()
    {
        // TODO: Validate input, check user, verify password, set session
        $identifier = $_POST['identifier'] ?? '';
        $password   = $_POST['password'] ?? '';

        // Simple example lookup:
        $user = User::findByEmailOrUsername($identifier);
        if (!$user || !password_verify($password, $user->password)) {
            return $this->showLoginForm(['error' => 'Invalid credentials.']);
        }

        // Initiate session
        SessionHelper::start();
        SessionHelper::set('user_id', $user->id);
        // TODO: redirect to dashboard or home
        header("Location: {$this->baseUrl}");
        exit;
    }

    public function logout()
    {
        SessionHelper::destroy();
        header("Location: {$this->baseUrl}login");
        exit;
    }

    public function showForgotForm(array $data = [])
    {
        $this->view('auth/forgot_password', $data);
    }

    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';
        // TODO: generate token, save to password_resets, send email
        $status = 'If that email exists, a reset link has been sent.';
        $this->showForgotForm(['status' => $status]);
    }

    public function showResetForm()
    {
        $token = $_GET['token'] ?? '';
        $this->view('auth/reset_password', ['token' => $token]);
    }

    public function resetPassword()
    {
        $token            = $_POST['token'] ?? '';
        $password         = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // TODO: validate token, check expiry, update user password
        if ($password !== $password_confirm) {
            return $this->showResetForm(['error' => 'Passwords do not match.', 'token' => $token]);
        }

        // On success:
        header("Location: {$this->baseUrl}login");
        exit;
    }
}
