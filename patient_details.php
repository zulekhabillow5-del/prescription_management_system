<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Patient Details";

if (!isset($_GET['id'])) {
    header("Location: view_patients.php");
    exit();
}

$patient_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT *
FROM patients
WHERE patient_id='$patient_id'
");

if(mysqli_num_rows($result)==0){
    die("Patient not found.");
}

$patient = mysqli_fetch_assoc($result);

$history = mysqli_query($conn,"
SELECT
prescription_id,
prescription_date,
status,
diagnosis
FROM prescriptions
WHERE patient_id='$patient_id'
ORDER BY prescription_date DESC
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

<i class="bi bi-person-vcard-fill"></i>

Patient Details

</h4>

<a href="view_patients.php" class="btn btn-light">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<h5 class="text-primary mb-3">

Personal Information

</h5>

<table class="table table-borderless">

<tr>

<th width="180">Full Name</th>

<td><?= htmlspecialchars($patient['full_name']); ?></td>

</tr>

<tr>

<th>Gender</th>

<td><?= htmlspecialchars($patient['gender']); ?></td>

</tr>

<tr>

<th>Date of Birth</th>

<td><?= date("d M Y", strtotime($patient['dob'])); ?></td>

</tr>

<tr>

<th>Blood Group</th>

<td><?= htmlspecialchars($patient['blood_group']); ?></td>

</tr>

<tr>

<th>Phone</th>

<td><?= htmlspecialchars($patient['phone']); ?></td>

</tr>

<tr>

<th>Address</th>

<td><?= nl2br(htmlspecialchars($patient['address'])); ?></td>

</tr>

</table>

</div>
<div class="col-md-6">

<h5 class="text-primary mb-3">

Prescription History

</h5>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Date</th>

<th>Diagnosis</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($history)>0){

while($row=mysqli_fetch_assoc($history)){

?>

<tr>

<td>

<?= $row['prescription_id']; ?>

</td>

<td>

<?= date("d M Y",strtotime($row['prescription_date'])); ?>

</td>

<td>

<?= htmlspecialchars($row['diagnosis']); ?>

</td>

<td>

<?php

if($row['status']=="Completed"){

echo '<span class="badge bg-success">Completed</span>';

}elseif($row['status']=="Pending"){

echo '<span class="badge bg-warning text-dark">Pending</span>';

}else{

echo '<span class="badge bg-danger">Cancelled</span>';

}

?>

</td>

<td>

<a
href="view_prescription.php?id=<?= $row['prescription_id']; ?>"
class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a
href="print_prescription.php?id=<?= $row['prescription_id']; ?>"
class="btn btn-success btn-sm">

<i class="bi bi-printer"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center py-4">

No prescriptions found for this patient.

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

</div>

<?php include "includes/footer.php"; ?>