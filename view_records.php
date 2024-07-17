<?php
session_start();
require 'include/db_con.php'; // Database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch total presents
$sql_presents = "SELECT COUNT(*) AS total_presents FROM attendance WHERE email = '$email' AND status = 'present'";
$result_presents = $conn->query($sql_presents);
$total_presents = $result_presents->fetch_assoc()['total_presents'];

// Fetch total leaves
$sql_leaves = "SELECT COUNT(*) AS total_leaves FROM leaves WHERE email = '$email'";
$result_leaves = $conn->query($sql_leaves);
$total_leaves = $result_leaves->fetch_assoc()['total_leaves'];

// Fetch all attendance records
$sql_attendance = "SELECT created_at, status FROM attendance WHERE email = '$email' ORDER BY created_at DESC";
$result_attendance = $conn->query($sql_attendance);

// Fetch all leave records
$sql_leave_records = "SELECT from_date, to_date, leave_reason FROM leaves WHERE email = '$email' ORDER BY from_date DESC";
$result_leave_records = $conn->query($sql_leave_records);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Attendance and Leave Records</h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Presents</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_presents; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Leaves</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_leaves; ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <h3>Attendance Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_attendance->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Leave Records</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_leave_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['from_date']; ?></td>
                        <td><?php echo $row['to_date']; ?></td>
                        <td><?php echo $row['leave_reason']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
