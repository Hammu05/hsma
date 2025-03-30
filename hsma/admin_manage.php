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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve input data
    $firstName = trim($_POST['managerFirstName']);
    $lastName = trim($_POST['managerLastName']);
    $username = trim($_POST['username']);
    $email = trim($_POST['managerEmail']);
    $password = trim($_POST['managerPassword']);
    $confirmPassword = trim($_POST['managerConfirmPassword']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the email or username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email or username already exists. Please use different credentials.');</script>";
            echo "<script>window.history.back();</script>";
            exit;
        }

        // Insert the manager into the database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $role = 'manager';
        $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $hashedPassword, $role);
        $stmt->execute();

        echo "<script>alert('Manager registered successfully!');</script>";
        echo "<script>window.location.href = 'admin_manage.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('An error occurred while registering the manager. Please try again.');</script>";
        echo "<script>window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_manage.css">
    <title>Admin Manage</title>
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
        <div class="menu">
            <ul class="menu-links">
            <!-- <li class="nav-link">
                    <a href="admin_dashboard.php" class="tablinks">Dashboard</a>
                </li> -->
                <li class="nav-link">
                    <a href="admin_projects.php" class="tablinks">Projects</a>
                </li>
                <li class="nav-link">
                    <a href="admin_manage.php" class="tablinks">Manage</a>
                </li>
                <li class="nav-link"><a href="admin_accrec.php" class="tablinks">Account Records</a></li>

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
    <div class="container">
        <!-- Add Manager Button -->
        <button id="addManagerButton" class="add-manager-btn">Add Manager</button>
    </div>
</section>

<!-- Add Manager Modal -->
<div id="addManagerModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeAddManagerModal">&times;</span>
        <h2>Add Manager</h2>
        <hr>
        <!-- Registration Form -->
        <form action="admin_manage.php" method="POST">
            <div class="form-container">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="managerFirstName">First Name</label>
                        <input type="text" id="managerFirstName" name="managerFirstName" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="managerEmail">Email Address</label>
                        <input type="email" id="managerEmail" name="managerEmail" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="managerPhone">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter username">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="managerLastName">Last Name</label>
                        <input type="text" id="managerLastName" name="managerLastName" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
    <label for="managerPassword">Password</label>
    <input type="password" id="managerPassword" name="managerPassword" placeholder="Enter password" required>
    <button type="button" id="togglePassButton" class="toggle-password" onclick="togglePassword('managerPassword', this)">Show</button>
</div>
<div class="form-group">
    <label for="managerConfirmPassword">Confirm Password</label>
    <input type="password" id="managerConfirmPassword" name="managerConfirmPassword" placeholder="Confirm password" required>
    <button type="button" id="toggleConfPassButton" class="toggle-password" onclick="togglePassword('managerConfirmPassword', this)">Show</button>
</div>

                </div>
            </div>

            <button type="submit" class="save-changes-btn registerManager">Register Manager</button>
        </form>
    </div>
</div>


<!-- -------------------------------------------------------------------------------------------  -->


<script src="admin_manage.js"></script>
</body>
</html>