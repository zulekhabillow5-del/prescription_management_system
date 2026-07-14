<?php
session_start();
require_once "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM doctors WHERE username = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $doctor = mysqli_fetch_assoc($result);

        if (password_verify($password, $doctor['password'])) {

            $_SESSION['doctor_id'] = $doctor['doctor_id'];
            $_SESSION['doctor_name'] = $doctor['full_name'];

            header("Location: index.php");
            exit();

        } else {
            $error = "Invalid username or password.";
        }

    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Doctor Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f8fb;
}

.login-card{

    max-width:420px;
    margin:80px auto;
    border:none;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,.1);

}

.logo{

    font-size:60px;
    color:#0d6efd;

}

</style>

</head>

<body>

<div class="container">

<div class="card login-card">

<div class="card-body p-5">

<div class="text-center mb-4">

<i class="bi bi-hospital logo"></i>

<h3 class="mt-3">Prescription Management System</h3>

<p class="text-muted">Doctor Login</p>

</div>

<?php if($error!=""): ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button class="btn btn-primary w-100">

<i class="bi bi-box-arrow-in-right"></i>

Login

</button>

</form>

</div>

</div>

</div>

</body>

</html>