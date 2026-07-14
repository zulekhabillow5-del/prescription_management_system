<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Change Password";

$doctor_id = $_SESSION['doctor_id'];

$message = "";
$error = "";

if(isset($_POST['change'])){

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

$result = mysqli_query($conn,"
SELECT password
FROM doctors
WHERE doctor_id='$doctor_id'
");

$doctor = mysqli_fetch_assoc($result);

if(!password_verify($current_password,$doctor['password'])){

$error = "Current password is incorrect.";

}elseif($new_password != $confirm_password){

$error = "New passwords do not match.";

}else{

$hashed_password = password_hash($new_password,PASSWORD_DEFAULT);

mysqli_query($conn,"
UPDATE doctors
SET password='$hashed_password'
WHERE doctor_id='$doctor_id'
");

$message = "Password changed successfully.";

}

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h4 class="mb-0">

<i class="bi bi-key-fill"></i>

Change Password

</h4>

</div>

<div class="card-body">

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?= $message; ?>

</div>

<?php } ?>

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Current Password

</label>

<input
type="password"
name="current_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

New Password

</label>

<input
type="password"
name="new_password"
class="form-control"
required>

</div>
<div class="mb-3">

<label class="form-label">

Confirm New Password

</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="settings.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
name="change"
class="btn btn-warning">

<i class="bi bi-key-fill"></i>

Change Password

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>