<?php
session_start();
require '../include/db_con.php'; // Database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        .container {
            margin-top: 50px;
        }
        .nav-sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .main-content {
            margin-left: 270px; /* Adjust based on your sidebar width */
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <?php include 'include/admin_top_nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Left Sidebar -->
            <?php include 'include/left_side.php'; ?>
            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="row">
                    <!-- Card 1: View Card 1 -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">View Record</h5>
                                <p class="card-text"><a class="nav-link" href="view_record.php">View All Records</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
