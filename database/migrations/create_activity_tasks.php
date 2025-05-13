<?php

CREATE TABLE IF NOT EXISTS activity_tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    activity_id INT NOT NULL,
    task_title VARCHAR(255) NOT NULL,
    assignee_id INT NOT NULL,
    deliverable TEXT,
    resource TEXT,
    status ENUM('Not Started', 'In Progress', 'Done', 'Postponed', 'Cancelled') DEFAULT 'Not Started',
    comments TEXT,
    is_edited BOOLEAN DEFAULT FALSE,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id),
    FOREIGN KEY (assignee_id) REFERENCES users(id)
) ENGINE=InnoDB;
 ?>