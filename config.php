<?php
// ======================================
// Prescription Management System
// Database Connection
// ======================================

// Database Configuration
$host = getenv("DB_HOST") ?: "localhost";
$username = getenv("DB_USERNAME") ?: "Zubby";
$password = getenv("DB_PASSWORD") ?: "Zubby2026!";
$database = getenv("DB_NAME") ?: "xefrbpcu_prescription_management_system";
$charset = getenv("DB_CHARSET") ?: "utf8mb4";

// Create Connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check Connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set Character Encoding
mysqli_set_charset($conn, "utf8");
?>