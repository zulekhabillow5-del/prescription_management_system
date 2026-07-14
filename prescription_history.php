<?php
session_start();

if(!isset($_SESSION['doctor_id'])){
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Prescription History";

$search = "";

$sql = "SELECT
p.prescription_id,
p.prescription_date,
p.status,
pa.full_name AS patient_name,
d.full_name AS doctor_name
FROM prescriptions p
INNER JOIN patients pa
ON p.patient_id = pa.patient_id
INNER JOIN doctors d
ON p.doctor_id = d.doctor_id
ORDER BY p.prescription_id DESC";
if(isset($_GET['search']) && $_GET['search']!=""){

$search = mysqli_real_escape_string($conn,$_GET['search']);

$sql = "SELECT
p.prescription_id,
p.prescription_date,
p.status,
pa.full_name AS patient_name,
d.full_name AS doctor_name
FROM prescriptions p
INNER JOIN patients pa
ON p.patient_id = pa.patient_id
INNER JOIN doctors d
ON p.doctor_id = d.doctor_id
WHERE pa.full_name LIKE '%$search%'
ORDER BY p.prescription_id DESC";

}

$result = mysqli_query($conn,$sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<div class="d-flex justify-content-between align-items-center">

<h4 class="mb-0">

<i class="bi bi-clock-history"></i>

Prescription History

</h4>

<a href="new_prescription.php" class="btn btn-light">

<i class="bi bi-plus-circle"></i>

New Prescription

</a>

</div>

</div>

<div class="card-body">

<form method="GET">

<div class="row mb-4">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Patient..."
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

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Patient</th>

<th>Doctor</th>

<th>Date</th>

<th>Status</th>

<th width="220">

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

<?= $row['prescription_id']; ?>

</td>

<td>

<?= htmlspecialchars($row['patient_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['doctor_name']); ?>

</td>

<td>

<?= date("d M Y",strtotime($row['prescription_date'])); ?>

</td>

<td>

<?php

$status = $row['status'];

if($status=="Completed"){

echo '<span class="badge bg-success">Completed</span>';

}elseif($status=="Pending"){

echo '<span class="badge bg-warning text-dark">Pending</span>';

}else{

echo '<span class="badge bg-danger">Cancelled</span>';

}

?>

</td>

<td>

<a href="view_prescription.php?id=<?= $row['prescription_id']; ?>" class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a href="print_prescription.php?id=<?= $row['prescription_id']; ?>" class="btn btn-success btn-sm">

<i class="bi bi-printer"></i>

</a>

<a href="delete_prescription.php?id=<?= $row['prescription_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this prescription?')">

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

<i class="bi bi-file-earmark-medical fs-1 text-secondary"></i>

<br><br>

<h5>

No Prescriptions Found

</h5>

<a href="new_prescription.php" class="btn btn-primary mt-3">

Create First Prescription

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