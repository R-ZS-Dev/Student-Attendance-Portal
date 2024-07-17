<?php include 'include/db_con.php'; ?>
<?php
    session_start();

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
    <title>Attendance Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="include/css/bootstrap.css">
</head>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container mt-5">
        <div class="form-container">
            <h2 class="form-heading text-center">Attendance Portal Dashboard</h2>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card text-center border-primary">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Mark Attendance</h5>
                            <p class="card-text">Mark your daily attendance here.</p>
                            <a href="mark_attendance.php" class="btn btn-primary">Mark Attendance</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h5 class="card-title text-success">Apply Leave</h5>
                            <p class="card-text">Submit your leave request here.</p>
                            <a href="mark_leave.php" class="btn btn-success">Apply Leave</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-info">
                        <div class="card-body">
                            <h5 class="card-title text-info">View Record</h5>
                            <p class="card-text">View your attendance and leave records.</p>
                            <a href="view_records.php" class="btn btn-info">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
