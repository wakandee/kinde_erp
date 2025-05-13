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
