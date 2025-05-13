<?php
// database/migrations/create_departments_table.php

require_once __DIR__ . '/../../config/database.php';

$sql = "
CREATE TABLE IF NOT EXISTS departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "departments table created.\n";
