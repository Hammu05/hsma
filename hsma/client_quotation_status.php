<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is a client
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    // Redirect to the homepage if not logged in or not a client
    header("Location: homepage.php");
    exit;
}

// Retrieve user data from the session
$userData = $_SESSION['user'];
$username = $userData['username'];  // Use the username to fetch quotations for this client

// Query to fetch quotations for the logged-in client from the database
$sql = "SELECT * FROM quotations WHERE username = ?"; // Filter by the client's username
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);  // 's' for string (username)
$stmt->execute();
$result = $stmt->get_result();

// Fetch quotations into an array
$quotations = [];
if ($result && $result->num_rows > 0) {
    $quotations = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle no quotations found
    $quotations = [];
}

// Close the statement
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client_quotation_status.css">
    <title>Client Quotation Status</title>
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
                    <a href="#" class="edit-profile-link" id="editProfileLink">Edit Profile</a>
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
                        <a href="client_quotation_status.php" class="tablinks">Quotation Status</a>
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
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <section class="home" id="home-section">
        <div class="container">
            <h1>YOUR QUOTATION</h1>
            <hr>
            <?php if (empty($quotations)): ?>
                <p>No quotations found.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Property Type</th>
                        <th>Status</th>
                        <th>Site Visit Needed</th>
                        <th>Cost Estimation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quotations as $quotation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($quotation['id']); ?></td>
                        <td><?php echo htmlspecialchars($quotation['property_type']); ?></td>
                        <td><?php echo htmlspecialchars($quotation['status'] ?? 'Pending'); ?></td>
                        <td><?php echo ($quotation['visit_needed'] == 1) ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($quotation['cost_estimation'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>