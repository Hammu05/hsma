<?php
// Include the database connection
include 'db.php'; // Ensure your database connection is correctly set

// Start session to use session variables
session_start();

// Assuming the form data is received
$project_id = $_POST['projectSelection']; // The project ID selected in the form
$title = $_POST['title'];
$datetime = $_POST['datetime'];
$work_performed = $_POST['body'];
$equipment_used = isset($_POST['equipment']) ? implode(',', $_POST['equipment']) : null; // Storing equipment used as comma-separated
$additional_notes = $_POST['body'];

// Handle multiple file uploads
$imagePaths = []; // Initialize an array to store the paths of uploaded images

// Check if multiple image files were uploaded
if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
    $targetDir = 'uploads/'; // Set the target directory for uploads

    // Loop through the uploaded files
    foreach ($_FILES['image']['name'] as $key => $fileName) {
        // Check if there are no errors with the file upload
        if ($_FILES['image']['error'][$key] == 0) {
            // Get file extension
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Create a unique file name (to avoid name conflicts)
            $newFileName = uniqid('', true) . '.' . $fileExtension;

            // Set the full file path
            $filePath = $targetDir . $newFileName;

            // Validate file type
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($fileExtension), $validExtensions)) {
                // Move the uploaded file to the 'uploads' folder
                if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $filePath)) {
                    // Store the file path in the array
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

// Bind parameters (using 's' for strings and 'i' for integers)
$stmt->bind_param("issssss", $project_id, $title, $datetime, $imagePathsString, $work_performed, $equipment_used, $additional_notes);

// Execute the statement
$stmt->execute();

// Check if the insertion was successful
if ($stmt->affected_rows > 0) {
    // Set a session variable to indicate success
    $_SESSION['submission_status'] = 'success';
} else {
    // Set a session variable to indicate failure
    $_SESSION['submission_status'] = 'error';
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Redirect back to the form with an alert message
echo "<script>";
if ($_SESSION['submission_status'] == 'success') {
    echo "alert('Tracking report submitted successfully!');";
} else {
    echo "alert('Error submitting tracking report.');";
}
// Clear session variable after use
unset($_SESSION['submission_status']);
echo "window.location.href = 'admin_projects.php';"; // Replace 'admin_projects.php' with the correct page
echo "</script>";
exit();
?>
