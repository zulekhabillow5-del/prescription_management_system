<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

if (!isset($_GET['id'])) {
    header("Location: prescription_history.php");
    exit();
}

$prescription_id = intval($_GET['id']);

// Check if prescription exists
$check = mysqli_query($conn, "SELECT * FROM prescriptions WHERE prescription_id='$prescription_id'");

if (mysqli_num_rows($check) == 0) {
    header("Location: prescription_history.php");
    exit();
}

// Delete prescription details first
mysqli_query($conn, "
DELETE FROM prescription_details
WHERE prescription_id='$prescription_id'
");

// Delete prescription
mysqli_query($conn, "
DELETE FROM prescriptions
WHERE prescription_id='$prescription_id'
");

header("Location: prescription_history.php?success=deleted");
exit();
?>