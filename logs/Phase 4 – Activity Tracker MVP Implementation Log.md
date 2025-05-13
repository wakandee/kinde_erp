---------------------------------------------------------------------------------------
# Phase 4 Log – Activity Tracker
---------------------------------------------------------------------------------------

Date: [2025-05-13]
Contributor: Allan Kipruto

✅ Activities migration complete:
  - activities
  - activity_tasks
  - activity_task_edits
  - activity_weekly_remarks

Notes:
- All tables created successfully via `php activity_migration.php`
- Prepared for Activity model/controller implementation
- Audit table (task_edits) will help maintain original versions of tasks
- Weekly remarks support multiple roles per week (staff, HR, supervisors, etc.)

Next:
- Implement models
- Track edits per task with visual indicator
- Limit task editing based on date and status rules
- Link remarks to week + user + role (staff vs mgmt)




[✓] [2025-05-13 14:00] Phase 4 - Core backend setup complete:
     - Added Activity and ActivityTask models.
     - Created ActivityController with create/store logic.
     - Integrated user session for dynamic assignment.
     - Confirmed multi-task entry plan per activity.
     - Ready for frontend form updates.


[✓] [2025-05-13 14:10] Phase 4 - Activity tracker routes added to web.php:
     - /activity/create [GET]
     - /activity        [POST]

[Phase 4 - Activity Tracker]
Date: 2025-05-13

- Implemented dynamic activity creation form (activity date, week number auto-calc, title)
- Added support for multiple task entries (task, assignee, deliverable, resource)
- Task inputs dynamically repeat and index properly
- Linked controller to pass user data and render form
- Prepped for storing each task as individual rows in 'activity_tasks' table
