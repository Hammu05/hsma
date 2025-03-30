<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: homepage.php");
    exit;
}

// Fetch user data
$userData = $_SESSION['user'];

// Fetch client list from the database
$clientListQuery = "SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM users WHERE role = 'client'";
$clientListResult = $conn->query($clientListQuery);

// Handle form submission for adding tracking entries
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    $attachments = $_POST['attachments'];
    $work_performed = $_POST['work_performed'];
    $equipment_usage = $_POST['equipment_usage'];

    $insertQuery = "INSERT INTO tracking (client_id, title, date, time, status, attachments, work_performed, equipment_usage)
                    VALUES ('$client_id', '$title', '$date', '$time', '$status', '$attachments', '$work_performed', '$equipment_usage')";

    if ($conn->query($insertQuery) === TRUE) {
        $message = "Tracking entry added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_tracking.css">
    <title>Admin Tracking</title>
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
                    <a href="admin_dashboard.php" class="tablinks">Dashboard</a>
                </li>
                <li class="nav-link">
                    <a href="admin_manage.php" class="tablinks">Manage</a>
                </li>
                <li class="nav-link">
                    <a href="admin_tracking.php" class="tablinks">Tracking</a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="nav-link">
                <a href="admin_logout.php" class="logout-link">
                    <img src="logout.png" alt="Logout Icon" class="logout-icon">
                    <img src="logouthover.png" alt="Logout Icon Hover" class="logout-icon-hover">
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>

<section class="home" id="home-section">
    <div id="dashboard" class="tab-content">
        <div class="text">Tracking</div>
        <hr>

        <div class="container">
            <?php if (isset($message)) echo "<p>$message</p>"; ?>
            <form method="POST" action="">
                <label for="client_id">Client:</label>
                <select name="client_id" id="client_id" required>
                    <option value="" disabled selected>Select a client</option>
                    <?php while ($client = $clientListResult->fetch_assoc()): ?>
                        <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required>

                <label for="attachments">Attachments:</label>
                <textarea id="attachments" name="attachments"></textarea>

                <label for="work_performed">Work Performed:</label>
                <textarea id="work_performed" name="work_performed" required></textarea>

                <label for="equipment_usage">Equipment Usage:</label>
                <textarea id="equipment_usage" name="equipment_usage" required></textarea>

                <button type="submit">Add Tracking Entry</button>
            </form>

            <hr>
            <h2>Client List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clientListResult->data_seek(0); // Reset pointer for reuse
                    while ($client = $clientListResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= $client['id'] ?></td>
                            <td><?= htmlspecialchars($client['name']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>
</html>
