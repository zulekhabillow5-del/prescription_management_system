<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Prescription Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    margin:0;
    background:#f4f7fc;
    overflow-x:hidden;
    font-family:Arial, Helvetica, sans-serif;
}

.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(180deg,#0d6efd,#0046c7);
    display:flex;
    flex-direction:column;
}

.sidebar .nav-link{
    color:#fff;
    padding:14px 20px;
    margin:3px 10px;
    border-radius:10px;
    transition:.3s;
    text-decoration:none;
}

.sidebar .nav-link:hover{
    background:rgba(255,255,255,.18);
    color:#fff;
}

.content{
    flex:1;
    padding:30px;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 .3rem .8rem rgba(0,0,0,.08);
}

.btn{
    border-radius:10px;
}

.table th{
    background:#f8f9fa;
}

.footer{
    background:#0d6efd;
    color:#fff;
    text-align:center;
    padding:15px;
    margin-top:40px;
}

.topbar{
    background:#fff;
    padding:18px 25px;
    border-radius:15px;
    margin-bottom:25px;
    box-shadow:0 .3rem .8rem rgba(0,0,0,.08);
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>