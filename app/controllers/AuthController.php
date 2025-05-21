<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\SessionHelper;
use App\Core\Database;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\UserDesignationRole;

class AuthController extends Controller
{
    protected string $baseUrl;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $this->baseUrl = $config['base_url'];
    }
    public function showLoginForm(array $data = [])
    {
        $this->view('auth/login', $data, 'login');
    }


    // public function showLoginForm(array $data = [])
    // {
    //     $this->view('auth/login', $data);
    // }

    public function login()
    {
        SessionHelper::start();

        $identifier = trim($_POST['identifier'] ?? '');
        $password   = $_POST['password'] ?? '';

        $user = User::findByEmailOrUsername($identifier);
        if (!$user || !password_verify($password, $user->password)) {
            return $this->showLoginForm(['error' => 'Invalid credentials.']);
        }

        SessionHelper::set('user_id', $user->id);
        SessionHelper::set('username', $user->username);
        SessionHelper::set('base_url', $this->baseUrl);
        SessionHelper::set('designation_id',$user->designation_id);

        // After $_SESSION['designation_id'] = $designationId;
        $_SESSION['user_permissions'] = UserDesignationRole::getPermByDesignation($user->designation_id);


        SessionHelper::flash('success', 'Welcome back, ' . $user->username . '!');
        header("Location: {$this->baseUrl}");
        exit;

    
    }

    public function logout()
    {
        SessionHelper::start();
        SessionHelper::destroy();
        SessionHelper::flash('success', 'You have been logged out.');
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
        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 3600);

        PasswordReset::create($email, $token, $expires);

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
            return $this->showResetForm(['error' => 'Passwords do not match.', 'token' => $token]);
        }

        $reset = PasswordReset::findValid($token);
        if (!$reset) {
            return $this->showResetForm(['error' => 'Invalid or expired token.', 'token' => $token]);
        }

        $user = User::findByEmailOrUsername($reset->email);
        if (!$user) {
            return $this->showResetForm(['error' => 'User not found.', 'token' => $token]);
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id'       => $user->id
        ]);

        $reset->markUsed();
        SessionHelper::flash('success', 'Password updated successfully. You can now log in.');
        header("Location: {$this->baseUrl}login");
        exit;
    }

    public static function flash(string $key, string $message): void
    {
        self::start();
        $_SESSION['flash'][$key] = $message;
    }

    public static function getFlash(string $key): ?string
    {
        self::start();
        if (!empty($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }

}
