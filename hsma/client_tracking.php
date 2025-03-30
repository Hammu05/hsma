<?php
session_start();
include 'db.php'; // Include database connection

// Redirect to homepage if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: homepage.php');
    exit;
}

// Fetch user data from the session
$user = $_SESSION['user'];
$userId = intval($user['id']); // Ensure ID is an integer

// Fetch tracking reports based on the user's projects
$query = "
    SELECT 
        tr.id,
        tr.title,
        tr.datetime,
        tr.work_performed,
        tr.equipment_used,
        tr.additional_notes,
        tr.image  -- Fetch the image URL or path
    FROM 
        tracking_reports tr
    JOIN 
        projects p ON tr.project_id = p.id
    WHERE 
        p.client_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$reports = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client_tracking.css">
    <title>Client Dashboard</title>
</head>
<body>
<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="dblogo.png" alt="logo">
            </span>

            <div class="text header-text">
                <!-- Display the username dynamically here -->
                <span class="profession">Hello <?php echo htmlspecialchars($user['username']); ?>!</span>
            </div>
        </div>
        
        <hr>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="client_dashboard.php" class="tablinks">Dashboard</a>
                </li>
                <li class="nav-link">
                    <a href="client_quotation.php" class="tablinks">Quotation</a>
                </li>
                <li class="nav-link">
                    <a href="client_tracking.php" class="tablinks">Tracking</a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li class="nav-link">
                <a href="user_logout.php" class="logout-link">
                    <img src="logout.png" alt="Logout Icon" class="logout-icon">
                    <img src="logouthover.png" alt="Logout Icon Hover" class="logout-icon-hover">
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>

<section class="home" id="home-section">
    <h2 id="trackingProjTitle">PROJECT TITLE</h2>
    <div id="dashboard" class="tab-content">
        <div class="timeline">
            <?php foreach ($reports as $report): ?>
                <div class="container <?php echo ($report['id'] % 2 == 0) ? 'right-container' : 'left-container'; ?>">
                    <img src="dblogo.png" alt="">
                    <div class="text-box">
                        <h2><?php echo htmlspecialchars($report['title']); ?></h2>
                        <small><?php echo htmlspecialchars($report['datetime']); ?></small>
                        <p class="view-details" id="trackingViewDetails<?php echo $report['id']; ?>">View Details</p>
                        <span class="<?php echo ($report['id'] % 2 == 0) ? 'right-container-arrow' : 'left-container-arrow'; ?>"></span>
                    </div>
                </div>

                <!-- Modal for report details -->

        </div>
    </div>
</section>
<div id="modal<?php echo $report['id']; ?>" class="modal trackingViewDeatils">
                    <div class="modal-content trackingViewDeatils">
                        <span class="close trackingViewDeatils">&times;</span>
                        <h2>Details for <?php echo htmlspecialchars($report['title']); ?></h2>
                        <hr>
                        <table class="details-table">
                            <thead>
                                <tr>
                                    <th>Work Performed</th>
                                    <th>Equipment Used</th>
                                    <th>Additional Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($report['work_performed']); ?></td>
                                    <td><?php echo htmlspecialchars($report['equipment_used']); ?></td>
                                    <td><?php echo htmlspecialchars($report['additional_notes']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <label for="attachments">Attachments:</label>

<?php if (!empty($report['image'])): ?>
    <div class="attachments">
        <?php 
        // Check if images are stored as a comma-separated string
        $images = explode(',', $report['image']); // Split by comma
        
        // Loop through and display each image
        foreach ($images as $image): 
            $image = trim($image); // Trim any whitespace
            if (!empty($image)): // Ensure it's not an empty value
        ?>
            <img src="<?php echo htmlspecialchars($image); ?>" alt="Attachment" class="attachment-image">
        <?php 
            endif; 
        endforeach; 
        ?>
    </div>
<?php else: ?>
    <p>No attachments available.</p>
<?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
<script src="client_tracking.js"></script>
</body>
</html>
