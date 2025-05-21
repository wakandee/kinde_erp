<?php
// database/migrations/seed_rbac_defaults.php

require_once __DIR__ . '/../../config/database.php';
/** @var \PDO $pdo */

// 1) Seed permissions
echo "Seeding `user_permissions`...\n";
$permissions = ['View','Create','Edit','Delete','Assign','Approve','Reject'];
foreach ($permissions as $perm) {
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO user_permissions (name, created_at)
        VALUES (:name, NOW())
    ");
    $stmt->execute(['name' => $perm]);
}
echo "✔ user_permissions seeded.\n\n";

// 2) Seed routes
echo "Seeding `user_routes`...\n";
$routes = [
    // General
    'dashboard'                             => 'Dashboard',

    // Users
    'users'                         => 'User List',

    // Departments
    'departments'                   => 'Department List',

    // Designations
    'designations'                  => 'Designation List',

    // Profile & Settings
    'profile'                       => 'View Profile',

    // Themes
    'themes'                        => 'Themes Page',

    // Activities
    'activities'                    => 'Activity List',
    'activities_assign'             => 'Assign Others',
    'activities_comments'           => 'Task Comments',

    // RBAC Matrix
    'rbac_access_control'                          => 'RBAC Matrix',

    // RBAC: Module Groups CRUD
    'rbac_module_groups'     => 'Manage Module Groups',

    // RBAC: Routes CRUD
    'rbac_routes'            => 'Manage Routes',

    // RBAC: Permissions CRUD
    'rbac_permissions'       => 'Manage Permissions',
];


foreach ($routes as $path => $label) {
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO user_routes (name, path, created_at)
        VALUES (:name, :path, NOW())
    ");
    $stmt->execute([
        'name' => $label,
        'path' => $path
    ]);
}

echo "✔ user_routes seeded.\n\n";
echo "RBAC default seeding complete.\n";
