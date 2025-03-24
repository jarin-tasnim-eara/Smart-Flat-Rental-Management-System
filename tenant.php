<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require 'dbconnect.php';

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $con->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tenant Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('https://plus.unsplash.com/premium_photo-1683141219653-fc199f8ae98f?q=80&w=2021&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center/cover;
            min-height: 100vh;
        }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">AURORA Properties</a>
            <div class="ml-auto">
                <span class="text-white mr-3">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                <a href="logout.php" class="btn btn-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="dashboard-card p-4">
            <h2 class="mb-4">Tenant Dashboard</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">My Profile</h5>
                            <p class="card-text">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">My Applications</h5>
                            <p class="card-text">View your rental applications</p>
                            <a href="applications.php" class="btn btn-primary">View Applications</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment History</h5>
                            <p class="card-text">View your payment records</p>
                            <a href="payments.php" class="btn btn-primary">View Payments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
