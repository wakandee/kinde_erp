<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\SessionHelper;
use App\Core\Database;
use App\Models\User;
use App\Models\PasswordReset;

class Auth
{
    /**
     * Ensure the user is logged in; otherwise redirect to login.
     */
    public static function handle(): void
    {
        SessionHelper::start();
        if (! SessionHelper::get('user_id')) {
            // Load base_url from config
            $config = require __DIR__ . '/../../config/config.php';
            $loginUrl = rtrim($config['base_url'], '/') . '/login';
            header('Location: ' . $loginUrl);
            exit;
        }
    }Controller extends Controller
{
    protected string $baseUrl;

    public function __construct()
    {
        // Load base_url from config
        $config = require __DIR__ . '/../../config/config.php';
        $this->baseUrl = $config['base_url'];
    }

    public function showLoginForm(array $data = [])
    {
        // Render login form with optional error
        $this->view('auth/login', $data);
    }

    public function login()
    {
        SessionHelper::start();

        $identifier = trim($_POST['identifier'] ?? '');
        $password   = $_POST['password'] ?? '';

        // Fetch user by email or username
        $user = User::findByEmailOrUsername($identifier);
        if (!$user || !password_verify($password, $user->password)) {
            return $this->showLoginForm([ 'error' => 'Invalid credentials.']);
        }

        // Store user info in session
        SessionHelper::set('user_id', $user->id);
        SessionHelper::set('username', $user->username);

        // Redirect to home/dashboard
        header("Location: {$this->baseUrl}");
        exit;
    }

    public function logout()
    {
        SessionHelper::start();
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
        $email = trim($_POST['email'] ?? '');
        // Generate token and expiry
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiry

        // Create password reset entry
        PasswordReset::create($email, $token, $expires);

        // TODO: send email with link: {$this->baseUrl}reset-password?token={$token}
        $status = 'If that email exists, a reset link has been sent.';
        return $this->showForgotForm(['status' => $status]);
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

        if ($password !== $password_confirm) {
            return $this->showResetForm([ 'error' => 'Passwords do not match.', 'token' => $token ]);
        }

        // Validate token
        $reset = PasswordReset::findValid($token);
        if (!$reset) {
            return $this->showResetForm([ 'error' => 'Invalid or expired token.', 'token' => $token ]);
        }

        // Fetch user by email
        $user = User::findByEmailOrUsername($reset->email);
        if (!$user) {
            return $this->showResetForm([ 'error' => 'User not found.', 'token' => $token ]);
        }

        // Update password
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id'       => $user->id
        ]);

        // Mark token as used
        $reset->markUsed();

        // Redirect to login
        header("Location: {$this->baseUrl}login");
        exit;
    }
}

