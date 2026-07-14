<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$pageTitle = "Pharmacy";

$search = "";

$sql = "SELECT * FROM medicines";

if(isset($_GET['search']) && $_GET['search'] != ""){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $sql .= " WHERE
                name LIKE '%$search%'
                OR generic_name LIKE '%$search%'
                OR supplier LIKE '%$search%'";
}

$sql .= " ORDER BY name ASC";

$result = mysqli_query($conn,$sql);

$totalMedicines = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM medicines")
)['total'];

$totalStock = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT SUM(stock_quantity) total FROM medicines")
)['total'];

$lowStock = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM medicines WHERE stock_quantity <=10")
)['total'];

$expired = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM medicines
WHERE expiry_date IS NOT NULL
AND expiry_date<CURDATE()")
)['total'];

include "includes/header.php";
include "includes/sidebar.php";
include "includes/topbar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-capsule-pill text-success"></i>

Pharmacy

</h2>

<p class="text-muted">

Manage medicines and inventory.

</p>

</div>

<a href="add_medicine.php" class="btn btn-success">

<i class="bi bi-plus-circle"></i>

Add Medicine

</a>

</div>
<div class="row g-3 mb-4">

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-capsule-pill text-success fs-1"></i>

<h3><?= $totalMedicines ?></h3>

<p class="mb-0">Medicines</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-box-seam text-primary fs-1"></i>

<h3><?= $totalStock ?: 0 ?></h3>

<p class="mb-0">Total Stock</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-exclamation-triangle text-warning fs-1"></i>

<h3><?= $lowStock ?></h3>

<p class="mb-0">Low Stock</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<i class="bi bi-calendar-x text-danger fs-1"></i>

<h3><?= $expired ?></h3>

<p class="mb-0">Expired</p>

</div>

</div>

</div>

</div>
<div class="card shadow border-0">

<div class="card-body">

<form method="GET">

<div class="row g-2">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by medicine, generic name or supplier..."
value="<?= htmlspecialchars($search); ?>">

</div>

<div class="col-md-2 d-grid">

<button class="btn btn-success">

<i class="bi bi-search"></i>

Search

</button>

</div>

</div>

</form>

</div>

</div>

<div class="card shadow border-0 mt-4">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

<i class="bi bi-list-ul"></i>

Medicine Inventory

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-success">

<tr>

<th>ID</th>

<th>Medicine</th>

<th>Form</th>

<th>Strength</th>

<th>Stock</th>

<th>Expiry</th>

<th>Price</th>

<th width="170">

Actions

</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?= $row['medicine_id']; ?>

</td>

<td>

<strong><?= htmlspecialchars($row['name']); ?></strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['generic_name']); ?>

</small>

</td>

<td>

<?= htmlspecialchars($row['form']); ?>

</td>

<td>

<?= htmlspecialchars($row['strength']); ?>

</td>

<td>

<?php

if($row['stock_quantity']<=10){

echo '<span class="badge bg-danger">'.$row['stock_quantity'].'</span>';

}else{

echo '<span class="badge bg-success">'.$row['stock_quantity'].'</span>';

}

?>

</td>

<td>

<?php

if(!empty($row['expiry_date'])){

if(strtotime($row['expiry_date'])<time()){

echo '<span class="badge bg-danger">'.
date("d M Y",strtotime($row['expiry_date'])).
'</span>';

}else{

echo date("d M Y",strtotime($row['expiry_date']));

}

}else{

echo "-";

}

?>

</td>

<td>

KSh <?= number_format($row['unit_price'],2); ?>

</td>

<td>

<a
href="medicine_details.php?id=<?= $row['medicine_id']; ?>"
class="btn btn-info btn-sm"
title="View">

<i class="bi bi-eye"></i>

</a>

<a
href="edit_medicine.php?id=<?= $row['medicine_id']; ?>"
class="btn btn-warning btn-sm"
title="Edit">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete_medicine.php?id=<?= $row['medicine_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this medicine?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="8" class="text-center py-5">

<i class="bi bi-capsule fs-1 text-secondary"></i>

<h5 class="mt-3">

No medicines found.

</h5>

<a
href="add_medicine.php"
class="btn btn-success mt-3">

<i class="bi bi-plus-circle"></i>

Add First Medicine

</a>

</td>

</tr>

<?php

}

?>
</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>