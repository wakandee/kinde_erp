<?php
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
?>