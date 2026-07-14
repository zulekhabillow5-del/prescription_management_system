<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "New Prescription";

$patients = mysqli_query($conn, "SELECT patient_id, full_name FROM patients ORDER BY full_name ASC");

$medicines = mysqli_query($conn, "SELECT medicine_id, name, strength FROM medicines ORDER BY name ASC");

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-file-earmark-medical"></i>

Create New Prescription

</h4>

</div>

<div class="card-body">

<form action="save_prescription.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-bold">

Patient

</label>

<select name="patient_id" class="form-select" required>

<option value="">Select Patient</option>

<?php while($patient = mysqli_fetch_assoc($patients)){ ?>

<option value="<?= $patient['patient_id']; ?>">

<?= htmlspecialchars($patient['full_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-bold">

Prescription Date

</label>

<input
type="date"
name="prescription_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label fw-bold">

Diagnosis

</label>

<textarea
name="diagnosis"
class="form-control"
rows="3"
required></textarea>

</div>

<div class="mb-4">

<label class="form-label fw-bold">

Doctor Notes

</label>

<textarea
name="notes"
class="form-control"
rows="3"></textarea>

</div>

<hr>

<h5 class="fw-bold text-primary mb-3">

<i class="bi bi-capsule-pill"></i>

Medicines

</h5>

<table class="table table-bordered" id="medicineTable">

<thead class="table-primary">

<tr>

<th width="25%">Medicine</th>

<th>Dosage</th>

<th>Frequency</th>

<th>Duration</th>

<th>Instructions</th>

<th width="8%">Action</th>

</tr>

</thead>

<tbody>

<tr>

<td>

<select
name="medicine_id[]"
class="form-select"
required>

<option value="">Select Medicine</option>

<?php
mysqli_data_seek($medicines,0);

while($medicine=mysqli_fetch_assoc($medicines)){
?>

<option value="<?= $medicine['medicine_id']; ?>">

<?= htmlspecialchars($medicine['name']); ?>

<?= htmlspecialchars($medicine['strength']); ?>

</option>

<?php } ?>

</select>

</td>

<td>

<input
type="text"
name="dosage[]"
class="form-control"
placeholder="500 mg"
required>

</td>

<td>

<select
name="frequency[]"
class="form-select"
required>

<option>Once Daily</option>

<option>Twice Daily</option>

<option>Three Times Daily</option>

<option>Every 6 Hours</option>

<option>Every 8 Hours</option>

<option>Every 12 Hours</option>

<option>As Needed</option>

</select>

</td>

<td>

<input
type="text"
name="duration[]"
class="form-control"
placeholder="7 Days"
required>

</td>

<td>

<input
type="text"
name="instructions[]"
class="form-control"
placeholder="After meals">

</td>

<td class="text-center">

<button
type="button"
class="btn btn-danger removeRow">

<i class="bi bi-trash"></i>

</button>

</td>

</tr>

</tbody>

</table>

<button
type="button"
id="addMedicine"
class="btn btn-success">

<i class="bi bi-plus-circle"></i>

Add Another Medicine

</button>

<hr class="my-4">
<div class="d-flex justify-content-between">

    <button
        type="button"
        id="addMedicine"
        class="btn btn-success">

        <i class="bi bi-plus-circle"></i>
        Add Another Medicine

    </button>

    <button
        type="submit"
        class="btn btn-primary">

        <i class="bi bi-save"></i>
        Save Prescription

    </button>

</div>

</form>

</div>

</div>

</div>

<script>

const medicineTable = document.querySelector("#medicineTable tbody");

document.getElementById("addMedicine").addEventListener("click", function(){

let row = medicineTable.rows[0].cloneNode(true);

row.querySelectorAll("input").forEach(function(input){

input.value = "";

});

row.querySelectorAll("select").forEach(function(select){

select.selectedIndex = 0;

});

medicineTable.appendChild(row);

});

document.addEventListener("click", function(e){

if(e.target.closest(".removeRow")){

if(medicineTable.rows.length > 1){

e.target.closest("tr").remove();

}else{

alert("At least one medicine is required.");

}

}

});

</script>

<?php include "includes/footer.php"; ?>