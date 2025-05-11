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
