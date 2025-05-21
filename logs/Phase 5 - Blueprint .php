Phase 5📄 README: Phase 5 — Role-Based Access Control (RBAC)
🧩 Overview
Phase 5 introduces a dynamic, scalable Role-Based Access Control (RBAC) system to govern what users can see and do within the ERP platform. This is the foundation for permission-aware routing, dynamic UI rendering, and secure controller access enforcement.

🎯 Objectives
Ensure only authorized users can access or perform operations.

Decouple permission logic from business logic for maintainability.

Allow HR/Admin to configure access per role (designation) via UI.

🏗️ Data Model
modules: Defines top-level system features (e.g., "Projects", "Users")

permissions: Defines specific actions under modules (e.g., View, Add)

designations: Organizational roles per department

role_permissions: Links designations to specific permissions

users: Linked to a designation, and inherits its permissions

📌 Features Implemented
Admin interface to create/edit system modules and define available actions.

HR/Admin panel to define Designations and associate them with permissions.

UI-based checkbox matrix for assigning permissions per designation.

Middleware to restrict unauthorized access at route/controller level.

Dynamic sidebar rendering: users only see tabs they have permission to view.

Database-seeded permission tables for extensibility and auditing.

🔐 Example: Permission Enforcement
User A (Designation: "COO") with permission:

projects: view, projects: edit

Result:

Sidebar shows “Projects”

Can open /projects

Can click “Edit” button

Cannot see “Delete” option


💡 Recommended Best Practices & Enhancements
Granular Action Types

Go beyond CRUD if needed: e.g., Approve, Export, Download, Assign

Group Permissions by Functional Domain

Use categories: "Finance", "Operations", "Admin"

Soft Deletion of Modules/Permissions

Allow deactivation without deleting (for audit traceability)

Permission Templates

Create reusable templates for common roles to simplify role assignment

Live Preview During Role Assignment

Show which tabs/actions a user would see based on current selection

Permission Inheritance (Advanced/Future)

Allow designation hierarchy (e.g., Manager inherits from Officer)

Access Logs & Alerts

Notify superadmin of permission escalations or sensitive access attempts

Internationalization/Localization Support

Label actions and modules for multi-language environments

Real-time Permission Cache

Cache permission checks for faster response time

🧪 Testing Recommendations
Create test accounts for various designations

Try accessing forbidden routes directly via URL

Test dynamic sidebar rendering per role

Log permission changes and test audit trail visibility

🧰 Sample Helper Function for Middleware
php
Copy
Edit
function can_access($module, $action) {
    $permissions = $_SESSION['user_permissions'] ?? [];
    return in_array("$module:$action", $permissions);
}
✅ Phase Milestone Sign-Off
 Functional permission assignment working

 Controller-level enforcement tested

 UI fully respects access roles

 README and developer guide updated

 QA validation + sign-off




✅ Phase 5 Completed So Far
✅ Database tables for designations, user_routes, user_permissions, user_roles, module_groups

✅ Super Admin UI to manage user_routes and group them under module_groups

✅ Admin matrix UI for assigning permissions (route × permission) to designations

✅ Controller logic for fetching and saving role matrices

✅ Frontend matrix logic with dynamic checkbox rendering, submission, and feedback

🔜 Pending Tasks for Phase 5
1. 🔐 Permission Enforcement Middleware
Implement middleware to check user access based on:

Their designation

The route being accessed

The required permission (e.g., View, Edit)

Scope:

Block access if user lacks the required permission

Redirect or show an access denied page

2. 📍 Route Permission Annotation (Mapping Controllers to Permissions)
Define required permissions for protected routes:

Example:

/projects/create requires Create on Projects

/projects/edit requires Edit on Projects

Options:

Add a mapping config (route → permission_id)

Use controller-based helper methods like authorize($permission, $route)

3. 👀 Frontend Enforcement (UI-level)
Hide or disable buttons, links, and tabs that the user is not permitted to use:

Disable "Create" or "Edit" buttons if user doesn’t have permission

Remove entire modules from sidebar if the user has no access

Where:

Sidebar (handled via model-check)

Action buttons in tables

Tabs/forms within pages

4. 🧪 Permission Check Helper
Create a global helper function or static method, e.g.:

php
Copy
Edit
Rbac::hasPermission($userId, $routePath, $permissionId)
or

php
Copy
Edit
User::hasPermission('projects', 'edit')
To use across controllers and views.

5. 🔄 Caching of Role Matrix (Performance)
To prevent repeated DB queries on every request:

Cache permissions in session or Redis on login

Reload cache only on role update or user login

6. 👤 User Interface for Managing Designation-based Roles
Optional enhancement:

Clone roles from another designation

Export/import role templates for reuse

7. 📄 Activity Logs for Role Assignments
Log changes in role assignments:

Who assigned what to whom

What was changed

8. 🧪 Testing
Manual tests: Try every module/tab with different roles

Edge cases: Check for route access with invalid or missing permissions

📌 Summary View
Feature Status
Role matrix UI & backend    ✅ Done
User route & permission DB structure    ✅ Done
Role mapping save/load  ✅ Done
Middleware for access control   🔜 Pending
Controller-level permission checks  🔜 Pending
UI visibility control   🔜 Pending
Permission helper functions 🔜 Pending
Caching permissions 🔜 Optional
Role cloning / templates    🕒 Optional
Logging of RBAC changes 🕒 Optional

