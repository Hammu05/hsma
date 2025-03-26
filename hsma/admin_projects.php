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

// Check if the form is submitted to create a new project
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['project_id'])) {
    // Sanitize and retrieve form data for new project
    $title = $conn->real_escape_string($_POST['title']);
    $client_id = $conn->real_escape_string($_POST['client']);
    $size = $conn->real_escape_string($_POST['size']);
    $timeline = $conn->real_escape_string($_POST['timeline']);
    $budget = $conn->real_escape_string($_POST['budget']);
    $status = $conn->real_escape_string($_POST['status']);
    $property_type = $conn->real_escape_string($_POST['propertyType']);
    $location = $conn->real_escape_string($_POST['location']);
    $material_preference = $conn->real_escape_string($_POST['material']);
    $design_requirements = $conn->real_escape_string($_POST['design']);
    $notes = $conn->real_escape_string($_POST['notes']);

    // SQL query to insert the data
    $sql = "INSERT INTO projects (title, client_id, size, timeline, budget, status, property_type, location, material_preference, design_requirements, notes)
            VALUES ('$title', '$client_id', '$size', '$timeline', '$budget', '$status', '$property_type', '$location', '$material_preference', '$design_requirements', '$notes')";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "New project created successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle project status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id']) && isset($_POST['status'])) {
    $project_id = $conn->real_escape_string($_POST['project_id']);
    $status = $conn->real_escape_string($_POST['status']);
    
    $update_sql = "UPDATE projects SET status = '$status' WHERE id = '$project_id'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['success_message'] = "Project status updated successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all clients
$sql = "SELECT id, first_name, last_name FROM users WHERE role = 'client'";
$result = $conn->query($sql);
$clients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Fetch all projects
$sql = "SELECT p.id, p.title, p.size, p.timeline, p.budget, p.status, c.first_name, c.last_name
        FROM projects p
        JOIN users c ON p.client_id = c.id";
$result = $conn->query($sql);
$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Handle success message for project creation or status update
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}
// Fetch all projects along with the client name
$query = "SELECT p.id, p.title, u.first_name, u.last_name
          FROM projects p
          JOIN users u ON p.client_id = u.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_projects.css">
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
                <span class="profession">Hello <?php echo htmlspecialchars($userData['username']); ?>!</span>
            </div>
        </div>
        <hr>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <!-- <li class="nav-link"><a href="admin_dashboard.php" class="tablinks">Dashboard</a></li> -->
                <li class="nav-link"><a href="admin_projects.php" class="tablinks">Projects</a></li>
                <li class="nav-link"><a href="admin_manage.php" class="tablinks">Manage</a></li>
                <!-- <li class="nav-link">
                    <a href="admin_quotations.php" class="tablinks">Quotations</a>
                </li> -->
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
    <div id="createProjContainer">
        <a href="#" id="createProjectButton">+ Create Project</a>
    </div>

    <div id="dashboard" class="tab-content">
        <div class="container">
            <h2>All Projects</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Size/Area</th>
                        <th>Project Date Start</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['title']); ?></td>
                            <td><?php echo htmlspecialchars($project['first_name'] . ' ' . $project['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($project['size']); ?></td>
                            <td><?php echo htmlspecialchars($project['timeline']); ?></td>
                            <td><?php echo htmlspecialchars($project['budget']); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo ($project['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="ongoing" <?php echo ($project['status'] == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                                        <option value="completed" <?php echo ($project['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                </form>
                            </td>
                            <td>
                                <button onclick="window.location.href='edit_project.php?id=<?php echo $project['id']; ?>'">Edit</button>
                                <button onclick="window.location.href='view_project.php?id=<?php echo $project['id']; ?>'">View</button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<!-- ================================== TRACKING TAB  -->

<div class="tracking-tab" id="trackingTab" onclick="opentracking()">
        Tracking
    </div>

    <!-- Tracking Panel -->
    <div class="tracking-panel" id="trackingPanel">
        <div class="tracking-header">
            <h2>Tracking</h2>
            <button class="close-btn tracking" onclick="closetracking()">×</button>
        </div>
        <div class="tracking-content">
        <form method="POST" action="insert_tracking.php" enctype="multipart/form-data">


        <label for="trackingSelection">Select Project</label>
<select id="trackingSelection" name="projectSelection" required>
    <option>--</option>
    <?php
    // Fetch and display the projects in the dropdown
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Combine project title with the client name
            $clientName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['title']) . ' - ' . $clientName . '</option>';
        }
    } else {
        echo '<option>No projects found</option>';
    }
    ?>
</select><br>  


            <label for="title">Title</label>
            <input type="text" id="trackingTitleInput" name="title"><br>

            <label for="datetime">Date and Time</label>
            <input type="datetime-local" id="trackingDatetime" name="datetime"><br>

            <label for="image">Attachments</label>
            <input type="file" id="image" name="image[]" accept="image/*" multiple><br>



            <label for="workPerformed">Work/s Performed</label>
<textarea name="work_performed" id="workPerformed"></textarea><br>



            <label for="dynamic-inputs">Equipment/s Used</label>
            <!-- Checkbox for "None" option -->
            <div class="checkbox-container">
                <input type="checkbox" id="noEquipment" name="none">
                <label for="noEquipment" id="noEquipmentNone">None</label>
            </div>

            <div id="dynamic-inputs">
                <div class="input-group">
                    <input type="text" name="equipment[]" id="equipment-input">
                    <button type="button" class="remove-btn" id="removeEquipment" onclick="removeInput(this)">x</button>
                </div>
            </div>
            <button type="button" id="add-btn">+</button>


            <label for="additionalNotes">Additional Notes</label>
            <textarea name="additional_notes" id="additionalNotes"></textarea><br>

            <a href="#" id="additionalReport"></a>

            <input type="submit" id="create_tracking" value="Submit Update">
        </form>

            <!-- Edit Tracking -->
            <hr>
            <h3>Existing Reports</h3>
            
        </div>
    </div>

<!-- -------------------------------------------------------------------------------------------  -->

</section>

<!-- -------------------------------------------------------------------------------------------  -->

<!-- ================================== REPORT MODAL  -->

<!-- Modal -->
<div id="myModal" class="modal report">
    <div class="modal-content report">
        <span class="close report">&times;</span>
        <h2>Additional Report/s</h2>
        <hr>
        <label for="weatherConditions">Weather Conditions</label>
        <textarea id="weatherConditions" name="weatherConditions" rows="4" cols="50"></textarea><br>

        <label for="incidentsDelays">Incidents and Delays</label>
        <textarea id="incidentsDelays" name="incidentsDelays" rows="4" cols="50"></textarea><br>

        <button type="button" id="submitReport">Add Report</button>
    </div>
</div>

<!-- Table to display submitted reports -->
<table id="reportTable" border="1">
    <thead>
        <tr>
            <th>Weather Conditions</th>
            <th>Incidents and Delays</th>
        </tr>
    </thead>
    <tbody>
        <!-- Report rows will be added dynamically here -->
    </tbody>
</table>

<!-- -------------------------------------------------------------------------------------------  -->

<!-- ============================= CREATE PROJECT MODAL -->

<div id="projectModal" class="modal createProject">
    <div class="modal-content createProject">
      <span class="close" id="closeModal">&times;</span>
      <h2>Create Project</h2>
      <hr>
      <form id="createProjectForm" method="POST" action="">

        <div class="modal-columns createProject">
          <div class="left-column createProject">
            <div class="form-row">
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="createProjInput" name="title" required>
              </div>
              <div class="form-group">
    <label for="client">Choose a Client</label>
    <select id="createProjInput" name="client" required>
        <option value="" disabled selected>Select Client</option>
        <?php foreach ($clients as $client): ?>
            <option value="<?php echo $client['id']; ?>">
                <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
            </div>

            <label for="size">Size/Area</label>
            <input type="text" id="createProjInput" name="size" required>

            <label for="timeline">Project Date Start</label>
            <input type="date" id="createProjInput" name="timeline" required>

            <label for="budget">Budget Range</label>
            <input type="number" id="createProjInput" name="budget" required>

            <label for="status">Status</label>
            <select id="createProjInput" name="status" required>
              <option value="" disabled selected></option>
              <option value="pending">Pending</option>
              <option value="ongoing">Ongoing</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="right-column createProject">
            <label for="propertyType">Type of Property</label>
            <select id="createProjInput" name="propertyType" required>
                <option value=""></option>
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
                <option value="industrial">Industrial</option>
                <option value="agricultural">Agricultural</option>
                <option value="mixed-use">Mixed-use</option>
                <option value="special">Special Purpose</option>
                <option value="vacant-land">Vacant Land</option>
                <option value="recreational">Recreational</option>
            </select>

            <label for="location">Location/Address</label>
            <input type="text" id="createProjInput" name="location" required>

            <label for="material">Material Preference</label>
            <input type="text" id="createProjInput" name="material" required>

            <label for="design">Design Requirements</label>
            <input type="text" id="createProjInput" name="design" required>

            <label for="notes">Additional Notes</label>
            <textarea id="createProjInput" name="notes"></textarea>
          </div>
        </div>
        <button type="submit" id="submitProject">Create Project</button>
      </form>
    </div>
  </div>

    <script src="admin_projects.js"></script>
</body>
</html>