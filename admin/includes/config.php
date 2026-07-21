<?php
// ============================================
// Admin Panel Database Configuration
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'drmanishagupta2a_admin');
define('DB_PASS', '[jR}&JB7?x&u*yW&');
define('DB_NAME', 'drmanishagupta2a_website');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to admin database
function getDB()
{
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die('<div style="font-family:sans-serif;padding:40px;color:#e53e3e;background:#fff5f5;border:1px solid #feb2b2;margin:20px;border-radius:8px;">
                <h2> Database Connection Failed</h2>
                <p>Error: ' . $conn->connect_error . '</p>
                <p>Please check your database settings in <code>includes/config.php</code></p>
            </div>');
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}

// Auth check — redirect to login if not logged in
function requireLogin()
{
    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit();
    }
}

// Get logged-in admin info
function getAdminInfo()
{
    if (!isset($_SESSION['admin_id'])) return null;
    $db = getDB();
    $id = (int)$_SESSION['admin_id'];
    // Backend API mein table 'admins' hai, 'admin_users' nahi
    $res = $db->query("SELECT * FROM admins WHERE id = $id LIMIT 1");
    return $res ? $res->fetch_assoc() : null;
}

// Fetch a setting value
function getSetting($key, $default = '')
{
    $db = getDB();
    $key = $db->real_escape_string($key);
    $res = $db->query("SELECT setting_value FROM settings WHERE setting_key = '$key' LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) {
        return $row['setting_value'];
    }
    return $default;
}

// Color scheme
$colors = [
    'primary'      => '#0EADAE',
    'primary-dark' => '#006a6a',
    'secondary'    => '#042A3F',
    'background'   => '#f8f9fa',
    'surface'      => '#FFFFFF',
    'success'      => '#10B981',
    'warning'      => '#F59E0B',
    'error'        => '#EF4444',
    'outline'      => '#6c7a79',
];
