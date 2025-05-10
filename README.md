# KIND-E ERP System

Welcome to the KIND-E ERP System. This is a basic ERP framework for managing business processes, built with PHP, following an MVC (Model-View-Controller) architecture. The system is modular, clean, and easy to expand.

## ✅ Features Implemented (Phase 1)

- Clean folder structure (controllers, views, models)
- Basic routing system to handle dynamic URL dispatching
- `.env` file integration for environment-specific configurations
- Sample home page with basic controller and view setup
- Modular configuration system (`config.php`) for easy maintenance
- PSR-4 autoloading to autoload classes and ensure proper class loading
- Error handling for 404 (controller or method not found)
- Basic home page display with a welcoming message

## 📁 Folder Structure (So Far)

Here’s the folder structure as it currently stands:

kinde_erp
├── app
│ ├── controllers # Controller files (e.g., HomeController.php)
│ ├── models # Model files (for DB interactions, to be added later)
│ └── views # View files (e.g., home.php)
├── config # Configuration files (e.g., config.php)
├── core # Core logic files (e.g., Router.php)
├── public # Public assets and index.php (entry point)
├── resources # Frontend resources (e.g., styles, images)
├── storage # Cache and log files (reserved for later)
├── tests # Tests folder (for later use)
├── .env # Environment variables file
├── .gitignore # Git ignore file
└── composer.json # Composer dependencies and autoloading configuration (not installed yet)


## 📑 Phase 1 Log

For a detailed log of the tasks completed in **Phase 1**, please refer to the [**Phase 1 Log**](phase1-log.md). This log includes a complete breakdown of activities, commits, and steps taken during this phase.

## ⚙️ How to Run Phase 1

1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd <repo-directory> 
   ```

2. Set up environment variables in .env (database credentials, base URL, etc.).

3. Ensure that .htaccess is configured correctly for URL routing:
RewriteEngine On
RewriteRule ^ index.php [QSA,L]

4. Run the application by navigating to the public/ folder:
	cd public/
5. Access the application in your browser at http://localhost/<repo-directory>.

## 🔜 Phase 2: Authentication (Login and Session Management)

 In Phase 2, we will implement the authentication system, allowing users to log in, manage sessions, and access protected pages.

#### Key features for Phase 2:

User model and database table creation for authentication.

LoginController for handling user authentication.

Session management using PHP sessions.

Frontend views for the login form.

Implement logout functionality.