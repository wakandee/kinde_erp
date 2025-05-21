kinde_erp/
│
├── public/                           # Web-accessible directory
│   ├── index.php                     # Entry point
│   ├── assets/
│   │   ├── css/
│   │   │   ├── main.css              # Global styles
│   │   │   ├── dark-theme.css        # Dark mode styles
│   │   │   └── light-theme.css       # Light mode styles
│   │   ├── js/
│   │   │   ├── main.js               # Main JS
│   │   │   └── theme-toggle.js       # Dark/light theme toggle
│   │   └── icons/
│   └── uploads/                      # (Optional) uploaded documents
│
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ActivityController.php
│   │   ├── ProjectController.php
│   │   ├── AdminController.php
│   │   └── UiPreferenceController.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Activity.php
│   │   ├── ActivityTask.php
│   │   ├── ActivityTaskUpdate.php
│   │   ├── ActivityTaskEdit.php
│   │   ├── Project.php
│   │   └── Site.php
│   │
│   ├── Helpers/
│   │   ├── AuthHelper.php
│   │   ├── UrlHelper.php
│   │   └── ThemeHelper.php
│   │
│   ├── Middleware/
│   │   └── AuthMiddleware.php
│   │
│   └── Views/
│       ├── layout/
│       │   ├── header.php
│       │   ├── footer.php
│       │   └── sidebar.php
│       │
│       ├── dashboard/
│       │   ├── index.php
│       │   └── analytics.php
│       │
│       ├── activities/
│       │   ├── create.php
│       │   ├── view.php
│       │   ├── edit.php
│       │   └── logs.php
│       │
│       ├── projects/
│       │   ├── index.php
│       │   └── manage.php
│       │
│       ├── users/
│       │   ├── login.php
│       │   ├── register.php
│       │   └── manage.php
│       │
│       └── ui-preference/
│           └── theme.php            # POST handler for theme switching
│
├── routes/
│   └── web.php                       # All route definitions
│
├── config/
│   ├── database.php
│   └── app.php                       # APP_CONFIG: baseUrl, appName, theme
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.sql
│   │   ├── create_activities_table.sql
│   │   ├── create_activity_tasks_table.sql
│   │   ├── create_activity_task_updates_table.sql
│   │   ├── create_activity_task_edits_table.sql
│   │   └── create_projects_and_sites_tables.sql
│   └── seeders/                     # Optional seed scripts
│
├── storage/
│   ├── logs/
│   │   └── app.log
│   └── cache/
│
├── .env                              # Environment config (DB creds, etc.)
├── .htaccess                         # Rewrite rules (Apache)
├── composer.json
└── README.md
