<?php
session_start();
require '../include/db_con.php'; // Database connection file

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$f_name = $l_name = $email = '';
$attendance_records = $leave_records = [];

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Fetch student details
    $stmt = $conn->prepare("SELECT f_name, l_name, email FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_student = $stmt->get_result();

    if ($result_student->num_rows > 0) {
        $student_info = $result_student->fetch_assoc();
        $f_name = $student_info['f_name'];
        $l_name = $student_info['l_name'];
        $email = $student_info['email'];

        // Fetch attendance records for the student based on email
        $stmt_attendance = $conn->prepare("SELECT * FROM attendance WHERE email = ?");
        $stmt_attendance->bind_param("s", $email);
        $stmt_attendance->execute();
        $result_attendance = $stmt_attendance->get_result();
        if ($result_attendance->num_rows > 0) {
            while ($row = $result_attendance->fetch_assoc()) {
                $attendance_records[] = $row;
            }
        }

        // Fetch leave records for the student based on email
        $stmt_leaves = $conn->prepare("SELECT * FROM leaves WHERE email = ?");
        $stmt_leaves->bind_param("s", $email);
        $stmt_leaves->execute();
        $result_leaves = $stmt_leaves->get_result();
        if ($result_leaves->num_rows > 0) {
            while ($row = $result_leaves->fetch_assoc()) {
                $leave_records[] = $row;
            }
        }
    } else {
        echo "No student found with the provided email.";
        exit();
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}

// Close database connections
$stmt->close();
$stmt_attendance->close();
$stmt_leaves->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Record</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <h2 class="mb-4">Student Record</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Student Information</h4>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>First Name:</th>
                                        <td><?php echo htmlspecialchars($f_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name:</th>
                                        <td><?php echo htmlspecialchars($l_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo htmlspecialchars($email); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form id="filterForm" class="mt-4">
                        <div class="form-row">
                            <div class="col">
                                <label for="startDate">From Date:</label>
                                <input type="date" class="form-control" id="startDate" name="start_date">
                            </div>
                            <div class="col">
                                <label for="endDate">To Date:</label>
                                <input type="date" class="form-control" id="endDate" name="end_date">
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary mt-4" onclick="filterRecords()">Filter</button>
                                <button type="button" class="btn btn-secondary mt-4" onclick="printRecords()">Print</button>
                            </div>
                        </div>
                        <input type="hidden" id="hiddenStartDate" name="hidden_start_date">
                        <input type="hidden" id="hiddenEndDate" name="hidden_end_date">
                    </form>

                    <div id="attendanceRecords" class="mt-4">
                        <?php if (!empty($attendance_records)): ?>
                            <h4>Attendance Records</h4>
                            <table id="attendanceTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($attendance_records as $attendance): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($attendance['updated_at']); ?></td>
                                            <td>Present</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>

                    <div id="leaveRecords" class="mt-4">
                        <?php if (!empty($leave_records)): ?>
                        <h4>Leave Records</h4>
                        <table id="leaveTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leave_records as $leave): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($leave['from_date']); ?></td>
                                        <td><?php echo htmlspecialchars($leave['to_date']); ?></td>
                                        <td><?php echo htmlspecialchars($leave['leave_reason']); ?></td>
                                        <td>
                                            <select class="status-dropdown" data-id="<?php echo $leave['id']; ?>">
                                                <option value="Pending" <?php echo $leave['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Approved" <?php echo $leave['status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                                <option value="Rejected" <?php echo $leave['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
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
            $('#attendanceTable').DataTable();
            $('#leaveTable').DataTable();
        });

       function filterRecords() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        
        if (startDate && endDate) {
            $('#hiddenStartDate').val(startDate);
            $('#hiddenEndDate').val(endDate);
            
            $.ajax({
                url: 'filter_records.php',
                type: 'GET',
                data: {
                    email: '<?php echo $email; ?>',
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    var attendanceHtml = '<h4>Attendance Records</h4><table id="attendanceTable" class="table table-striped table-bordered"><thead><tr><th>Date</th><th>Status</th></tr></thead><tbody>';
                    data.attendance.forEach(function(record) {
                        attendanceHtml += '<tr><td>' + record.updated_at + '</td><td>Present</td></tr>';
                    });
                    attendanceHtml += '</tbody></table>';

                    var leaveHtml = '<h4>Leave Records</h4><table id="leaveTable" class="table table-striped table-bordered"><thead><tr><th>From Date</th><th>To Date</th><th>Reason</th></tr></thead><tbody>';
                    data.leaves.forEach(function(record) {
                        leaveHtml += '<tr><td>' + record.from_date + '</td><td>' + record.to_date + '</td><td>' + record.leave_reason + '</td></tr>';
                    });
                    leaveHtml += '</tbody></table>';

                    $('#attendanceRecords').html(attendanceHtml);
                    $('#leaveRecords').html(leaveHtml);

                    $('#attendanceTable').DataTable();
                    $('#leaveTable').DataTable();
                }
            });
        } else {
            alert('Please select both start and end dates.');
        }
    }

    function printRecords() {
        var startDate = $('#hiddenStartDate').val();
        var endDate = $('#hiddenEndDate').val();
        if (startDate && endDate) {
            var email = '<?php echo $email; ?>';
            window.open('print_records.php?email=' + email + '&start_date=' + startDate + '&end_date=' + endDate, '_blank');
        } else {
            alert('Please filter records before printing.');
        }
    }


        function printRecords() {
            window.print();
        }
    </script>
    <script>
    $(document).ready(function() {
        $('#attendanceTable').DataTable();
        $('#leaveTable').DataTable();
        
        $('.status-dropdown').on('change', function() {
            var leaveId = $(this).data('id');
            var newStatus = $(this).val();

            $.ajax({
                url: 'update_leave_status.php',
                type: 'POST',
                data: {
                    id: leaveId,
                    status: newStatus
                },
                success: function(response) {
                    alert('Leave status updated successfully.');
                },
                error: function(xhr, status, error) {
                    alert('Failed to update leave status.');
                }
            });
        });
    });
</script>

</body>
</html>
