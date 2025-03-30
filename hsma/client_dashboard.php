<?php
session_start();
include 'db.php'; // Include database connection

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: homepage.php');
    exit;
}

// Fetch user data from the session
$user = $_SESSION['user'];
$username = $user['username'];
$email = $user['email'];
$role = $user['role'];

// Fetch additional user-related data from the database if needed
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Use $userData to display more user-specific information if needed
    }
} catch (Exception $e) {
    echo "<script>alert('Error fetching user data.');</script>";
}
$query = "
    SELECT 
    p.id AS project_id, 
    p.title AS project_title,
    tr.image AS latest_image,
    tr.datetime AS latest_update
    FROM 
    projects p
    LEFT JOIN 
    tracking_reports tr 
    ON 
    tr.id = (
        SELECT id 
        FROM tracking_reports 
        WHERE project_id = p.id 
        ORDER BY datetime DESC 
        LIMIT 1
    )
    WHERE 
    p.client_id = ?; -- Use placeholder here
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user['id']); // Bind the user id dynamically
$stmt->execute();
$projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    // Use $project_id to fetch project details or perform actions
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client_dashboard.css">
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
<!-- -------------------------------------------------------------------------------------------  -->

<!-- ============================= DASHBOARD CONTENTS -->

<section class="home" id="home-section">
    <div id="dashboard" class="tab-content">
        <div class="text"><?php echo htmlspecialchars($userData['first_name']) . ' ' . htmlspecialchars($userData['last_name']); ?>'s Dashboard</div>

        <hr id="dashSeparate">

        <div class="container">
    <div class="card__container">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <article class="card__article">
                    <img 
                        src="<?php echo !empty($project['latest_image']) 
                            ? htmlspecialchars($project['latest_image']) 
                            : 'placeholder.png'; ?>" 
                        alt="Project Image" 
                        class="card__img"
                    >
                    <div class="card__data">
                        <span class="card__description">
                            Last Updated: <?php echo !empty($project['latest_update']) 
                                ? htmlspecialchars(date("F j, Y, g:i a", strtotime($project['latest_update']))) 
                                : 'No updates yet'; ?>
                        </span>
                        <h2 class="card__title"><?php echo htmlspecialchars($project['project_title']); ?></h2>
                        <small>Status: </small>

                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No projects available.</p>
        <?php endif; ?>
    </div>
</div>

</section>
 
<!-- ================================== EDIT PROFILE MODAL  -->

<div id="editProfileModal" class="modal editProf">
  <div class="modal-content editProf">
    <span class="close editProf">&times;</span>
    <h2>Edit Profile</h2>
    <hr>
    <form method="POST" action="update_profile.php">
      <div class="form-container editProf">
        <!-- Left Column -->
        <div class="form-column editProf">
          <div class="form-group editProf">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $userData['first_name']; ?>" required>
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
            <input type="text" name="last_name" id="last_name" value="<?php echo $userData['last_name']; ?>" required>
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
      
        <button type="submit" class ="save-changes-btn editProf" name="update_profile">Update Profile</button>
    </form>
  </div>
</div>


<!-- ================================== EDIT PROFILE MODAL  -->

<!-- -------------------------------------------------------------------------------------------  -->

    <script src="client_dashboard.js"></script>
</body>
</html>
