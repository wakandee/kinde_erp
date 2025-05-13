✅ Phase 4: Activity Tracker MVP – Implementation Checklist

| #      | Feature / Requirement                                                          | Status | Notes                                             |
| ------ | ------------------------------------------------------------------------------ | ------ | ------------------------------------------------- |
| **1**  | Dynamic task entry form (multiple rows per entry)                              | ⬜      | Tasks are grouped in form, saved independently    |
| **2**  | Fields captured per task: title, assignee, deliverable, resource               | ⬜      | Each task row contains these                      |
| **3**  | Auto-generated week via JS                                                     | ⬜      | Based on selected date                            |
| **4**  | Activity date must be today or one day prior                                   | ⬜      | Enforced via min attribute and backend validation |
| **5**  | Each row is saved as an independent activity in DB                             | ⬜      | One DB row per task                               |
| **6**  | Activities table structure finalized                                           | ⬜      | Includes `is_edited`, `status`, etc.              |
| **7**  | `status` field: `Not started`, `In progress`, `Done`, `Postponed`, `Cancelled` | ⬜      | Default is `Not started`                          |
| **8**  | Status change: Only allowed once per day, tracked                              | ⬜      | With `status_updated_by`, `status_updated_at`     |
| **9**  | Comments required for all statuses except `Done`                               | ⬜      | Frontend + backend enforced                       |
| **10** | No editing if: date is past OR status ≠ "Not started"                          | ⬜      | Backend & UI enforcement                          |
| **11** | On edit, original task is preserved                                            | ⬜      | Saved in `activity_logs`                          |
| **12** | `activity_logs` table for audit trail                                          | ⬜      | Stores full snapshot of previous version          |
| **13** | `is_edited` flag + `edited_at` field in `activities`                           | ⬜      | For visual and audit purposes                     |
| **14** | Edited activities visually marked in UI                                        | ⬜      | Badge, icon, or highlight                         |
| **15** | View history (past edits) per task                                             | ⬜      | Modal, collapsible table, or separate page        |
| **16** | Admin/HR dashboard: filter by user, department, week                           | ⬜      | Essential for oversight                           |
| **17** | No delete feature implemented                                                  | ✅      | Ensures traceability                              |
| **18** | Separate `activities` vs `activity_logs` logic respected                       | ⬜      | For integrity & performance                       |
| **19** | Final README (phase-specific)                                                  | ⬜      | At end of phase                                   |
| **20** | Phase signed off after checklist review                                        | ⬜      | Internal QA or stakeholder sign-off               |
