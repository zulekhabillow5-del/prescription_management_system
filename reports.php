<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Reports";

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

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-bar-chart-fill text-primary"></i>

Reports Dashboard

</h2>

<p class="text-muted">

System Summary Reports

</p>

</div>

</div>

<div class="row">
    <div class="col-md-3 mb-4">

<div class="card shadow border-0 bg-primary text-white">

<div class="card-body text-center">

<i class="bi bi-people-fill" style="font-size:50px;"></i>

<h2 class="mt-3">

<?= $totalPatients; ?>

</h2>

<h5>Total Patients</h5>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card shadow border-0 bg-success text-white">

<div class="card-body text-center">

<i class="bi bi-capsule-pill" style="font-size:50px;"></i>

<h2 class="mt-3">

<?= $totalMedicines; ?>

</h2>

<h5>Total Medicines</h5>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card shadow border-0 bg-warning text-dark">

<div class="card-body text-center">

<i class="bi bi-file-earmark-medical-fill" style="font-size:50px;"></i>

<h2 class="mt-3">

<?= $totalPrescriptions; ?>

</h2>

<h5>Total Prescriptions</h5>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card shadow border-0 bg-info text-white">

<div class="card-body text-center">

<i class="bi bi-calendar-check-fill" style="font-size:50px;"></i>

<h2 class="mt-3">

<?= $totalAppointments; ?>

</h2>

<h5>Total Appointments</h5>

</div>

</div>

</div>

</div>
<div class="card shadow border-0">

<div class="card-header bg-dark text-white">

<h4 class="mb-0">

<i class="bi bi-folder2-open"></i>

Available Reports

</h4>

</div>

<div class="card-body">

<div class="row g-4">

<div class="col-md-4">

<div class="card border-primary shadow-sm h-100">

<div class="card-body text-center">

<i class="bi bi-people-fill text-primary" style="font-size:55px;"></i>

<h5 class="mt-3">

Patients Report

</h5>

<p class="text-muted">

View all registered patients.

</p>

<a href="view_patients.php" class="btn btn-primary">

<i class="bi bi-eye"></i>

Open

</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card border-success shadow-sm h-100">

<div class="card-body text-center">

<i class="bi bi-capsule-pill text-success" style="font-size:55px;"></i>

<h5 class="mt-3">

Medicines Report

</h5>

<p class="text-muted">

View medicine inventory.

</p>

<a href="view_medicines.php" class="btn btn-success">

<i class="bi bi-eye"></i>

Open

</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card border-warning shadow-sm h-100">

<div class="card-body text-center">

<i class="bi bi-file-earmark-medical-fill text-warning" style="font-size:55px;"></i>

<h5 class="mt-3">

Prescriptions Report

</h5>

<p class="text-muted">

View prescription history.

</p>

<a href="prescription_history.php" class="btn btn-warning">

<i class="bi bi-eye"></i>

Open

</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card border-info shadow-sm h-100">

<div class="card-body text-center">

<i class="bi bi-calendar-check-fill text-info" style="font-size:55px;"></i>

<h5 class="mt-3">

Appointments Report

</h5>

<p class="text-muted">

View all appointments.

</p>

<a href="view_appointments.php" class="btn btn-info text-white">

<i class="bi bi-eye"></i>

Open

</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card border-danger shadow-sm h-100">

<div class="card-body text-center">

<i class="bi bi-printer-fill text-danger" style="font-size:55px;"></i>

<h5 class="mt-3">

Print Reports

</h5>

<p class="text-muted">

Generate printable reports.

</p>

<a href="print_reports.php" class="btn btn-danger">

<i class="bi bi-printer"></i>

Print

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>
