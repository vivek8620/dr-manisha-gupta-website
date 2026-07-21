# Dr. Manisha Gupta — Admin Panel Setup Guide

## 📁 Folder Structure
```
admin-panel/
├── index.php          ← Redirects to login
├── login.php          ← Admin login page
├── logout.php         ← Logout handler
├── dashboard.php      ← Main dashboard with charts
├── blogs.php          ← Blog management (Add/Edit/Delete)
├── messages.php       ← Contact messages viewer
├── settings.php       ← Practice settings + password change
├── database.sql       ← Database setup file
├── .htaccess          ← Security rules
├── includes/
│   ├── config.php     ← Admin DB connection + helper functions
│   ├── header.php     ← HTML head + CSS
│   ├── sidebar.php    ← Navigation sidebar
│   └── footer.php     ← Closing HTML tags
└── assets/
    └── images/
        └── manisha.png ← Doctor's profile picture
```

---

## 🗄️ Step 1: Set Up the Database

### Option A — phpMyAdmin (Easiest)
1. Open **http://localhost/phpmyadmin**
2. Click **"New"** in the left sidebar
3. Create database named `dr_manisha_gupta_db`
4. Click the database → go to **"Import"** tab
5. Upload `database.sql` and click **Go**

### Option B — MySQL Command Line
```bash
mysql -u root -p < database.sql
```

---

## ⚙️ Step 2: Configure Database Connection

Open `includes/config.php` and update these lines:

```php
define('DB_HOST', 'localhost');   // Usually 'localhost'
define('DB_USER', 'root');        // Your MySQL username
define('DB_PASS', '');            // Your MySQL password
define('DB_NAME', 'dr_manisha_gupta_db');
```

---

## 🚀 Step 3: Place Files on Server

### Local (XAMPP / WAMP / MAMP)
- Copy the entire `admin-panel` folder to:
  - XAMPP: `C:/xampp/htdocs/admin-panel/`
  - WAMP:  `C:/wamp64/www/admin-panel/`
- Open: **http://localhost/admin-panel/**

### Live Hosting (cPanel)
1. Log into cPanel → File Manager
2. Upload to `public_html/admin/` (or any subfolder)
3. Also upload `database.sql` and import it via cPanel → MySQL Databases → phpMyAdmin

---

## 🔐 Step 4: Login

Open the admin panel URL in your browser.

```
Email:    manisha123@gmail.com
Password: (the one corresponding to the bcrypt hash you provided)
```

> ⚠️ The password in database.sql uses the exact bcrypt hash you gave:
> `$2a$12$DXeGqAragGgVySP0X0REjeWneod/CKTb1obT1FnKDYybz2iOLg09W`
> This is already stored — just use the original plain-text password to log in.

---

## 📋 Features

| Page        | Features |
|-------------|----------|
| **Login**   | Secure bcrypt-verified login, session management |
| **Dashboard**| Live stats from DB, line chart (blogs), bar chart (messages), recent activity |
| **Blogs**   | Add / Edit / Delete blogs, category filter, status filter, full-page forms |
| **Messages**| View contact messages, mark read/replied, delete, filter by status |
| **Settings**| Save practice info to DB, operating hours, change admin password |
| **Logout**  | Session destroy + redirect |

---

## 🔧 Troubleshooting

**"Database Connection Failed"**
→ Check DB_HOST, DB_USER, DB_PASS, DB_NAME in `includes/config.php`

**Login not working**
→ Make sure you ran `database.sql` — the admin user must exist in the `admin_users` table

**Profile picture not showing**
→ Ensure `assets/images/manisha.png` is present in the admin-panel folder

**Blank page**
→ Enable PHP error reporting: add `ini_set('display_errors',1); error_reporting(E_ALL);` at the top of `index.php`

---

## 🌐 Live Hosting Link Setup

If your domain is `drmanishagupta.com` and you upload admin panel to a folder called `admin`:

```
Login page: https://drmanishagupta.com/admin/
Dashboard:  https://drmanishagupta.com/admin/dashboard.php
```

Make sure your hosting supports **PHP 7.4+** and **MySQL 5.7+**.

reset password 

UPDATE admins 
SET password = '$2a$12$kJjJCgbRWPc1Yu4Zg6VXd.fAe8uQpAiM3mNZ2dHtLPrltdMph06XO',
    failed_attempts = 0,
    locked_at = NULL
WHERE email = 'admin@drmanisha.com';