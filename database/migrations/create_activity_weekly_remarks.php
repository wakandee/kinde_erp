<?php

-- create_activity_weekly_remarks.php
CREATE TABLE IF NOT EXISTS weekly_remarks (
    remark_id INT AUTO_INCREMENT PRIMARY KEY,
    week_number INT NOT NULL,
    user_id INT NOT NULL,
    staff_remark TEXT,
    management_remark TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
