<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

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
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Print Prescription</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:white;
    padding:40px;
    font-family:Arial, Helvetica, sans-serif;
}

.header{
    text-align:center;
    border-bottom:3px solid #0d6efd;
    margin-bottom:30px;
    padding-bottom:15px;
}

.header h2{
    color:#0d6efd;
    font-weight:bold;
}

table{
    width:100%;
}

.signature{
    margin-top:70px;
}

@media print{

.no-print{
display:none;
}

}

</style>

</head>

<body>

<div class="container">

<div class="header">

<h2>

Prescription Management System

</h2>

<p>

Professional Prescription

</p>

</div>

<div class="row">

<div class="col-6">

<h5 class="text-primary">

Patient Information

</h5>

<p>

<strong>Name:</strong>

<?= htmlspecialchars($prescription['patient_name']); ?>

</p>

<p>

<strong>Gender:</strong>

<?= htmlspecialchars($prescription['gender']); ?>

</p>

<p>

<strong>Phone:</strong>

<?= htmlspecialchars($prescription['phone']); ?>

</p>

<p>

<strong>Blood Group:</strong>

<?= htmlspecialchars($prescription['blood_group']); ?>

</p>

</div>

<div class="col-6 text-end">

<h5 class="text-primary">

Doctor Information

</h5>

<p>

<strong>

<?= htmlspecialchars($prescription['doctor_name']); ?>

</strong>

</p>

<p>

<?= htmlspecialchars($prescription['specialization']); ?>

</p>

<p>

<?= date("d M Y",strtotime($prescription['prescription_date'])); ?>

</p>

</div>

</div>

<hr>

<h5 class="text-primary">

Diagnosis

</h5>

<p>

<?= nl2br(htmlspecialchars($prescription['diagnosis'])); ?>

</p>

<h5 class="text-primary mt-4">

Medicines

</h5>

<table class="table table-bordered">

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

<small>

<?= htmlspecialchars($medicine['strength']); ?>

<?= htmlspecialchars($medicine['form']); ?>

</small>

</td>

<td><?= htmlspecialchars($medicine['dosage']); ?></td>

<td><?= htmlspecialchars($medicine['frequency']); ?></td>

<td><?= htmlspecialchars($medicine['duration']); ?></td>

<td><?= htmlspecialchars($medicine['instructions']); ?></td>

</tr>

<?php

}

?>

</tbody>

</table>

<h5 class="text-primary mt-4">

Doctor Notes

</h5>

<p>

<?= nl2br(htmlspecialchars($prescription['notes'])); ?>

</p>

<div class="row signature">

<div class="col-6">

<p>

<strong>Doctor's Signature</strong>

</p>

<br><br><br>

____________________________________

<br>

<strong>

<?= htmlspecialchars($prescription['doctor_name']); ?>

</strong>

<br>

<?= htmlspecialchars($prescription['specialization']); ?>

</div>

<div class="col-6 text-end">

<p>

<strong>Date Issued</strong>

</p>

<p>

<?= date("d M Y", strtotime($prescription['prescription_date'])); ?>

</p>

</div>

</div>

<div class="text-center mt-5 no-print">

<button onclick="window.print();" class="btn btn-primary btn-lg">

<i class="bi bi-printer"></i>

Print Prescription

</button>

<a href="view_prescription.php?id=<?= $prescription_id; ?>" class="btn btn-secondary btn-lg">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

</div>

<script>

window.onload = function(){

window.print();

};

</script>

</body>

</html>