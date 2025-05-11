<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO|null
     */
    private static $instance = null;

    /**
     * Get PDO instance (singleton)
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // Load DB config and env
            $config = require __DIR__ . '/../../config/config.php';
            $dbConfig = $config['db'];

            $host = $dbConfig['host'];
            $db   = $dbConfig['name'];
            $user = $dbConfig['user'];
            $pass = $dbConfig['pass'];

            $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die('Database connection error: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
