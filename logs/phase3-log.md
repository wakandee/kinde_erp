### Step 1: Initial Folder Restructure

- Created new folder structure for Models, Middleware, Routes, and Views subfolders.
- Moved `app/models/` to `app/Models/` following PSR naming conventions.
- Updated autoloader and `index.php` to reflect new model path.
- Ensured no breaking changes occurred.

kinde_erp/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── UserController.php
│   │   ├── DepartmentController.php
│   │   ├── DesignationController.php
│   │   ├── ProfileController.php
│   │   └── ThemeController.php
│   ├── Core/
│   │   ├── App.php
│   │   ├── Controller.php
│   │   ├── Middleware.php
│   │   ├── Router.php
│   │   ├── View.php
│   │   └── SessionHelper.php ✅ (NEW)
│   ├── Middleware/
│   │   ├── Auth.php
│   │   ├── PreventDuplicateLogin.php
│   │   └── InactivityLogout.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Department.php
│   │   ├── Designation.php
│   │   ├── UIPreference.php
│   │   └── PasswordReset.php
│   └── Views/
│       ├── auth/
│       │   ├── login.php
│       │   ├── forgot_password.php
│       │   └── reset_password.php
│       ├── users/
│       │   ├── index.php
│       │   └── form.php
│       ├── departments/
│       │   ├── index.php
│       │   └── form.php
│       ├── designations/
│       │   ├── index.php
│       │   └── form.php
│       ├── profile/
│       │   └── index.php
│       ├── themes/
│       │   └── index.php
│       ├── layouts/
│       │   └── main.php
│       ├── partials/
│       │   ├── header.php
│       │   ├── sidebar.php ✅ (NEW)
│       │   └── footer.php
│       └── home.php
├── config/
│   ├── config.php
│   └── database.php
├── database/
│   ├── migrations/ ✅ (NEW)
│   │   ├── create_users_table.php
│   │   ├── create_departments_table.php
│   │   ├── create_designations_table.php
│   │   ├── create_ui_preferences_table.php
│   │   └── create_password_resets_table.php
│   └── seeds/ ✅ (optional later)
├── logs/
│   ├── phase1-log.md 
│   ├── phase2-log.md 
│   └── phase3-log.md ✅ (NEW)
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── style.css
│   │   │   └── themes.css ✅ (NEW)
│   │   └── js/
│   │       └── main.js
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── web.php ✅ (NEW)
├── storage/
│   ├── cache/
│   └── logs/
├── tests/
├── vendor/
├── .env
├── .gitignore
├── .gitignore-tracker.txt
├── .gitignored_files.md
├── composer.json
├── env.php
└── README.md

### Step 2: Introduced Central Routing File

- Created `routes/web.php` to define all app routes.
- Updated `public/index.php` to require the new routing file.
- Ensured Router class is PSR-4 compliant via Composer autoloading.

USE erp_db;

INSERT INTO users (name, email, username, password, phone_number, designation_id, department_id)
VALUES (
  'Test User',
  'test@example.com',
  'testuser',
  '$2y$10$vkdn.L7B6JttChlhQTKD6.JQdCOau2DAjDaMdDqOSDFxlslAx/.Vu',
  '0123456789',
  NULL,
  NULL
);



7.4 Verify
Login

Visit /login, enter testuser / Password123.

Should redirect to /.

Access Protected Route

Go to /users (or any protected controller).

If logged in, you see the page; otherwise you’re redirected to /login.

Logout

Visit /logout.

Try accessing /users again — you must be sent back to /login.


feat(auth): Fix login issue using password_verify and session handling

- Implemented proper password hashing with password_verify
- Resolved login form error showing "Invalid credentials"
- Ensured only one session_start() call is active to prevent warnings
- Added fallback for missing HTTP_REFERER in theme switching (to be revisited)
- Verified controller route definitions and cleaned up switch action for theme

This completes Step 7: Secure user login with hashed password support.


Step 10: Implemented Flash Messaging System
- Added flash messaging system to display success and error messages
- Updated SessionHelper to manage flash messages
- Integrated flash messages in AuthController (login, logout, password reset)
- Updated layout views to display flash messages


Add flash messaging system for login, logout, and reset password - Implemented flash method in SessionHelper - Display success error messages in layout views - Updated AuthController to use flash messages for login, logout, and reset password actions
