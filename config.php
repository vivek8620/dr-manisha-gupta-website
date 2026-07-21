<?php
// Website Database Configuration

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dr_manisha_gupta_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Database Connection Failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
$db = $conn;

if (!function_exists('getSettingValue')) {
    function getSettingValue($conn, $key, $default = '')
    {
        $stmt = $conn->prepare("
            SELECT setting_value
            FROM settings
            WHERE setting_key = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $key);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['setting_value'];
        }

        return $default;
    }
}
