<?php
require '../include/db_con.php'; // Database connection file

if (isset($_GET['email'], $_GET['start_date'], $_GET['end_date'])) {
    $email = $_GET['email'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    // Fetch attendance records for the student based on email and date range
    $stmt_attendance = $conn->prepare("SELECT * FROM attendance WHERE email = ? AND updated_at BETWEEN ? AND ?");
    $stmt_attendance->bind_param("sss", $email, $start_date, $end_date);
    $stmt_attendance->execute();
    $result_attendance = $stmt_attendance->get_result();
    $attendance_records = [];
    if ($result_attendance->num_rows > 0) {
        while ($row = $result_attendance->fetch_assoc()) {
            $attendance_records[] = $row;
        }
    }

    // Fetch leave records for the student based on email and date range
    $stmt_leaves = $conn->prepare("SELECT * FROM leaves WHERE email = ? AND from_date BETWEEN ? AND ?");
    $stmt_leaves->bind_param("sss", $email, $start_date, $end_date);
    $stmt_leaves->execute();
    $result_leaves = $stmt_leaves->get_result();
    $leave_records = [];
    if ($result_leaves->num_rows > 0) {
        while ($row = $result_leaves->fetch_assoc()) {
            $leave_records[] = $row;
        }
    }

    // Close database connections
    $stmt_attendance->close();
    $stmt_leaves->close();
    $conn->close();

    echo json_encode(['attendance' => $attendance_records, 'leaves' => $leave_records]);
}
?>
