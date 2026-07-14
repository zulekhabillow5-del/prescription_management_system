<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Settings";

$doctor_id = $_SESSION['doctor_id'];

$result = mysqli_query($conn,"
SELECT *
FROM doctors
WHERE doctor_id='$doctor_id'
");

if(mysqli_num_rows($result)==0){
    die("Doctor not found.");
}

$doctor = mysqli_fetch_assoc($result);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-gear-fill text-primary"></i>

Settings

</h2>

<p class="text-muted">

Manage your account settings.

</p>

</div>

</div>

<div class="row">

<div class="col-lg-4">

<div class="card shadow border-0">

<div class="card-body text-center">

<i class="bi bi-person-circle text-primary" style="font-size:90px;"></i>

<h4 class="mt-3">

<?= htmlspecialchars($doctor['full_name']); ?>

</h4>

<p class="text-muted">

Doctor

</p>

<a href="edit_profile.php" class="btn btn-primary">

<i class="bi bi-pencil-square"></i>

Edit Profile

</a>

</div>

</div>

</div>

<div class="col-lg-8">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

Profile Information

</h5>

</div>

<div class="card-body"></div>
<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Full Name

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['full_name']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Username

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['username']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Email Address

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['email']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Phone Number

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['phone']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Specialization

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['specialization']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

License Number

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($doctor['license_number']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Member Since

</label>

<div class="form-control bg-light">

<?= date("d M Y", strtotime($doctor['created_at'])); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Doctor ID

</label>

<div class="form-control bg-light">

<?= $doctor['doctor_id']; ?>

</div>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="index.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back to Dashboard

</a>

<div>

<a href="edit_profile.php" class="btn btn-primary">

<i class="bi bi-person-lines-fill"></i>

Edit Profile

</a>

<a href="change_password.php" class="btn btn-warning">

<i class="bi bi-key-fill"></i>

Change Password

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>