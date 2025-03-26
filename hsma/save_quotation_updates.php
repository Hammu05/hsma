<?php
session_start();
include 'db.php';

// Check if the user is logged in and is a manager
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: homepage.php");
    exit;
}

// Check if the form is submitted
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $visit_needed = $_POST['visit_needed'];
    $cost_estimation = $_POST['cost_estimation'];

    // Update the quotation in the database
    $sql = "UPDATE quotations SET visit_needed = ?, cost_estimation = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dii", $visit_needed, $cost_estimation, $id);  // 'd' for decimal (numeric), 'i' for integer
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect to the quotations page with a success flag to avoid form resubmission on refresh
        header("Location: manager_quotation.php?success=1");
        exit;
    } else {
        // Redirect to the quotations page with an error flag to avoid form resubmission on refresh
        header("Location: manager_quotation.php?error=1");
        exit;
    }
}
?>