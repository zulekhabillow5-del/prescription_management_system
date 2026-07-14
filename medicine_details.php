<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Medicine Details";

if (!isset($_GET['id'])) {
    header("Location: view_medicines.php");
    exit();
}

$medicine_id = intval($_GET['id']);

$result = mysqli_query($conn,"
SELECT *
FROM medicines
WHERE medicine_id='$medicine_id'
");

if(mysqli_num_rows($result)==0){
    die("Medicine not found.");
}

$medicine = mysqli_fetch_assoc($result);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-success text-white">

<h4 class="mb-0">

<i class="bi bi-capsule-pill"></i>

Medicine Details

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Medicine Name

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['name']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Generic Name

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['generic_name']); ?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Form

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['form']); ?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Strength

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['strength']); ?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Manufacturer

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['manufacturer']); ?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Stock Quantity

</label>

<div class="form-control bg-light">

<?php

if($medicine['stock_quantity']<=10){

echo '<span class="badge bg-danger">'.$medicine['stock_quantity'].' (Low Stock)</span>';

}else{

echo '<span class="badge bg-success">'.$medicine['stock_quantity'].' Available</span>';

}

?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Unit Price

</label>

<div class="form-control bg-light">

KSh <?= number_format($medicine['unit_price'],2); ?>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="fw-bold text-muted">

Expiry Date

</label>

<div class="form-control bg-light">

<?php

if(!empty($medicine['expiry_date'])){

if(strtotime($medicine['expiry_date']) < time()){

echo '<span class="badge bg-danger">Expired</span> ';
}

echo date("d M Y",strtotime($medicine['expiry_date']));

}else{

echo "N/A";

}

?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Batch Number

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['batch_number']); ?>

</div>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold text-muted">

Supplier

</label>

<div class="form-control bg-light">

<?= htmlspecialchars($medicine['supplier']); ?>

</div>

</div>

<div class="col-md-12 mb-3">

<label class="fw-bold text-muted">

Date Added

</label>

<div class="form-control bg-light">

<?= date("d M Y",strtotime($medicine['created_at'])); ?>

</div>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="view_medicines.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<div>

<a href="edit_medicine.php?id=<?= $medicine['medicine_id']; ?>" class="btn btn-warning">

<i class="bi bi-pencil"></i>

Edit

</a>

<a href="delete_medicine.php?id=<?= $medicine['medicine_id']; ?>"
class="btn btn-danger"
onclick="return confirm('Delete this medicine?');">

<i class="bi bi-trash"></i>

Delete

</a>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>