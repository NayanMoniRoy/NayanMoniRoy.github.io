<?php
session_start();
include 'db_connect.php';

/* 🔒 Protect page */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Get user info */
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

/* If user not found */
if(!$user){
    die("User not found!");
}

/* REAL TIME COUNTS FROM DATABASE */

/* Lost items count */
$sql1 = "SELECT COUNT(*) AS total FROM lost_items";
$result1 = mysqli_query($conn, $sql1);
$lost_count = mysqli_fetch_assoc($result1)['total'];

/* Found items count */
$sql2 = "SELECT COUNT(*) AS total FROM found_items";
$result2 = mysqli_query($conn, $sql2);
$found_count = mysqli_fetch_assoc($result2)['total'];

/* Study groups count */
$sql3 = "SELECT COUNT(*) AS total FROM study_groups";
$result3 = mysqli_query($conn, $sql3);
$group_count = mysqli_fetch_assoc($result3)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CampusConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }

        .card-box{
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .card-box:hover{
            transform: translateY(-5px);
        }

        .stat{
            font-size:28px;
            font-weight:bold;
        }

        .welcome{
            background: linear-gradient(135deg,#0d6efd,#6610f2);
            color:white;
            padding:20px;
            border-radius:15px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">CampusConnect</a>

    <div class="ms-auto">
        <a href="profile.php" class="btn btn-light btn-sm">Profile</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">

    <!-- WELCOME -->
    <div class="welcome mb-4">
        <h3>Welcome, <?= htmlspecialchars($user['name']) ?> 👋</h3>
        <p>Manage Lost & Found items and Study Groups from your dashboard.</p>
    </div>

    <!-- STATS -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card card-box p-3 text-center">
                <h5>Lost Items</h5>
                <div class="stat text-danger"><?= $lost_count ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box p-3 text-center">
                <h5>Found Items</h5>
                <div class="stat text-success"><?= $found_count ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box p-3 text-center">
                <h5>Study Groups</h5>
                <div class="stat text-primary"><?= $group_count ?></div>
            </div>
        </div>

    </div>

    <!-- MENU -->
    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card card-box p-4 text-center">
                <h5>Lost & Found</h5>
                <p>Report and search lost items</p>
                <a href="lostAndfound.php" class="btn btn-danger">Open</a>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card card-box p-4 text-center">
                <h5>Study Groups</h5>
                <p>Create or join study groups</p>
                <a href="study_groups.php" class="btn btn-primary">Open</a>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card card-box p-4 text-center">
                <h5>My Profile</h5>
                <p>View and edit your profile</p>
                <a href="profile.php" class="btn btn-success">Open</a>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

