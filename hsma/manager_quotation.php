<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is a manager
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    // Redirect to the homepage if not logged in or not a manager
    header("Location: homepage.php");
    exit;
}
// Retrieve user data from the session
$userData = $_SESSION['user'];

// Query to fetch all quotations from the database
$sql = "SELECT * FROM quotations"; // Modify table and columns as needed
$result = $conn->query($sql);

// Fetch all quotations into an array
$quotations = [];
if ($result && $result->num_rows > 0) {
    $quotations = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle no quotations found
    $quotations = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manager_quotation.css">
    <title>Manager Dashboard</title>
</head>
<body>
<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="dblogo.png" alt="logo">
            </span>
            <div class="text header-text">
                <span class="profession">Hello <?php echo htmlspecialchars($userData['username']); ?>!</span>
                <!-- <a href="#" class="edit-profile-link" id="editProfileLink">Edit Profile</a> -->
            </div>
        </div>
        <hr>
    </header>
    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <!-- <li class="nav-link"><a href="manager_dashboard.php" class="tablinks">Dashboard</a></li> -->
                <li class="nav-link"><a href="manager_quotation.php" class="tablinks">Quotation</a></li>
                <!-- <li class="nav-link"><a href="manager_tracking.php" class="tablinks">Tracking</a></li> -->
            </ul>
        </div>
        <div class="bottom-content">
            <li class="nav-link">
            <a href="manager_logout.php" class="logout-link">
                    <img src="logout.png" alt="Logout Icon" class="logout-icon">
                    <img src="logouthover.png" alt="Logout Icon Hover" class="logout-icon-hover">
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>

<section class="home" id="home-section">
    <div class="container">
        <h1>Manage Quotations</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Property Type</th>
                    <th>Project Size</th>
                    <th>Budget Range</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quotations as $quotation): ?>
                <tr>
                    <td><?php echo $quotation['id']; ?></td>
                    <td><?php echo htmlspecialchars($quotation['username']); ?></td>
                    <td><?php echo htmlspecialchars($quotation['property_type']); ?></td>
                    <td><?php echo htmlspecialchars($quotation['project_size']); ?></td>
                    <td><?php echo htmlspecialchars($quotation['budget_range']); ?></td>
                    <td><?php echo htmlspecialchars($quotation['status'] ?? 'Pending'); ?></td>
                    <td>
                        <a href="view_quotation.php?id=<?php echo $quotation['id']; ?>" class="btn view">View</a>
                        <form method="POST" action="update_quotation_status.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $quotation['id']; ?>">
                            <button type="submit" name="action" value="approve" class="btn approve">Approve</button>
                        </form>
                        <form method="POST" action="update_quotation_status.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $quotation['id']; ?>">
                            <button type="submit" name="action" value="decline" class="btn decline">Decline</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>