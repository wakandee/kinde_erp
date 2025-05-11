<?php
namespace App\Models;

use App\Core\Database;

class PasswordReset
{
    public $id;
    public $email;
    public $token;
    public $expires_at;
    public $used_at;

    public static function create(string $email, string $token, string $expiresAt)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO password_resets (email, token, expires_at, created_at) VALUES (:email, :token, :expires)"
        );
        return $stmt->execute([
            'email'   => $email,
            'token'   => password_hash($token, PASSWORD_DEFAULT),
            'expires' => $expiresAt
        ]);
    }

    public static function findValid(string $token)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            "SELECT * FROM password_resets WHERE used_at IS NULL AND expires_at >= NOW()"
        );
        $stmt->execute();
        $resets = $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
        foreach ($resets as $reset) {
            if (password_verify($token, $reset->token)) {
                return $reset;
            }
        }
        return null;
    }

    public function markUsed(): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE password_resets SET used_at = NOW() WHERE id = ?");
        $stmt->execute([$this->id]);
    }
}
