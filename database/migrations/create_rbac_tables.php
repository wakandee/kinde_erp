<?php
require_once __DIR__ . '/../../config/database.php';

try {
    // 1) RBAC lookup tables

    // ─── user_permissions ─────────────────────────────────────────────────────
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // ─── user_route_groups ────────────────────────────────────────────────────
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_route_groups (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // ─── user_routes ─────────────────────────────────────────────────────────
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_routes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            path VARCHAR(255) NOT NULL UNIQUE,
            group_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (group_id)
                REFERENCES user_route_groups(id)
                ON DELETE RESTRICT
                ON UPDATE CASCADE
        ) ENGINE=InnoDB;
    ");

    // ─── user_designation_roles ───────────────────────────────────────────────
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_designation_roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            designation_id INT NOT NULL,
            route_id INT NOT NULL,
            permission_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (designation_id) REFERENCES designations(id) ON DELETE CASCADE,
            FOREIGN KEY (route_id)       REFERENCES user_routes(id) ON DELETE CASCADE,
            FOREIGN KEY (permission_id)  REFERENCES user_permissions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    // ─── user_roles (per-user overrides; for future use) ─────────────────────
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            route_id INT NOT NULL,
            permission_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id)       REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (route_id)      REFERENCES user_routes(id) ON DELETE CASCADE,
            FOREIGN KEY (permission_id) REFERENCES user_permissions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    echo "✅ RBAC tables created (permissions, groups, routes, designation_roles, roles).\n";
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
