<?php
// ======================================
// Prescription Management System
// Database Connection
// ======================================

// Database Configuration (read from environment variables)
$host = getenv("DB_HOST");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$charset = getenv("DB_CHARSET") ?: "utf8mb4";
$port = getenv("DB_PORT") ?: 3306;

// Validate required settings
if (empty($host) || empty($username) || empty($password) || empty($database)) {
    die("Database configuration missing. Please set DB_HOST, DB_USERNAME, DB_PASSWORD and DB_NAME environment variables in your Render service.");
}

// Use exceptions for mysqli errors to provide clearer diagnostics
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create Connection (use TCP port)
try {
    $conn = mysqli_connect($host, $username, $password, $database, (int)$port);
} catch (mysqli_sql_exception $e) {
    $msg = "Database Connection Failed: " . $e->getMessage();
    if ($host === 'localhost') {
        $msg .= " — note: using 'localhost' attempts a Unix socket connection. On Render set DB_HOST to your database's TCP host (IP or hostname) and set DB_PORT if needed.";
    }
    die($msg);
}

// Set Character Encoding
mysqli_set_charset($conn, $charset);
?>