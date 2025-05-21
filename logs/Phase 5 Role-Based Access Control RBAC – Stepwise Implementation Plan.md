# ✅ Phase 5: Role-Based Access Control (RBAC) – Stepwise Implementation Plan

## ✅ Step 1: Database Schema Design and Migration
- ✅ Create modular RBAC tables:
  - `user_routes`
  - `user_permissions`
  - `user_designation_roles`
  - `user_roles` *(for future overrides)*
- ✅ Define foreign keys properly:
  - `designation_id` → `designations.id`
  - `route_id` → `user_routes.route_id`
  - `permission_id` → `user_permissions.permission_id`
  - `user_id` → `users.id`
- ✅ Run and test all migrations

---

## ✅ Step 2: Models
- ✅ Create model classes for:
  - `UserRoute`
  - `UserPermission`
  - `UserDesignationRole`
  - `UserRole` *(used for future optional overrides)*
- ✅ Follow consistent structure using static CRUD methods

---

## ⏳ Step 3: RBAC Controller
- ⏳ Create `RBACController` with:
  - `index()` – loads UI
  - `fetchDesignations()`
  - `fetchRoutes()`
  - `fetchPermissions()`
  - `getRoleMatrix($designationId)`
  - `updateRoles($designationId, $permissionsMap)`

---

## ⏳ Step 4: Admin Role Management UI
- ⏳ Add RBAC tab/page in admin dashboard
- ⏳ Dropdown to select a designation
- ⏳ Table/grid (routes × permissions) with checkboxes
- ⏳ Save/Update role matrix for selected designation

---

## ⏳ Step 5: Middleware / Gatekeeping
- ⏳ Implement centralized access checking
  - On every protected controller
  - Compare user designation against permission for the route + action
- ⏳ Return `403 Forbidden` or redirect with error

---

## ⏳ Step 6: Sidebar & Menu Enforcement
- ⏳ Dynamically render sidebar/menu
  - Fetch only allowed routes for user’s designation
  - Apply active/visible tabs based on current route

---

## ⏳ Step 7: Logs (Optional Enhancements)
- ⏳ Log all RBAC matrix updates
- ⏳ Log unauthorized access attempts for audit trail

---

## ✅ Step 8: Optional: User-Level Overrides
- ✅ `user_roles` table is in place (not used yet)
- ⏳ Future enhancement to override designation-level roles per user

---

# Phase 5: Role-Based Access Control (RBAC)

## 🗓️ Timeline
**Start Date:** 2025-05-15  
**End Date:** [Replace with actual date]

---

## 📌 Objective

Implement a flexible and scalable Role-Based Access Control (RBAC) system allowing administrators to:
- Manage user access by department and designation.
- Define and restrict access to modules and actions.
- Enforce both UI and backend-level visibility controls.

---

## 📁 Key Components

| Component              | Description |
|------------------------|-------------|
| `user_routes`          | Stores all defined routes (modules/pages) in the system. |
| `user_permissions`     | Lists available actions (e.g. Create, View, Edit, Delete). |
| `user_designation_roles` | Maps which designations can do which actions on which routes. |
| `module_groups`        | Categorizes routes into functional groups for cleaner UI display. |

---

## 🧩 Features Implemented

- 🔧 Super Admin UI to manage all routes (with group assignment).
- 🎛️ Interface to manage and activate available permission types.
- 📊 Matrix UI for assigning permissions per designation and module.
- 🧠 Auto-propagation of permissions after login via session.
- 🧼 `has_permission()` and `show_if_has_permission()` helper functions.
- 👁️ UI visibility control: Only authorized buttons/tabs appear to users.
- 🔐 Optional controller-level enforcement for stricter backend protection.

---

## 🔁 Helper Functions

### `has_permission($action, $routePath = null)`
Checks if current user has the given permission on the specified route.

### `show_if_has_permission($action, $routePath = null)`
Returns a boolean value or echo-friendly string (`'style="display:none;"'`) for hiding elements in HTML.

---

## ✅ Status Summary

| Task                          | Done |
|-------------------------------|------|
| Database Schema Setup         | ✅   |
| Admin UI for Routes & Permissions | ✅   |
| Assignment Matrix             | ✅   |
| Helper Functions              | ✅   |
| UI Enforcement (Sidebar, Buttons) | ✅   |
| Backend Enforcement (optional) | ⚠️ Optional |
| Audit Logging (bonus)         | ⚠️ Optional |

---

## 📝 Notes

- Phase 5 completed successfully with flexible RBAC support.
- Future enhancements may include permission logs and bulk assignment tools.

