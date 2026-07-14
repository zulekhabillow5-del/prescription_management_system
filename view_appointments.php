<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Appointments";

$search = "";

$sql = "SELECT
a.*,
p.full_name AS patient_name
FROM appointments a
INNER JOIN patients p
ON a.patient_id = p.patient_id";

if(isset($_GET['search']) && $_GET['search']!=""){

$search = mysqli_real_escape_string($conn,$_GET['search']);

$sql .= " WHERE p.full_name LIKE '%$search%'";

}

$sql .= " ORDER BY a.appointment_date DESC,
a.appointment_time DESC";

$result = mysqli_query($conn,$sql);

$totalAppointments = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM appointments
"))['total'];

$todayAppointments = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM appointments
WHERE appointment_date=CURDATE()
"))['total'];

$scheduled = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM appointments
WHERE status='Scheduled'
"))['total'];

$completed = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM appointments
WHERE status='Completed'
"))['total'];

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-calendar-check text-primary"></i>

Appointments

</h2>

<p class="text-muted">

Manage patient appointments.

</p>

</div>

<a href="add_appointment.php" class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

New Appointment

</a>

</div>
<div class="row g-3 mb-4">

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-calendar-event text-primary fs-1"></i>

<h3><?= $totalAppointments ?></h3>

<p>Total Appointments</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-calendar-day text-success fs-1"></i>

<h3><?= $todayAppointments ?></h3>

<p>Today's Appointments</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-hourglass-split text-warning fs-1"></i>

<h3><?= $scheduled ?></h3>

<p>Scheduled</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-check-circle text-success fs-1"></i>

<h3><?= $completed ?></h3>

<p>Completed</p>

</div>

</div>

</div>

</div>
<div class="card shadow border-0 mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search patient..."
value="<?= htmlspecialchars($search); ?>">

</div>

<div class="col-md-2 d-grid">

<button class="btn btn-primary">

<i class="bi bi-search"></i>

Search

</button>

</div>

</div>

</form>

</div>

</div>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

<i class="bi bi-list-ul"></i>

Appointment List

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Patient</th>

<th>Date</th>

<th>Time</th>

<th>Status</th>

<th width="180">

Actions

</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?= $row['appointment_id']; ?>

</td>

<td>

<?= htmlspecialchars($row['patient_name']); ?>

</td>

<td>

<?= date("d M Y",strtotime($row['appointment_date'])); ?>

</td>

<td>

<?= date("h:i A",strtotime($row['appointment_time'])); ?>

</td>

<td>

<?php

if($row['status']=="Scheduled"){

echo '<span class="badge bg-warning text-dark">Scheduled</span>';

}elseif($row['status']=="Completed"){

echo '<span class="badge bg-success">Completed</span>';

}else{

echo '<span class="badge bg-danger">Cancelled</span>';

}

?>

</td>

<td>

<a
href="appointment_details.php?id=<?= $row['appointment_id']; ?>"
class="btn btn-info btn-sm"
title="View">

<i class="bi bi-eye"></i>

</a>

<a
href="edit_appointment.php?id=<?= $row['appointment_id']; ?>"
class="btn btn-warning btn-sm"
title="Edit">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete_appointment.php?id=<?= $row['appointment_id']; ?>"
class="btn btn-danger btn-sm"
title="Delete"
onclick="return confirm('Delete this appointment?');">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" class="text-center py-5">

<i class="bi bi-calendar-x fs-1 text-secondary"></i>

<br><br>

<h5>

No appointments found.

</h5>

<a
href="add_appointment.php"
class="btn btn-primary mt-3">

<i class="bi bi-plus-circle"></i>

Schedule Appointment

</a>

</td>

</tr>

<?php

}

?>
</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>