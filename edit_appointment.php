<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Edit Appointment";

if (!isset($_GET['id'])) {
    header("Location: view_appointments.php");
    exit();
}

$appointment_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT *
FROM appointments
WHERE appointment_id='$appointment_id'
");

if(mysqli_num_rows($result)==0){
    die("Appointment not found.");
}

$appointment = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$patient_id = intval($_POST['patient_id']);
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];
$reason = mysqli_real_escape_string($conn,$_POST['reason']);
$status = mysqli_real_escape_string($conn,$_POST['status']);

mysqli_query($conn,"
UPDATE appointments SET

patient_id='$patient_id',
appointment_date='$appointment_date',
appointment_time='$appointment_time',
reason='$reason',
status='$status'

WHERE appointment_id='$appointment_id'
");

header("Location:view_appointments.php?success=updated");
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

<div class="card-header bg-warning">

<h4 class="mb-0">

<i class="bi bi-pencil-square"></i>

Edit Appointment

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

<?php

while($patient=mysqli_fetch_assoc($patients)){

?>

<option
value="<?= $patient['patient_id']; ?>"
<?= $appointment['patient_id']==$patient['patient_id'] ? "selected" : ""; ?>>

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
value="<?= $appointment['appointment_date']; ?>"
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
value="<?= substr($appointment['appointment_time'],0,5); ?>"
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
placeholder="Enter reason for the appointment..."><?= htmlspecialchars($appointment['reason']); ?></textarea>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select"
required>

<option value="Scheduled"
<?= $appointment['status']=="Scheduled" ? "selected" : ""; ?>>

Scheduled

</option>

<option value="Completed"
<?= $appointment['status']=="Completed" ? "selected" : ""; ?>>

Completed

</option>

<option value="Cancelled"
<?= $appointment['status']=="Cancelled" ? "selected" : ""; ?>>

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
name="update"
class="btn btn-warning">

<i class="bi bi-save"></i>

Update Appointment

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>