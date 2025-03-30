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

// Fetch all managers and clients from the database
$managers = [];
$clients = [];

try {
    // Fetch Managers
    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE role = 'manager'");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $managers[] = $row;
    }
    $stmt->close();

    // Fetch Clients
    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE role = 'client'");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    $stmt->close();
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage</title>
    <link rel="stylesheet" href="admin_accrec.css">
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
            </div>
        </div>
        <hr>
    </header>
    <div class="menu-bar">
        <ul class="menu-links">
            <li><a href="admin_projects.php" class="tablinks">Projects</a></li>
            <li><a href="admin_manage.php" class="tablinks">Manage</a></li>
            <li><a href="admin_accrec.php" class="tablinks">Account Records</a></li>
        </ul>
        <div class="bottom-content">
            <a href="admin_logout.php" class="logout-link">
                <img src="logout.png" alt="Logout">
                <span>Logout</span>
            </a>
        </div>
    </div>
</nav>

<section class="home">
    <div class="container">
        <div class="account-container">
            <h2>Managers</h2>
            <table class="account-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th> <!-- Keeps column for CSS layout -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($managers)): ?>
                        <?php foreach ($managers as $manager): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($manager['first_name'] . ' ' . $manager['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($manager['email']); ?></td>
                                <td>********</td> <!-- Password Masked -->
                                <td>Active</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No managers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h2>Clients</h2>
            <table class="account-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th> <!-- Keeps column for CSS layout -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td>********</td> <!-- Password Masked -->
                                <td>Active</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No clients found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="admin_accrec.js"></script>
</body>
</html>
