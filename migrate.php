<?php
$migrations = [
    'database/migrations/create_departments_table.php',
    'database/migrations/create_designations_table.php',
    'database/migrations/create_users_table.php',
    'database/migrations/create_ui_preferences_table.php',
    'database/migrations/create_password_resets_table.php',
];

foreach ($migrations as $file) {
    echo "Running {$file}...\n";
    require __DIR__ . '/' . $file;
}
echo "All migrations finished.\n";
