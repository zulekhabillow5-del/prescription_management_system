<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Add Medicine";

if(isset($_POST['save'])){

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
INSERT INTO medicines
(
name,
generic_name,
form,
strength,
manufacturer,
stock_quantity,
unit_price,
expiry_date,
batch_number,
supplier
)
VALUES
(
'$name',
'$generic_name',
'$form',
'$strength',
'$manufacturer',
'$stock_quantity',
'$unit_price',
'$expiry_date',
'$batch_number',
'$supplier'
)
");

header("Location:view_medicines.php?success=added");
exit();

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-success text-white">

<h4 class="mb-0">

<i class="bi bi-capsule-pill"></i>

Add Medicine

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
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Generic Name

</label>

<input
type="text"
name="generic_name"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Form

</label>

<select
name="form"
class="form-select"
required>

<option>Tablet</option>
<option>Capsule</option>
<option>Syrup</option>
<option>Injection</option>
<option>Cream</option>
<option>Ointment</option>
<option>Drops</option>
<option>Suspension</option>

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
placeholder="500 mg">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Manufacturer

</label>

<input
type="text"
name="manufacturer"
class="form-control">

</div>
</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Stock Quantity

</label>

<input
type="number"
name="stock_quantity"
class="form-control"
value="0"
min="0"
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
value="0.00"
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
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Batch Number

</label>

<input
type="text"
name="batch_number"
class="form-control"
placeholder="e.g. BATCH-2026-001">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Supplier

</label>

<input
type="text"
name="supplier"
class="form-control"
placeholder="Supplier Name">

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
name="save"
class="btn btn-success">

<i class="bi bi-save"></i>

Save Medicine

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>