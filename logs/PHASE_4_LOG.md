# 📓 Phase 4 – Activity Tracker MVP: Implementation Log

## General Info
**Start Date:** [To be filled]  
**Lead Developer:** [Your Name]  
**Branch:** `phase-4-activity-tracker`  
**Repo:** [Link if available]

---

## Log Entries

### [YYYY-MM-DD] - Setup
- ✅ Created `phase-4-activity-tracker` branch
- ✅ Drafted checklist and log
- 🛠️ Began modeling `activities` and `activity_logs` tables

### [YYYY-MM-DD] - Task Entry Form
- Created multi-row task input form
- JS function implemented for auto-week generation

### [YYYY-MM-DD] - DB Schema
- `activities` and `activity_logs` migrations created
- Tested sample inserts for task rows

### [YYYY-MM-DD] - Edit Restrictions
- Enforced no edit after activity date or if status is changed
- Added UI warnings and backend validation

### [YYYY-MM-DD] - Audit Trail
- On edit: current state saved in `activity_logs`
- `is_edited` set to true, `edited_at` updated

### [YYYY-MM-DD] - Status Update Flow
- Status dropdown + comments (required except "Done")
- Update captured in activities table + validated

### [YYYY-MM-DD] - Admin View
- Filters by week, user, department
- "Edited" tag displayed beside modified entries
- "View history" modal per task

### [YYYY-MM-DD] - Final Review
- ✅ Reviewed all checklist items
- ✅ Final QA passed
- 📄 README written and committed
- ✅ Merged to `main` after sign-off

---

## Notes
- Comments are only allowed on specific statuses
- No deletes allowed, edits tracked completely
- Consider full audit logging via Laravel events in future





---------------------------------------------------------------
## [2025-05-14] - Task Update System Refactor

### Added
- `activity_task_updates` table for tracking task status changes and comments.
- UI support for viewing task comment history.
- Dynamic comment box toggle based on status (e.g., hides for "Done").

### Changed
- Moved all database interactions from controllers to model layer (`ActivityTask`).
- Enforced one-time edit policy after status update or mark as edited.
- Required comment on status change (except for "Done").

### Fixed
- Missing `status_comment` column reference removed.
- Unregistered `Database` class usage in controllers replaced with model logic.
- Status options visibility issue in dropdown corrected by explicitly passing options to the view.

### Notes
- System now maintains a full audit trail of all task updates.
- Inline comment field removed from `activity_tasks`, migrated to `activity_task_updates`.
