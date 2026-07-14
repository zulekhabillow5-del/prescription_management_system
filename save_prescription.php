c<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$patient_id = $_POST['patient_id'];
$doctor_id = $_SESSION['doctor_id'];
$diagnosis = mysqli_real_escape_string($conn,$_POST['diagnosis']);
$notes = mysqli_real_escape_string($conn,$_POST['notes']);
$date = $_POST['prescription_date'];

$sql = "INSERT INTO prescriptions
(patient_id,doctor_id,diagnosis,notes,prescription_date)
VALUES
('$patient_id','$doctor_id','$diagnosis','$notes','$date')";

mysqli_query($conn,$sql);

$prescription_id = mysqli_insert_id($conn);

$count = count($_POST['medicine_id']);

for($i=0;$i<$count;$i++){

$medicine = $_POST['medicine_id'][$i];
$dosage = mysqli_real_escape_string($conn,$_POST['dosage'][$i]);
$frequency = mysqli_real_escape_string($conn,$_POST['frequency'][$i]);
$duration = mysqli_real_escape_string($conn,$_POST['duration'][$i]);
$instructions = mysqli_real_escape_string($conn,$_POST['instructions'][$i]);

mysqli_query($conn,"
INSERT INTO prescription_details
(prescription_id,medicine_id,dosage,frequency,duration,instructions)
VALUES
('$prescription_id','$medicine','$dosage','$frequency','$duration','$instructions')
");

}

header("Location: prescription_history.php?success=added");
exit();