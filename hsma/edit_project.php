<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to login page if not logged in or not an admin
    header("Location: homepage.php");
    exit;
}

// Fetch user data
$userData = $_SESSION['user'];

// Check if project ID is passed in the URL
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Fetch project data from the database
    $sql = "SELECT * FROM projects WHERE id = '$project_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
    } else {
        // If no project is found, redirect back with an error message
        $_SESSION['error_message'] = "Project not found!";
        header("Location: admin_projects.php");
        exit();
    }
} else {
    // If no project ID is provided, redirect to the project list page
    header("Location: admin_projects.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $title = $conn->real_escape_string($_POST['title']);
    $size = $conn->real_escape_string($_POST['size']);
    $timeline = $conn->real_escape_string($_POST['timeline']);
    $budget = $conn->real_escape_string($_POST['budget']);
    $status = $conn->real_escape_string($_POST['status']);
    $property_type = $conn->real_escape_string($_POST['property_type']); // Fixed to match 'property_type'
    $location = $conn->real_escape_string($_POST['location']);
    $material_preference = $conn->real_escape_string($_POST['material']);
    $design_requirements = $conn->real_escape_string($_POST['design']);
    $notes = $conn->real_escape_string($_POST['notes']);

    // SQL query to update the project data
    $update_sql = "UPDATE projects SET title = '$title', size = '$size', timeline = '$timeline', budget = '$budget', status = '$status', property_type = '$property_type', location = '$location', material_preference = '$material_preference', design_requirements = '$design_requirements', notes = '$notes' WHERE id = '$project_id'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['success_message'] = "Project updated successfully!";
        header("Location: admin_projects.php"); // Redirect to the projects list
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating project: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link rel="stylesheet" href="edit_project.css">
</head>
<body>
    <div id="editProjContainer">
        <h2>Edit Project</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        ?>
        <form method="POST" action="">
            <label for="title">Project Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>

            <label for="size">Size/Area:</label>
            <input type="text" name="size" value="<?php echo htmlspecialchars($project['size']); ?>" required>

            <label for="timeline">Project Date Start:</label>
            <input type="date" name="timeline" value="<?php echo htmlspecialchars($project['timeline']); ?>" required>

            <label for="budget">Budget:</label>
            <input type="text" name="budget" value="<?php echo htmlspecialchars($project['budget']); ?>" required>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="pending" <?php echo ($project['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="ongoing" <?php echo ($project['status'] == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                <option value="completed" <?php echo ($project['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
            </select>

            <label for="property_type">Type of Property</label> <!-- Fixed name to match the field name -->
            <select id="createProjInput" name="property_type" required>
                <option value="residential" <?php echo ($project['property_type'] == 'residential') ? 'selected' : ''; ?>>Residential</option>
                <option value="commercial" <?php echo ($project['property_type'] == 'commercial') ? 'selected' : ''; ?>>Commercial</option>
                <option value="industrial" <?php echo ($project['property_type'] == 'industrial') ? 'selected' : ''; ?>>Industrial</option>
                <option value="agricultural" <?php echo ($project['property_type'] == 'agricultural') ? 'selected' : ''; ?>>Agricultural</option>
                <option value="mixed-use" <?php echo ($project['property_type'] == 'mixed-use') ? 'selected' : ''; ?>>Mixed-use</option>
                <option value="special" <?php echo ($project['property_type'] == 'special') ? 'selected' : ''; ?>>Special Purpose</option>
                <option value="vacant-land" <?php echo ($project['property_type'] == 'vacant-land') ? 'selected' : ''; ?>>Vacant Land</option>
                <option value="recreational" <?php echo ($project['property_type'] == 'recreational') ? 'selected' : ''; ?>>Recreational</option>
            </select>

            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($project['location']); ?>">

            <label for="material">Material Preference:</label>
            <input type="text" name="material" value="<?php echo htmlspecialchars($project['material_preference']); ?>">

            <label for="design">Design Requirements:</label>
            <textarea name="design"><?php echo htmlspecialchars($project['design_requirements']); ?></textarea>

            <label for="notes">Notes:</label>
            <textarea name="notes"><?php echo htmlspecialchars($project['notes']); ?></textarea>

            <button type="submit">Update Project</button>
            <button type="button" onclick="window.location.href='admin_projects.php'">Back to Projects</button>
        </form>
    </div>
</body>
</html>
