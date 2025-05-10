# Phase 1 Log - KIND-E ERP System

## Summary of Activities

This log documents all activities completed during **Phase 1** of the KIND-E ERP System. It includes all steps taken, tasks completed, and key decisions made throughout the process.

### 1. **Folder Structure Setup**
   - Clean folder structure established for controllers, models, views, and core logic.
   - **app/controllers**: For controller logic (e.g., `HomeController.php`).
   - **app/views**: For the view files (e.g., `home.php`).
   - **core**: For essential app functionality (e.g., routing).

### 2. **Routing System**
   - Developed a basic custom router (`Router.php`) for handling dynamic URL dispatching.
   - The router takes a URL, splits it into controller and method, and checks if the controller and method exist.
   - Implemented 404 error handling if the controller or method doesn't exist.

### 3. **Controller and View Integration**
   - Created `HomeController` with a method `index()` to load the home page.
   - Built a basic view `home.php` to display a simple welcome message.

### 4. **Environment Configuration**
   - Introduced `.env` file to manage environment-specific variables (e.g., database credentials, base URL).
   - Integrated `.env` configuration with `config.php` for centralized settings.

### 5. **PSR-4 Autoloading**
   - Set up PSR-4 autoloading to automatically load PHP classes.
   - This helps ensure all classes are properly loaded and reduces manual `require` statements.

### 6. **Error Handling**
   - Implemented error handling for 404 - Page Not Found when a controller or method cannot be found.
   - The router checks for the existence of the controller file and method and returns an appropriate error message.

### 7. **.htaccess Configuration**
   - Configured `.htaccess` for URL rewriting to route requests through `index.php` for clean URLs.

### 8. **Testing**
   - Verified that basic routing works and that the home page is displayed correctly when accessing the root URL.
   - Ensured the error handling system is triggered for invalid controllers or methods.

---

### Next Steps - **Phase 2: Authentication and Session Management**

Phase 2 will focus on implementing user authentication:
- **Create the `users` table** in the database to store user credentials.
- **Develop the `LoginController`** for handling login requests and validating user credentials.
- **Set up PHP session handling** to maintain the state of authenticated users across pages.
- **Design login views** to allow users to enter their credentials.

---

## How to Rollback (in case needed)

To roll back Phase 1:
1. Reset the repository to the last known good commit before Phase 1:
   ```bash
   git reset --hard <commit-hash>
