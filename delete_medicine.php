<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

if (!isset($_GET['id'])) {
    header("Location: view_medicines.php");
    exit();
}

$medicine_id = intval($_GET['id']);

// Check if medicine exists
$result = mysqli_query($conn, "
SELECT *
FROM medicines
WHERE medicine_id='$medicine_id'
");

if (mysqli_num_rows($result) == 0) {
    header("Location: view_medicines.php");
    exit();
}

// Delete medicine
mysqli_query($conn, "
DELETE FROM medicines
WHERE medicine_id='$medicine_id'
");

header("Location: view_medicines.php?success=deleted");
exit();
?>