<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Appointment Details";

if (!isset($_GET['id'])) {
    header("Location: view_appointments.php");
    exit();
}

$appointment_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT
a.*,
p.full_name AS patient_name,
d.full_name AS doctor_name
FROM appointments a
INNER JOIN patients p
ON a.patient_id = p.patient_id
INNER JOIN doctors d
ON a.doctor_id = d.doctor_id
WHERE a.appointment_id='$appointment_id'
");

if(mysqli_num_rows($result)==0){
    die("Appointment not found.");
}

$appointment = mysqli_fetch_assoc($result);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-calendar-check"></i>

Appointment Details

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Patient

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($appointment['patient_name']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Doctor

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($appointment['doctor_name']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Appointment Date

</label>

<div class="form-control bg-light">

<?= date("d M Y",strtotime($appointment['appointment_date'])); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Appointment Time

</label>

<div class="form-control bg-light">

<?= date("h:i A",strtotime($appointment['appointment_time'])); ?>

</div>

</div>

<div class="col-md-12 mb-3">

<label class="fw-bold text-muted">

Reason for Visit

</label>

<div class="form-control bg-light" style="min-height:100px;">

<?= nl2br(htmlspecialchars($appointment['reason'])); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Status

</label>

<div class="form-control bg-light">

<?php

if($appointment['status']=="Scheduled"){

echo '<span class="badge bg-warning text-dark">Scheduled</span>';

}elseif($appointment['status']=="Completed"){

echo '<span class="badge bg-success">Completed</span>';

}else{

echo '<span class="badge bg-danger">Cancelled</span>';

}

?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Created On

</label>

<div class="form-control bg-light">

<?= date("d M Y h:i A",strtotime($appointment['created_at'])); ?>

</div>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="view_appointments.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<div>

<a
href="edit_appointment.php?id=<?= $appointment['appointment_id']; ?>"
class="btn btn-warning">

<i class="bi bi-pencil"></i>

Edit

</a>

<a
href="delete_appointment.php?id=<?= $appointment['appointment_id']; ?>"
class="btn btn-danger"
onclick="return confirm('Delete this appointment?');">

<i class="bi bi-trash"></i>

Delete

</a>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>