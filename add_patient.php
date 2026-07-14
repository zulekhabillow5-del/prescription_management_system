<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $dob = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $blood_group = $_POST['blood_group'];
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies']);

    $doctor_id = $_SESSION['doctor_id'];

    $sql = "INSERT INTO patients
    (full_name,date_of_birth,gender,phone,email,address,blood_group,allergies,created_by)
    VALUES
    ('$full_name','$dob','$gender','$phone','$email','$address','$blood_group','$allergies','$doctor_id')";

    if(mysqli_query($conn,$sql)){
        $message="Patient added successfully!";
    }else{
        $message="Error: ".mysqli_error($conn);
    }

}

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3 class="mb-0">
<i class="bi bi-person-plus"></i>
Add New Patient
</h3>

</div>

<div class="card-body">

<?php if($message!=""): ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="full_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Date of Birth

</label>

<input
type="date"
name="date_of_birth"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Gender

</label>

<select
name="gender"
class="form-select"
required>

<option value="">Select Gender</option>

<option>Male</option>

<option>Female</option>

<option>Other</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Phone Number

</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Blood Group

</label>

<select
name="blood_group"
class="form-select">

<option value="">Select</option>

<option>O+</option>

<option>O-</option>

<option>A+</option>

<option>A-</option>

<option>B+</option>

<option>B-</option>

<option>AB+</option>

<option>AB-</option>

</select>

</div>

<div class="col-12 mb-3">

<label class="form-label">

Address

</label>

<textarea
name="address"
class="form-control"
rows="3"></textarea>

</div>

<div class="col-12 mb-3">

<label class="form-label">

Known Allergies

</label>

<textarea
name="allergies"
class="form-control"
rows="3"></textarea>

</div>

</div>

<div class="text-end">

<a href="index.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-check-circle"></i>

Save Patient

</button>

</div>

</form>

</div>

</div>

</div>

<?php
include "includes/footer.php";
?>