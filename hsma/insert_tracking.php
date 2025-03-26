<?php
// Include the database connection
include 'db.php'; // Ensure your database connection is correctly set

// Start session to use session variables
session_start();

// Assuming the form data is received
$project_id = $_POST['projectSelection'] ?? null;
$title = $_POST['title'] ?? '';
$datetime = $_POST['datetime'] ?? '';
$work_performed = isset($_POST['work_performed']) && !empty($_POST['work_performed']) ? $_POST['work_performed'] : '';
$equipment_used = isset($_POST['equipment']) ? implode(',', $_POST['equipment']) : null; // Storing equipment used as comma-separated
$additional_notes = $_POST['additional_notes'] ?? '';

// Handle multiple file uploads
$imagePaths = [];

// Check if multiple image files were uploaded
if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
    $targetDir = 'uploads/'; // Set the target directory for uploads

    // Loop through the uploaded files
    foreach ($_FILES['image']['name'] as $key => $fileName) {
        if ($_FILES['image']['error'][$key] == 0) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('', true) . '.' . $fileExtension;
            $filePath = $targetDir . $newFileName;

            // Validate file type
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($fileExtension), $validExtensions)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $filePath)) {
                    $imagePaths[] = $filePath;
                }
            }
        }
    }
}

// Convert the image paths array into a comma-separated string
$imagePathsString = implode(',', $imagePaths);

// Prepare the SQL query to insert the data
$sql = "INSERT INTO tracking_reports (project_id, title, datetime, image, work_performed, equipment_used, additional_notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", $project_id, $title, $datetime, $imagePathsString, $work_performed, $equipment_used, $additional_notes);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION['submission_status'] = 'success';
} else {
    $_SESSION['submission_status'] = 'error: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect back to the form with an alert message
echo "<script>";
if ($_SESSION['submission_status'] === 'success') {
    echo "alert('Tracking report submitted successfully!');";
} else {
    echo "alert('Error submitting tracking report: {$_SESSION['submission_status']}');";
}
unset($_SESSION['submission_status']);
echo "window.location.href = 'admin_projects.php';"; // Replace 'admin_projects.php' with the correct page
echo "</script>";
exit();

?>