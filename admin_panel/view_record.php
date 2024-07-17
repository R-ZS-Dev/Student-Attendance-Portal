<?php
session_start();
require '../include/db_con.php'; // Database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Fetching attendance records
$sql_attendance = "SELECT id, f_name, l_name, email, created_at FROM attendance";
$result_attendance = $conn->query($sql_attendance);
$attendance_records = [];
if ($result_attendance->num_rows > 0) {
    while ($row = $result_attendance->fetch_assoc()) {
        $row['status'] = 'Present';
        $attendance_records[$row['email']] = $row;
    }
}

// Fetching leave records
$sql_leaves = "SELECT id, f_name, l_name, email, created_at FROM leaves";
$result_leaves = $conn->query($sql_leaves);
$leave_records = [];
if ($result_leaves->num_rows > 0) {
    while ($row = $result_leaves->fetch_assoc()) {
        $row['status'] = 'Leave';
        $leave_records[$row['email']] = $row;
    }
}

// Merge records for display, avoiding duplicates by email
$students = [];
foreach ($attendance_records as $email => $attendance) {
    if (!isset($students[$email])) {
        $students[$email] = [
            'id' => $attendance['id'],
            'f_name' => $attendance['f_name'],
            'l_name' => $attendance['l_name'],
            'email' => $attendance['email'],
            'status' => 'Present',
            'created_at' => $attendance['created_at'],
            'total_presence' => 1,
            'total_absence' => 0
        ];
    } else {
        $students[$email]['total_presence']++;
    }
}

foreach ($leave_records as $email => $leave) {
    if (!isset($students[$email])) {
        $students[$email] = [
            'id' => $leave['id'],
            'f_name' => $leave['f_name'],
            'l_name' => $leave['l_name'],
            'email' => $leave['email'],
            'status' => 'Leave',
            'created_at' => $leave['created_at'],
            'total_presence' => 0,
            'total_absence' => 1
        ];
    } else {
        $students[$email]['status'] = 'Leave'; // If present record already exists, mark as leave
        $students[$email]['total_absence']++;
    }
}

// Add grades to students
foreach ($students as $email => $student) {
    $students[$email]['grade'] = calculate_grade($student['total_presence']);
}

// Close database connection
$conn->close();

function calculate_grade($total_presence) {
    if ($total_presence >= 26) {
        return 'A';
    } elseif ($total_presence >= 20) {
        return 'B';
    } elseif ($total_presence >= 15) {
        return 'C';
    } elseif ($total_presence >= 10) {
        return 'D';
    } else {
        return 'F';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style type="text/css">
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
    <!-- Navigation Bar -->
    <?php include 'include/admin_top_nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Left Sidebar -->
            <?php include 'include/left_side.php'; ?>
            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="container mt-4">
                    <h2 class="mb-4">View Records</h2>
                    <div class="table-responsive">
                        <table id="recordsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Total Presence</th>
                                    <th>Total Absence</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?php echo $student['id']; ?></td>
                                        <td><?php echo $student['f_name']; ?></td>
                                        <td><?php echo $student['l_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['total_presence']; ?></td>
                                        <td><?php echo $student['total_absence']; ?></td>
                                        <td><?php echo $student['grade']; ?></td>
                                        <td>
                                            <a href="view_student_record.php?email=<?php echo urlencode($student['email']); ?>" class="btn btn-primary btn-sm">View Record</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#recordsTable').DataTable();
        });
    </script>
</body>
</html>
