# KIND-E ERP System

Welcome to the KIND-E ERP System — a modular, clean, and expandable ERP framework built in native PHP using the MVC (Model-View-Controller) architecture.

---

## ✅ Features Implemented

### Phase 1 – Core Setup

- Clean folder structure (`controllers`, `views`, `models`)
- Basic routing system for dynamic URL dispatching
- `.env` file support for configuration
- Sample home page with routing, controller, and view
- Modular configuration system (`config.php`)
- Manual PSR-like class autoloading structure
- 404 error handling
- HomeController and basic display setup

### Phase 2 – MVC Base & Autoloading Enhancement

- Created base `Controller`, `View`, and improved `Router` classes
- Implemented layout rendering via `View::render()`
- Views now support template inheritance: layouts & partials (`main`, `header`, `footer`)
- Added support for CSS and JS asset loading
- Light/dark theme toggle placeholder using JavaScript
- Composer initialized with PSR-4 autoloading
- All classes updated to use PSR-4 namespaces

---

## 📁 Folder Structure

kinde_erp
├── app/
│ ├── controllers/ # e.g., HomeController.php
│ ├── core/ # Base MVC logic: Controller.php, Router.php, View.php
│ └── views/
│ ├── home.php
│ ├── layouts/ # e.g., main.php
│ └── partials/ # e.g., header.php, footer.php
├── config/ # config.php and environment settings
├── public/ # Public entry point and assets
│ └── assets/
│ └── css/style.css
├── logs/ # Phase logs
│ ├── phase1-log.md
│ └── phase2-log.md
├── resources/ # Frontend resources (images, etc.)
├── storage/ # Reserved for logs/cache
├── tests/ # Unit/integration tests
├── .env # Environment variables
├── .gitignore
├── composer.json # Composer config (autoloading via PSR-4)
└── index.php # Public entry point


---

## 📑 Phase Logs

- [Phase 1 Log](logs/phase1-log.md)
- [Phase 2 Log](logs/phase2-log.md)

---

## ⚙️ How to Run

1. Clone the repository:

```bash
git clone <repo-url>
cd <repo-directory>
```
2. Set up your .env file with database config, base URL, etc.

3. Ensure .htaccess exists in the public/ directory:

RewriteEngine On
RewriteRule ^ index.php [QSA,L]

4. Install Composer dependencies:

```
composer install
```

5. Navigate to the public folder:
```
cd public/
```

6. Run on browser:

http://localhost/<repo-directory>


### 🔐 Authentication (Upcoming in Phase 3)
- User login and logout
- Session management
- Protected routes (middleware)
- Basic user table and model



### ✅ Updated `logs/phase2-log.md`

# 🚀 Phase 2 Log - MVC Base System

## 📆 Started: 2025-05-10  
## 🔁 Status: In Progress  
## 🔍 Phase Lead: Allan Kipruto  

---

### ✅ Objectives

- Implement base MVC structure
- Create `View::render()` with layout support
- Setup layout and partials (`header`, `footer`)
- Improve 404 error handling
- Enable CSS/JS asset support
- Add light/dark mode toggle placeholder
- Integrate Composer with PSR-4 autoloading

---

### 📂 File & Folder Updates

app/
├── controllers/
│   └── HomeController.php ← Uses PSR-4 namespace
├── core/
│   ├── Controller.php ← Shared controller logic
│   ├── Router.php ← Enhanced routing with 404 fallback
│   └── View.php ← Layout + template rendering logic
views/
├── home.php ← Rendered via main layout
├── layouts/
│   └── main.php ← Master layout file
├── partials/
│   ├── header.php ← Header (with dark/light toggle)
│   └── footer.php ← Footer section
public/
├── assets/
│   └── css/
│       └── style.css ← Contains minimal light/dark styles
logs/
├── phase1-log.md
└── phase2-log.md

---

### 🗂 Task Log (Chronological)

| Date       | Task                                               | Status     |
|------------|----------------------------------------------------|------------|
| 2025-05-10 | Created `phase-2-mvc-base` branch                  | ✅ Done     |
| 2025-05-10 | Updated README with Phase 2 objectives             | ✅ Done     |
| 2025-05-10 | Created `logs/phase2-log.md`                       | ✅ Done     |
| 2025-05-10 | Started building `View` base class                 | ✅ Done     |
| 2025-05-10 | Implemented `Controller.php`                       | ✅ Done     |
| 2025-05-10 | Updated `Router.php` with fallback to 404 view     | ✅ Done     |
| 2025-05-10 | Built layout structure: `layouts/`, `partials/`    | ✅ Done     |
| 2025-05-10 | Added light/dark mode placeholder in header        | ✅ Done     |
| 2025-05-10 | Initialized Composer and PSR-4 config              | ✅ Done     |
| 2025-05-10 | Ran `composer dump-autoload`                       | ✅ Done     |
| 2025-05-10 | Refactored classes to use namespaces               | ✅ Done     |

---

## 🛠 How to Run

1. Start XAMPP or your local Apache server.
2. Navigate to `http://localhost/kinde_erp/public/`.
3. The home page should render through the main layout.
4. Use the toggle button in the header to test dark/light placeholder.

---

## 📦 Composer Integration (PSR-4)

- Composer initialized via `composer init`
- Autoloading setup:

```json
"autoload": {
    "psr-4": {
        "Kinde\\KindeErp\\": "app/"
    }
}
```

- Required command run:
```
composer dump-autoload
```
## 📌 Next Phase

Prepare for user login system (Phase 3):

AuthController

Login form and validation

Session-based middleware

User table and model

## ✅ Routing & Controller Setup Finalization

- Routing is now handled by `App\Core\Router` loaded in `public/index.php`
- All controllers follow PSR-4 autoloading and are namespaced under `Kinde\KindeErp\Controllers`
- Views are rendered via `App\Core\Controller::view()` and pass a `$base_url` to layout
- Assets (CSS/JS) are correctly loaded from `/public/assets/` via `config.php` base URL
