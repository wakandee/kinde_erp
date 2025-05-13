<?php
CREATE TABLE IF NOT EXISTS activity_task_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    activity_id INT NOT NULL,
    edited_by INT NOT NULL,
    edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    old_task_title VARCHAR(255),
    old_assignee_id INT,
    old_deliverable TEXT,
    old_resource TEXT,
    old_status ENUM('Not Started', 'In Progress', 'Done', 'Postponed', 'Cancelled'),
    old_comments TEXT,
    FOREIGN KEY (task_id) REFERENCES activity_tasks(task_id),
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id),
    FOREIGN KEY (edited_by) REFERENCES users(id)
) ENGINE=InnoDB;
