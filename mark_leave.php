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

$error = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_reason = $_POST['leave_reason'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $created_at = date("Y-m-d H:i:s");

    // Validate input
    if (empty($leave_reason) || empty($from_date) || empty($to_date)) {
        $error = "All fields are required.";
    } else {
        // Insert leave application into database
        $sql = "INSERT INTO leaves (email, f_name, l_name, leave_reason, from_date, to_date, created_at) VALUES ('$email', '$f_name', '$l_name', '$leave_reason', '$from_date', '$to_date', '$created_at')";

        if ($conn->query($sql) === TRUE) {
            $message = "Leave application submitted successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'include/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Apply for Leave</h2>
        <h4 class="text-center">Welcome, <?php echo $f_name . ' ' . $l_name; ?></h4>
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
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="from_date">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="to_date">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                </div>
            </div>
            <div class="form-group">
                <label for="leave_reason">Leave Reason</label>
                <textarea class="form-control" id="leave_reason" name="leave_reason" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Apply for Leave</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
