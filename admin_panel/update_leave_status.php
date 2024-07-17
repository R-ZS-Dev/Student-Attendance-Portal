<?php
require '../include/db_con.php'; // Database connection file

if (isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update leave status
    $stmt = $conn->prepare("UPDATE leaves SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        echo "Leave status updated successfully.";
    } else {
        echo "Failed to update leave status.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid parameters.";
}
?>
