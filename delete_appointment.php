<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

if (!isset($_GET['id'])) {
    header("Location: view_appointments.php");
    exit();
}

$appointment_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT appointment_id
FROM appointments
WHERE appointment_id='$appointment_id'
");

if(mysqli_num_rows($result)==0){
    header("Location: view_appointments.php");
    exit();
}

mysqli_query($conn,"
DELETE FROM appointments
WHERE appointment_id='$appointment_id'
");

header("Location:view_appointments.php?success=deleted");
exit();
?>