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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manager_dashboard.css">
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
                    <a href="manager_dashboard.php" class="tablinks">Dashboard</a>
                </li>
                <li class="nav-link">
                    <a href="manager_quotation.php" class="tablinks">Quotation</a>
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
<!-- -------------------------------------------------------------------------------------------  -->

<!-- ============================= DASHBOARD CONTENTS -->

<section class="home" id="home-section">
    <div id="dashboard" class="tab-content">
    <div class="text"><?php echo htmlspecialchars($userData['username']); ?>'s Dashboard</div>
        <hr id="dashSeparate">

        <div class="container">
           
        </div>
    </div>
</section>

<!-- ============================= DASHBOARD CONTENTS -->

<!-- -------------------------------------------------------------------------------------------  -->
 
<!-- ================================== EDIT PROFILE MODAL  -->

<div id="editProfileModal" class="modal editProf">
  <div class="modal-content editProf">
    <span class="close editProf">&times;</span>
    <h2>Edit Profile</h2>
    <hr>
    <form method="POST" action="manager_updateprofile.php">
      <div class="form-container editProf">
        <!-- Left Column -->
        <div class="form-column editProf">
          <div class="form-group editProf">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
          </div>
          <div class="form-group editProf">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" value="<?php echo $userData['email']; ?>" required>
          </div>
          <div class="form-group editProf">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
        <small id="usernameError" style="color: red; display: none;">Username cannot be empty.</small>
        </div>
        </div>

        <!-- Right Column -->
        <div class="form-column editProf">
          <div class="form-group editProf">
            <label for="lastName">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>
        </div>


        <div class="form-group editProf">
            <label for="password">Password</label>
        <div class="password-container">
            <input type="password" id="password" placeholder="Enter your password">
            <button type="button" class="toggle-password" onclick="togglePassword('password')">Show</button>
        </div>
        </div>

        <div class="form-group editProf">
            <label for="confirmPassword">Confirm Password</label>
        <div class="password-container">
            <input type="password" id="confirmPassword" placeholder="Confirm your password">
            <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">Show</button>
        </div>
        </div>

        </div>
        </div>
      
        <button type="submit" class ="save-changes-btn editProf" name="manager_updateprofile">Update Profile</button>
    </form>
  </div>
</div>


<!-- ================================== EDIT PROFILE MODAL  -->

<!-- -------------------------------------------------------------------------------------------  -->

    <script src="manager_dashboard.js"></script>
</body>
</html>
