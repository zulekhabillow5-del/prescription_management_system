<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Edit Profile";

$doctor_id = $_SESSION['doctor_id'];

$result = mysqli_query($conn, "SELECT * FROM doctors WHERE doctor_id='$doctor_id'");

if (!$result || mysqli_num_rows($result) == 0) {
    die("Doctor not found.");
}

$doctor = mysqli_fetch_assoc($result);

$success = "";
$error = "";

if (isset($_POST['update'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $license_number = mysqli_real_escape_string($conn, $_POST['license_number']);

    $update = mysqli_query($conn,"
        UPDATE doctors SET
        full_name='$full_name',
        email='$email',
        phone='$phone',
        specialization='$specialization',
        license_number='$license_number'
        WHERE doctor_id='$doctor_id'
    ");

    if($update){

        $_SESSION['doctor_name'] = $full_name;

        header("Location: settings.php?success=profile_updated");
        exit();

    }else{

        $error = "Failed to update profile.";

    }

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>
<?php
if(isset($_GET['success']) && $_GET['success']=="profile_updated"){
    echo '<div class="container-fluid mt-3">
            <div class="alert alert-success alert-dismissible fade show">
                Profile updated successfully.
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>';
}
?>
<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-person-lines-fill"></i>

Edit Profile

</h4>

</div>

<div class="card-body">

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Full Name</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?= htmlspecialchars($doctor['full_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($doctor['email']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($doctor['phone']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Specialization</label>

<input
type="text"
name="specialization"
class="form-control"
value="<?= htmlspecialchars($doctor['specialization']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">License Number</label>

<input
type="text"
name="license_number"
class="form-control"
value="<?= htmlspecialchars($doctor['license_number']); ?>">

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="settings.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
name="update"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update Profile

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>
