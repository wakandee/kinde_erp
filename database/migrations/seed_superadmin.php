<?php
// database/migrations/seed_superadmin.php

require_once __DIR__ . '/../../config/database.php';
/** @var \PDO $pdo */

try {
    $pdo->beginTransaction();

    // 1) Ensure SuperAdmin designation exists
    $check = $pdo->prepare("SELECT COUNT(*) FROM designations WHERE id = :id");
    $check->execute(['id' => 1]);
    if ($check->fetchColumn() == 0) {
        throw new Exception("Designation #1 (SuperAdmin) not found. Seed designations first.");
    }

    // 2) Fetch all route IDs
    $routeIds = $pdo
        ->query("SELECT id FROM user_routes")
        ->fetchAll(PDO::FETCH_COLUMN);

    // 3) Fetch all permission IDs
    $permIds  = $pdo
        ->query("SELECT id FROM user_permissions")
        ->fetchAll(PDO::FETCH_COLUMN);

    // 4) Clear any existing roles for SuperAdmin
    $pdo
        ->prepare("DELETE FROM user_designation_roles WHERE designation_id = :did")
        ->execute(['did' => 1]);

    // 5) Assign all permissions on all routes to SuperAdmin
    $insert = $pdo->prepare("
        INSERT IGNORE INTO user_designation_roles
            (designation_id, route_id, permission_id, created_at)
        VALUES
            (:did, :rid, :pid, NOW())
    ");

    foreach ($routeIds as $rid) {
        foreach ($permIds as $pid) {
            $insert->execute([
                'did' => 1,
                'rid' => $rid,
                'pid' => $pid,
            ]);
        }
    }

    $pdo->commit();
    echo "✅ SuperAdmin (designation_id = 1) now has ALL permissions on ALL routes.\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ Seeding SuperAdmin failed: " . $e->getMessage() . "\n";
    exit(1);
}
