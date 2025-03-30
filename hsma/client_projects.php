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
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="client_projects.css">
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
                        <a href="client_projects.php" class="tablinks">Projects</a>
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




        <script src="client_dashboard.js"></script>
    </body>
    </html>
