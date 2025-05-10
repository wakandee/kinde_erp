# KIND-E ERP

KIND-E ERP is a modular, scalable ERP system built with native PHP (no frameworks) following MVC architecture.

## ✅ Features Implemented (Phase 1)

- Clean folder structure (controllers, views, models)
- Basic routing system
- .env file integration
- Sample home page
- Modular configuration system
- PSR-4 autoloading via Composer

## 📁 Folder Structure (So Far)

kinde_erp/
│
├── app/
│ ├── controllers/
│ │ └── HomeController.php
│ └── views/
│ └── home.php
│
├── config/
│ ├── config.php
│ └── database.php
│
├── core/
│ └── Router.php
│
├── public/
│ ├── index.php
│ └── .htaccess
│
├── .env
├── env.php
├── .gitignore
└── README.md


## 🔧 How to Run Locally

1. Clone the repository
2. Place inside your server root (e.g. `htdocs` for XAMPP)
3. Visit: `http://localhost/kinde_erp/public/`

---

## 🧭 Next Phase

- User login and authentication system (session-based)

