<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is a manager
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    // Redirect to the homepage if not logged in or not a manager
    header("Location: homepage.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the action and ID from the POST data
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Validate inputs
    if ($id > 0 && ($action === 'approve' || $action === 'decline')) {
        // Determine the new status based on the action
        $newStatus = $action === 'approve' ? 'Approved' : 'Declined';

        // Prepare and execute the SQL query to update the status
        $stmt = $conn->prepare("UPDATE quotations SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $id);

        if ($stmt->execute()) {
            // Redirect back to the quotations page with success message
            header("Location: manager_quotation.php?message=success");
        } else {
            // Redirect back with an error message if the query fails
            header("Location: manager_quotation.php?message=error");
        }

        $stmt->close();
    } else {
        // Redirect back with an error if inputs are invalid
        header("Location: manager_quotation.php?message=invalid");
    }
} else {
    // Redirect back if the request is not POST
    header("Location: manager_quotation.php");
}
exit;
?>