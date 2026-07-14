<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "View Prescription";

if (!isset($_GET['id'])) {
    header("Location: prescription_history.php");
    exit();
}

$prescription_id = intval($_GET['id']);

$sql = "SELECT
p.*,
pa.full_name AS patient_name,
pa.gender,
pa.phone,
pa.blood_group,
d.full_name AS doctor_name,
d.specialization
FROM prescriptions p
INNER JOIN patients pa
ON p.patient_id = pa.patient_id
INNER JOIN doctors d
ON p.doctor_id = d.doctor_id
WHERE p.prescription_id='$prescription_id'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0){
    die("Prescription not found.");
}

$prescription = mysqli_fetch_assoc($result);

$medicineQuery = mysqli_query($conn,"
SELECT
pd.*,
m.name,
m.strength,
m.form
FROM prescription_details pd
INNER JOIN medicines m
ON pd.medicine_id=m.medicine_id
WHERE pd.prescription_id='$prescription_id'
");

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<div class="d-flex justify-content-between align-items-center">

<h4 class="mb-0">

<i class="bi bi-file-earmark-medical"></i>

Prescription Details

</h4>

<div>

<a href="print_prescription.php?id=<?= $prescription_id; ?>"
class="btn btn-light">

<i class="bi bi-printer"></i>

Print

</a>

<a href="prescription_history.php"
class="btn btn-warning">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

</div>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<h5 class="text-primary">

Patient Information

</h5>

<table class="table table-borderless">

<tr>

<th width="180">Patient Name</th>

<td><?= htmlspecialchars($prescription['patient_name']); ?></td>

</tr>

<tr>

<th>Gender</th>

<td><?= htmlspecialchars($prescription['gender']); ?></td>

</tr>

<tr>

<th>Phone</th>

<td><?= htmlspecialchars($prescription['phone']); ?></td>

</tr>

<tr>

<th>Blood Group</th>

<td><?= htmlspecialchars($prescription['blood_group']); ?></td>

</tr>

</table>

</div>

<div class="col-md-6">

<h5 class="text-primary">

Doctor Information

</h5>

<table class="table table-borderless">

<tr>

<th width="180">Doctor</th>

<td><?= htmlspecialchars($prescription['doctor_name']); ?></td>

</tr>

<tr>

<th>Specialization</th>

<td><?= htmlspecialchars($prescription['specialization']); ?></td>

</tr>

<tr>

<th>Date</th>

<td>

<?= date("d M Y",strtotime($prescription['prescription_date'])); ?>

</td>

</tr>

<tr>

<th>Status</th>

<td>

<?php

if($prescription['status']=="Completed"){

echo '<span class="badge bg-success">Completed</span>';

}elseif($prescription['status']=="Pending"){

echo '<span class="badge bg-warning text-dark">Pending</span>';

}else{

echo '<span class="badge bg-danger">Cancelled</span>';

}

?>

</td>

</tr>

</table>

</div>

</div>

<hr>

<h5 class="text-primary">

Diagnosis

</h5>

<div class="alert alert-light border">

<?= nl2br(htmlspecialchars($prescription['diagnosis'])); ?>

</div>

<h5 class="text-primary mt-4">

Doctor Notes

</h5>

<div class="alert alert-light border">

<?= nl2br(htmlspecialchars($prescription['notes'])); ?>

</div>

<hr>

<h5 class="text-primary mb-3">

Medicines Prescribed

</h5>

<table class="table table-bordered table-hover">

<thead class="table-primary">

<tr>

<th>#</th>

<th>Medicine</th>

<th>Dosage</th>

<th>Frequency</th>

<th>Duration</th>

<th>Instructions</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

while($medicine=mysqli_fetch_assoc($medicineQuery)){

?>
<tr>

<td><?= $i++; ?></td>

<td>

<strong><?= htmlspecialchars($medicine['name']); ?></strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($medicine['strength']); ?>

<?= htmlspecialchars($medicine['form']); ?>

</small>

</td>

<td>

<?= htmlspecialchars($medicine['dosage']); ?>

</td>

<td>

<?= htmlspecialchars($medicine['frequency']); ?>

</td>

<td>

<?= htmlspecialchars($medicine['duration']); ?>

</td>

<td>

<?= htmlspecialchars($medicine['instructions']); ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<hr class="my-4">

<div class="row mt-5">

<div class="col-md-6">

<p>

<strong>Doctor's Signature</strong>

</p>

<br><br>

_____________________________________

<br>

<?= htmlspecialchars($prescription['doctor_name']); ?>

<br>

<small>

<?= htmlspecialchars($prescription['specialization']); ?>

</small>

</div>

<div class="col-md-6 text-end">

<p>

<strong>Date Issued</strong>

</p>

<h5>

<?= date("d M Y",strtotime($prescription['prescription_date'])); ?>

</h5>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>