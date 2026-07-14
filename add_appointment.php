<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "New Appointment";

if(isset($_POST['save'])){

$patient_id = intval($_POST['patient_id']);
$doctor_id = $_SESSION['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];
$reason = mysqli_real_escape_string($conn,$_POST['reason']);
$status = mysqli_real_escape_string($conn,$_POST['status']);

mysqli_query($conn,"
INSERT INTO appointments
(
patient_id,
doctor_id,
appointment_date,
appointment_time,
reason,
status
)
VALUES
(
'$patient_id',
'$doctor_id',
'$appointment_date',
'$appointment_time',
'$reason',
'$status'
)
");

header("Location:view_appointments.php?success=added");
exit();

}

$patients = mysqli_query($conn,"
SELECT patient_id, full_name
FROM patients
ORDER BY full_name ASC
");

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-calendar-plus"></i>

Schedule Appointment

</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Patient

</label>

<select
name="patient_id"
class="form-select"
required>

<option value="">

Select Patient

</option>

<?php

while($patient=mysqli_fetch_assoc($patients)){

?>

<option
value="<?= $patient['patient_id']; ?>">

<?= htmlspecialchars($patient['full_name']); ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Appointment Date

</label>

<input
type="date"
name="appointment_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Appointment Time

</label>

<input
type="time"
name="appointment_time"
class="form-control"
required>

</div>
<div class="col-md-12 mb-3">

<label class="form-label">

Reason for Visit

</label>

<textarea
name="reason"
class="form-control"
rows="4"
placeholder="Enter reason for the appointment..."></textarea>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select"
required>

<option value="Scheduled" selected>

Scheduled

</option>

<option value="Completed">

Completed

</option>

<option value="Cancelled">

Cancelled

</option>

</select>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="view_appointments.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
name="save"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Appointment

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>