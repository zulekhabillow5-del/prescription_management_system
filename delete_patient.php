<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

if (!isset($_GET['id'])) {
    header("Location: view_patients.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "DELETE FROM patients WHERE patient_id = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: view_patients.php?success=deleted");
    exit();
} else {
    echo "Error deleting patient: " . mysqli_error($conn);
}
?>