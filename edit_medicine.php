<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Edit Medicine";

if(!isset($_GET['id'])){
    header("Location:view_medicines.php");
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

if(isset($_POST['update'])){

$name = mysqli_real_escape_string($conn,$_POST['name']);
$generic_name = mysqli_real_escape_string($conn,$_POST['generic_name']);
$form = mysqli_real_escape_string($conn,$_POST['form']);
$strength = mysqli_real_escape_string($conn,$_POST['strength']);
$manufacturer = mysqli_real_escape_string($conn,$_POST['manufacturer']);
$stock_quantity = intval($_POST['stock_quantity']);
$unit_price = $_POST['unit_price'];
$expiry_date = $_POST['expiry_date'];
$batch_number = mysqli_real_escape_string($conn,$_POST['batch_number']);
$supplier = mysqli_real_escape_string($conn,$_POST['supplier']);

mysqli_query($conn,"
UPDATE medicines SET

name='$name',
generic_name='$generic_name',
form='$form',
strength='$strength',
manufacturer='$manufacturer',
stock_quantity='$stock_quantity',
unit_price='$unit_price',
expiry_date='$expiry_date',
batch_number='$batch_number',
supplier='$supplier'

WHERE medicine_id='$medicine_id'
");

header("Location:view_medicines.php?success=updated");
exit();

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h4 class="mb-0">

<i class="bi bi-pencil-square"></i>

Edit Medicine

</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Medicine Name

</label>

<input
type="text"
name="name"
class="form-control"
value="<?= htmlspecialchars($medicine['name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Generic Name

</label>

<input
type="text"
name="generic_name"
class="form-control"
value="<?= htmlspecialchars($medicine['generic_name']); ?>">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Form

</label>

<select
name="form"
class="form-select"
required>

<?php

$forms=[
"Tablet",
"Capsule",
"Syrup",
"Injection",
"Cream",
"Ointment",
"Drops",
"Suspension"
];

foreach($forms as $f){

?>

<option
value="<?= $f;?>"
<?= $medicine['form']==$f ? "selected":"";?>>

<?= $f;?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Strength

</label>

<input
type="text"
name="strength"
class="form-control"
value="<?= htmlspecialchars($medicine['strength']); ?>">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Manufacturer

</label>

<input
type="text"
name="manufacturer"
class="form-control"
value="<?= htmlspecialchars($medicine['manufacturer']); ?>">
</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Stock Quantity

</label>

<input
type="number"
name="stock_quantity"
class="form-control"
min="0"
value="<?= $medicine['stock_quantity']; ?>"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Unit Price

</label>

<div class="input-group">

<span class="input-group-text">KSh</span>

<input
type="number"
name="unit_price"
class="form-control"
step="0.01"
min="0"
value="<?= $medicine['unit_price']; ?>"
required>

</div>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Expiry Date

</label>

<input
type="date"
name="expiry_date"
class="form-control"
value="<?= $medicine['expiry_date']; ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Batch Number

</label>

<input
type="text"
name="batch_number"
class="form-control"
value="<?= htmlspecialchars($medicine['batch_number']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Supplier

</label>

<input
type="text"
name="supplier"
class="form-control"
value="<?= htmlspecialchars($medicine['supplier']); ?>">

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="view_medicines.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
type="submit"
name="update"
class="btn btn-warning">

<i class="bi bi-save"></i>

Update Medicine

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>