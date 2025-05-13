<?php
// database/migrations/create_designations_table.php

require_once __DIR__ . '/../../config/database.php';

$sql = "
CREATE TABLE IF NOT EXISTS designations (
    designation_id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    name VARCHAR(100) NOT NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "designations table created.\n";
