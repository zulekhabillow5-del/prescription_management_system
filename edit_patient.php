<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Edit Patient";

if (!isset($_GET['id'])) {
    header("Location: view_patients.php");
    exit();
}

$patient_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT * FROM patients
WHERE patient_id='$patient_id'
");

if(mysqli_num_rows($result)==0){
    die("Patient not found.");
}

$patient = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
$gender = mysqli_real_escape_string($conn,$_POST['gender']);
$dob = $_POST['dob'];
$phone = mysqli_real_escape_string($conn,$_POST['phone']);
$address = mysqli_real_escape_string($conn,$_POST['address']);
$blood_group = mysqli_real_escape_string($conn,$_POST['blood_group']);

mysqli_query($conn,"
UPDATE patients SET
full_name='$full_name',
gender='$gender',
dob='$dob',
phone='$phone',
address='$address',
blood_group='$blood_group'
WHERE patient_id='$patient_id'
");

header("Location:view_patients.php?success=updated");
exit();

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-pencil-square"></i>

Edit Patient

</h4>

</div>

<div class="card-body">

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
value="<?= htmlspecialchars($patient['full_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Gender

</label>

<select
name="gender"
class="form-select"
required>

<option value="Male"
<?= $patient['gender']=="Male"?"selected":""; ?>>

Male

</option>

<option value="Female"
<?= $patient['gender']=="Female"?"selected":""; ?>>

Female

</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Date of Birth

</label>

<input
type="date"
name="dob"
class="form-control"
value="<?= $patient['dob']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($patient['phone']); ?>"
required>
</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Address

</label>

<textarea
name="address"
class="form-control"
rows="3"
required><?= htmlspecialchars($patient['address']); ?></textarea>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Blood Group

</label>

<select
name="blood_group"
class="form-select"
required>

<?php

$bloodGroups = [
"A+","A-",
"B+","B-",
"AB+","AB-",
"O+","O-"
];

foreach($bloodGroups as $bg){

?>

<option
value="<?= $bg; ?>"
<?= $patient['blood_group']==$bg ? "selected" : ""; ?>>

<?= $bg; ?>

</option>

<?php

}

?>

</select>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="view_patients.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
name="update"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update Patient

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>