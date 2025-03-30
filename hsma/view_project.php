<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to login page if not logged in or not an admin
    header("Location: homepage.php");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>
    <link rel="stylesheet" href="view_project.css">
</head>
<body>

<section class="home" id="home-section">
    <div id="viewProjContainer">
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: 50%;"></div> <!-- Static progress bar -->
        </div>
        <h2>View Project</h2>
        <hr>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        ?>
        <p><strong>Project Title:</strong> <?php echo htmlspecialchars($project['title']); ?></p>
        <p><strong>Size/Area:</strong> <?php echo htmlspecialchars($project['size']); ?></p>
        <p><strong>Project Date Start:</strong> <?php echo htmlspecialchars($project['timeline']); ?></p>
        <p><strong>Budget:</strong> <?php echo htmlspecialchars($project['budget']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($project['status']); ?></p>
        <p><strong>Property Type:</strong> <?php echo htmlspecialchars($project['property_type']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($project['location']); ?></p>
        <p><strong>Material Preference:</strong> <?php echo htmlspecialchars($project['material_preference']); ?></p>
        <p><strong>Design Requirements:</strong> <?php echo htmlspecialchars($project['design_requirements']); ?></p>
        <p><strong>Notes:</strong> <?php echo htmlspecialchars($project['notes']); ?></p>
        <button onclick="window.location.href='admin_projects.php'">Back to Projects</button>
    </div>
</section>

</body>
</html>
