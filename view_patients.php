<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

// Search
$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM patients
            WHERE full_name LIKE '%$search%'
            OR phone LIKE '%$search%'
            ORDER BY patient_id DESC";

} else {

    $sql = "SELECT * FROM patients
            ORDER BY patient_id DESC";
}

$result = mysqli_query($conn, $sql);

// Count Patients
$totalPatients = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients")
)['total'];

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            <i class="bi bi-people-fill text-primary"></i>
            Patients
        </h2>

        <p class="text-muted mb-0">
            Manage all registered patients.
        </p>

    </div>

    <a href="add_patient.php" class="btn btn-primary">

        <i class="bi bi-person-plus-fill"></i>

        Add Patient

    </a>

</div>

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success alert-dismissible fade show">

<?php

if($_GET['success']=="added"){
    echo "Patient added successfully.";
}
elseif($_GET['success']=="updated"){
    echo "Patient updated successfully.";
}
elseif($_GET['success']=="deleted"){
    echo "Patient deleted successfully.";
}

?>

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<div class="row mb-4">

<div class="col-lg-3">

<div class="card shadow-sm border-0">

<div class="card-body text-center">

<i class="bi bi-people-fill text-primary" style="font-size:45px;"></i>

<h2 class="mt-2"><?= $totalPatients ?></h2>

<p class="text-muted mb-0">

Total Patients

</p>

</div>

</div>

</div>

<div class="col-lg-9">

<div class="card shadow-sm border-0">

<div class="card-body">

<form method="GET">

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-search"></i>

</span>

<input
type="text"
name="search"
class="form-control"
placeholder="Search patient by name or phone..."
value="<?= htmlspecialchars($search); ?>">

<button class="btn btn-primary">

Search

</button>

</div>

</form>

</div>

</div>

</div>

</div>

<div class="card shadow-sm border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

<i class="bi bi-list-ul"></i>

Registered Patients

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Full Name</th>

<th>Gender</th>

<th>Phone</th>

<th>Blood Group</th>

<th>Date Registered</th>

<th class="text-nowrap">Actions</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= $row['patient_id']; ?></td>

<td><?= htmlspecialchars($row['full_name']); ?></td>

<td><?= $row['gender']; ?></td>

<td><?= htmlspecialchars($row['phone']); ?></td>

<td><?= htmlspecialchars($row['blood_group']); ?></td>

<td><?= date("d M Y", strtotime($row['created_at'])); ?></td>

<td class="text-nowrap">

<a href="patient_details.php?id=<?= $row['patient_id']; ?>"
class="btn btn-info btn-sm"
title="View">

<i class="bi bi-eye-fill"></i>

</a>

<a href="edit_patient.php?id=<?= $row['patient_id']; ?>"
class="btn btn-warning btn-sm"
title="Edit">

<i class="bi bi-pencil-fill"></i>

</a>

<a href="delete_patient.php?id=<?= $row['patient_id']; ?>"
class="btn btn-danger btn-sm"
title="Delete"
onclick="return confirm('Are you sure you want to delete this patient?');">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="text-center py-5">

<i class="bi bi-person-x-fill text-secondary" style="font-size:60px;"></i>

<h5 class="mt-3">

No patients found.

</h5>

<p class="text-muted">

Click the button below to register your first patient.

</p>

<a href="add_patient.php" class="btn btn-primary">

<i class="bi bi-person-plus-fill"></i>

Add First Patient

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>