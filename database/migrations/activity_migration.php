<?php
// database/migrations/create_activities_table.php
require_once __DIR__ . '/../../config/database.php';

$sql = "
CREATE TABLE IF NOT EXISTS activities (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_date DATE NOT NULL,
    week_number INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "activities table created.\n";

$sql = "
CREATE TABLE IF NOT EXISTS activity_tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    activity_id INT NOT NULL,
    task VARCHAR(255) NOT NULL,
    assignee_id INT NOT NULL,
    deliverable TEXT,
    resource TEXT,
    status ENUM('Not Started', 'In Progress', 'Done', 'Postponed', 'Cancelled') DEFAULT 'Not Started',
    updated BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id),
    FOREIGN KEY (assignee_id) REFERENCES users(id)
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "activity_tasks table created.\n";

$sql = "
CREATE TABLE IF NOT EXISTS activity_task_edits (
    edit_id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    edited_by INT NOT NULL,
    edit_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    old_task TEXT,
    old_assignee_id INT,
    old_deliverable TEXT,
    old_resource TEXT,
    old_status VARCHAR(50),
    old_comment TEXT,
    FOREIGN KEY (task_id) REFERENCES activity_tasks(task_id),
    FOREIGN KEY (edited_by) REFERENCES users(id)
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "activity_task_edits table created.\n";

$sql = "
CREATE TABLE IF NOT EXISTS activity_weekly_remarks (
    remark_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    week_number INT NOT NULL,
    role VARCHAR(100) NOT NULL,
    target_audience ENUM('staff', 'management') NOT NULL,
    remark TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
";
$pdo->exec($sql);
echo "activity_weekly_remarks table created.\n";

$sql = "
CREATE TABLE `activity_task_updates` (
  `update_id` INT AUTO_INCREMENT PRIMARY KEY,
  `task_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `status` ENUM('Not Started','In Progress','Done','Postponed','Cancelled') NOT NULL,
  `comment` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`task_id`) REFERENCES `activity_tasks`(`task_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);
";
$pdo->exec($sql);
echo "activity_task_updates table created.\n";
