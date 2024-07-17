<?php
session_start();
require 'include/db_con.php'; // Database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$f_name = $_SESSION['f_name'];
$l_name = $_SESSION['l_name'];
$attendanceMarked = false;

// Check if the user has already marked attendance for today
$today = date("Y-m-d");
$checkAttendanceSql = "SELECT * FROM attendance WHERE email='$email' AND DATE(created_at) = '$today'";
$attendanceResult = $conn->query($checkAttendanceSql);

if ($attendanceResult->num_rows > 0) {
    $attendanceMarked = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$attendanceMarked) {
    $status = "Present";
    $created_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO attendance (email, f_name, l_name, status, created_at) VALUES ('$email', '$f_name', '$l_name', '$status', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        $message = "Attendance marked successfully";
        $attendanceMarked = true; // Update the flag to disable the button
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'include/header.php'; ?>
    <div class="container mt-5">
        <h4 class="text-center">Welcome, <?php echo $f_name . ' ' . $l_name; ?></h4>
        <h2 class="text-center">Please Mark Your Today Attendance</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="Present" readonly>
            </div>
            <button type="submit" class="btn btn-primary btn-block" <?php if ($attendanceMarked) echo 'disabled'; ?>>Mark Attendance</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
