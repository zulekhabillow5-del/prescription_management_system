<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Dashboard";

// Dashboard Statistics
$totalPatients = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients")
)['total'];

$totalMedicines = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM medicines")
)['total'];

$totalPrescriptions = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM prescriptions")
)['total'];

$totalAppointments = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments")
)['total'];

// Today's Appointments
$today = date("Y-m-d");

$todayAppointments = mysqli_query($conn,"
SELECT a.*, p.full_name
FROM appointments a
JOIN patients p ON a.patient_id = p.patient_id
WHERE appointment_date='$today'
ORDER BY appointment_time ASC
");

// Low Stock Medicines
$lowStock = mysqli_query($conn,"
SELECT *
FROM medicines
WHERE stock_quantity<=10
ORDER BY stock_quantity ASC
");

// Expiring Medicines
$expiring = mysqli_query($conn,"
SELECT *
FROM medicines
WHERE expiry_date IS NOT NULL
AND expiry_date<=DATE_ADD(CURDATE(),INTERVAL 30 DAY)
ORDER BY expiry_date ASC
");

// Monthly Patients Chart
$patientChart = mysqli_query($conn,"
SELECT MONTH(created_at) month,
COUNT(*) total
FROM patients
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
");

$patientLabels = [];
$patientData = [];

while($row=mysqli_fetch_assoc($patientChart)){
    $patientLabels[] = date("M", mktime(0,0,0,$row['month'],1));
    $patientData[] = $row['total'];
}

// Monthly Prescriptions Chart
$prescriptionChart = mysqli_query($conn,"
SELECT MONTH(created_at) month,
COUNT(*) total
FROM prescriptions
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
");

$prescriptionLabels = [];
$prescriptionData = [];

while($row=mysqli_fetch_assoc($prescriptionChart)){
    $prescriptionLabels[] = date("M", mktime(0,0,0,$row['month'],1));
    $prescriptionData[] = $row['total'];
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="mb-4">

<h2 class="fw-bold">
<i class="bi bi-speedometer2 text-primary"></i>
Dashboard
</h2>

<p class="text-muted">
Welcome back,
<strong><?= htmlspecialchars($_SESSION['doctor_name']); ?></strong>
</p>

</div>

<!-- Statistics Cards -->

<div class="row g-4 mb-4">

<div class="col-lg-3 col-md-6">

<div class="card shadow border-0">

<div class="card-body text-center">

<i class="bi bi-people-fill text-primary" style="font-size:45px;"></i>

<h2><?= $totalPatients ?></h2>

<p class="text-muted mb-0">
Patients
</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card shadow border-0">

<div class="card-body text-center">

<i class="bi bi-capsule-pill text-success" style="font-size:45px;"></i>

<h2><?= $totalMedicines ?></h2>

<p class="text-muted mb-0">
Medicines
</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card shadow border-0">

<div class="card-body text-center">

<i class="bi bi-file-earmark-medical text-warning" style="font-size:45px;"></i>

<h2><?= $totalPrescriptions ?></h2>

<p class="text-muted mb-0">
Prescriptions
</p>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card shadow border-0">

<div class="card-body text-center">

<i class="bi bi-calendar-check text-danger" style="font-size:45px;"></i>

<h2><?= $totalAppointments ?></h2>

<p class="text-muted mb-0">
Appointments
</p>

</div>

</div>

</div>

</div>

<div class="row">

<!-- Today's Appointments -->

<div class="col-lg-4">

<div class="card shadow border-0 mb-4">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

<i class="bi bi-calendar-event"></i>

Today's Appointments

</h5>

</div>

<div class="card-body">

<?php

if(mysqli_num_rows($todayAppointments)>0){

while($row=mysqli_fetch_assoc($todayAppointments)){

?>

<div class="border-bottom pb-2 mb-2">

<strong><?= htmlspecialchars($row['full_name']); ?></strong><br>

<?= date("h:i A",strtotime($row['appointment_time'])) ?><br>

<small class="text-muted">

<?= htmlspecialchars($row['reason']) ?>

</small>

</div>

<?php

}

}else{

echo "<p class='text-muted'>No appointments today.</p>";

}

?>

</div>

</div>

</div>
<!-- Low Stock Medicines -->

<div class="col-lg-4">

<div class="card shadow border-0 mb-4">

<div class="card-header bg-warning">

<h5 class="mb-0">

<i class="bi bi-exclamation-triangle-fill"></i>

Low Stock Medicines

</h5>

</div>

<div class="card-body">

<?php

if(mysqli_num_rows($lowStock)>0){

while($row=mysqli_fetch_assoc($lowStock)){

?>

<div class="border-bottom pb-2 mb-2">

<strong><?= htmlspecialchars($row['name']); ?></strong><br>

Stock Remaining

<span class="badge bg-danger">

<?= $row['stock_quantity']; ?>

</span>

</div>

<?php

}

}else{

?>

<p class="text-success">

<i class="bi bi-check-circle-fill"></i>

All medicines have sufficient stock.

</p>

<?php

}

?>

</div>

</div>

</div>

<!-- Expiring Medicines -->

<div class="col-lg-4">

<div class="card shadow border-0 mb-4">

<div class="card-header bg-danger text-white">

<h5 class="mb-0">

<i class="bi bi-clock-history"></i>

Expiring Medicines

</h5>

</div>

<div class="card-body">

<?php

if(mysqli_num_rows($expiring)>0){

while($row=mysqli_fetch_assoc($expiring)){

?>

<div class="border-bottom pb-2 mb-2">

<strong>

<?= htmlspecialchars($row['name']); ?>

</strong>

<br>

Expires on

<strong>

<?= date("d M Y",strtotime($row['expiry_date'])); ?>

</strong>

</div>

<?php

}

}else{

?>

<p class="text-success">

<i class="bi bi-check-circle-fill"></i>

No medicines expiring within 30 days.

</p>

<?php

}

?>

</div>

</div>

</div>

</div>

<!-- Quick Actions -->

<div class="card shadow border-0 mb-4">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

<i class="bi bi-lightning-charge-fill"></i>

Quick Actions

</h5>

</div>

<div class="card-body">

<div class="row g-3">

<div class="col-md-3">

<a href="view_patients.php"

class="btn btn-primary w-100 py-4">

<i class="bi bi-people-fill fs-2"></i>

<br><br>

Patients

</a>

</div>

<div class="col-md-3">

<a href="view_medicines.php"

class="btn btn-success w-100 py-4">

<i class="bi bi-capsule-pill fs-2"></i>

<br><br>

Medicines

</a>

</div>

<div class="col-md-3">

<a href="new_prescription.php"

class="btn btn-warning text-dark w-100 py-4">

<i class="bi bi-file-earmark-medical fs-2"></i>

<br><br>

New Prescription

</a>

</div>

<div class="col-md-3">

<a href="reports.php"

class="btn btn-danger w-100 py-4">

<i class="bi bi-bar-chart-fill fs-2"></i>

<br><br>

Reports

</a>

</div>

</div>

</div>

</div>

<!-- Charts -->

<div class="row">

<div class="col-lg-6">

<div class="card shadow border-0 mb-4">

<div class="card-header bg-info text-white">

<h5 class="mb-0">

Patients Registered

</h5>

</div>

<div class="card-body">

<canvas id="patientChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card shadow border-0 mb-4">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

Prescriptions Issued

</h5>

</div>

<div class="card-body">

<canvas id="prescriptionChart"></canvas>

</div>

</div>

</div>

</div>
<script>

// Patients Chart
const patientCtx = document.getElementById('patientChart');

if(patientCtx){

new Chart(patientCtx,{

type:'bar',

data:{

labels:<?= json_encode($patientLabels); ?>,

datasets:[{

label:'Patients',

data:<?= json_encode($patientData); ?>,

backgroundColor:'#0d6efd',

borderRadius:8

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

}

// Prescriptions Chart
const prescriptionCtx = document.getElementById('prescriptionChart');

if(prescriptionCtx){

new Chart(prescriptionCtx,{

type:'line',

data:{

labels:<?= json_encode($prescriptionLabels); ?>,

datasets:[{

label:'Prescriptions',

data:<?= json_encode($prescriptionData); ?>,

borderColor:'#198754',

backgroundColor:'rgba(25,135,84,0.15)',

fill:true,

tension:0.4

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

}

</script>

<?php include "includes/footer.php"; ?>