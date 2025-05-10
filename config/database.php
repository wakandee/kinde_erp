<?php
$host = env('DB_HOST', 'localhost');
$db   = env('DB_NAME', 'erp_db');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
