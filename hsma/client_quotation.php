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
$username = htmlspecialchars($user['username']); // Sanitize to prevent XSS
$email = htmlspecialchars($user['email']);
$role = htmlspecialchars($user['role']);
$userId = intval($user['id']); // Ensure ID is an integer

// Fetch additional user-related data from the database if needed
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Optional: Sanitize data fetched from the database
        $fullName = htmlspecialchars($userData['username']);
        $createdAt = htmlspecialchars($userData['created_at']);
        // Add more fields as needed
    } else {
        echo "<script>alert('User data not found. Please contact support.');</script>";
    }
} catch (Exception $e) {
    // Log error for debugging
    error_log("Error fetching user data: " . $e->getMessage());
    echo "<script>alert('Error fetching user data. Please try again later.');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client_quotation.css">
    <title>User Dashboard</title>
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

                <!-- <a href="#" class="edit-profile-link" id="editProfileLink">Edit Profile</a> -->
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
                    <img src="logouthover.png" alt="Logout Icon Hover" class="logout-icon-hover">
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>

<!-- ============================= MAIN CONTENTS -->

<section class="form-container">
    <h1>Quotation Form</h1>
    <div class="scrollable-container">
    <form action="insert_quotation.php" method="POST" enctype="multipart/form-data">
            <!-- Type of Project -->

 <!-- ======================================== DROPDOWN  -->


 <div class="checkbox-group">
    <div class="column">
        <div class="category">
            <label for="structural">Structural</label>
            <div class="options">
                <div>
                    <input type="checkbox" id="structural-option1" name="structural[]" value="Foundation Works">
                    <label for="structural-option1" title="(Pile Driving, Slab, Footing)">Foundation Works</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option2" name="structural[]" value="Reinforced Concrete">
                    <label for="structural-option2" title="(Beams, Columns, Slabs)">Reinforced Concrete</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option3" name="structural[]" value="Steel Work">
                    <label for="structural-option3" title="(Frame, Bracing, Reinforcement)">Steel Work</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option4" name="structural[]" value="Masonry Works">
                    <label for="structural-option4" title="(Brick/Block Walls, Stonework)">Masonry Works</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option5" name="structural[]" value="Earthworks">
                    <label for="structural-option5" title="(Excavation, Backfilling)">Earthworks</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option6" name="structural[]" value="Grouting and Injection Works">
                    <label for="structural-option6">Grouting and Injection Works</label>
                </div>
                <div>
                    <input type="checkbox" id="structural-option-others" name="structural[]" value="Others">
                    <label for="structural-option-others">Others</label>
                    <input type="text" id="others-input" name="others-input" placeholder="Please specify">
                </div>
            </div>
        </div>



        <div class="category">
            <label for="architectural">Architectural</label>
            <div class="options">
                <div>
                    <input type="checkbox" id="architectural-option1" name="architectural[]" value="Painting">
                    <label for="architectural-option1" title="(Interior & Exterior)">Painting</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option2" name="architectural[]" value="Interior Design">
                    <label for="architectural-option2" title="(Finishes, Furnishings, Layout)">Interior Design</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option3" name="architectural[]" value="Flooring">
                    <label for="architectural-option3" title="(Tiles, Wood, Carpet, etc.)">Flooring</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option4" name="architectural[]" value="Ceiling">
                    <label for="architectural-option4" title="(Suspended, Acoustic)">Ceiling</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option5" name="architectural[]" value="Wall Finishes">
                    <label for="architectural-option5" title="(Plaster, Paneling, etc.)">Wall Finishes</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option6" name="architectural[]" value="Doors & Windows">
                    <label for="architectural-option6" title="(Installation, Framing)">Doors & Windows</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option7" name="architectural[]" value="Partitions">
                    <label for="architectural-option7" title="(Drywall, Glass, etc.)">Partitions</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option8" name="architectural[]" value="Landscaping">
                    <label for="architectural-option8" title="(Exterior Design, Garden)">Landscaping</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option9" name="architectural[]" value="Signage">
                    <label for="architectural-option9" title="(Directional and Safety Signage)">Signage</label>
                </div>
                <div>
                    <input type="checkbox" id="architectural-option-others" name="architectural[]" value="Others">
                    <label for="architectural-option-others">Others</label>
                    <input type="text" id="others-input" name="others-input" placeholder="Please specify">
                </div>
            </div>
        </div>
    </div>

        <div class="column">
            <div class="category">
                <label for="civil">Civil</label>
                <div class="options">
                    <div>
                        <input type="checkbox" id="civil-option1" name="civil[]" value="Site Development">
                        <label for="civil-option1" title="(Grading, Drainage)">Site Development</label>
                    </div>
                    <div>
                        <input type="checkbox" id="civil-option2" name="civil[]" value="Roadworks">
                        <label for="civil-option2" title="(Paving, Curbs, Gutters)">Roadworks</label>
                    </div>
                    <div>
                        <input type="checkbox" id="civil-option3" name="civil[]" value="Earthworks">
                        <label for="civil-option3" title="(Excavation, Embankment)">Earthworks</label>
                    </div>
                    <div>
                        <input type="checkbox" id="civil-option4" name="civil[]" value="Stormwater Management">
                        <label for="civil-option4" title="(Sewers, Drainage)">Stormwater Management</label>
                    </div>
                    <div>
                        <input type="checkbox" id="civil-option5" name="civil[]" value="Retaining Walls">
                        <label for="civil-option5" title="(For slope stabilization)">Retaining Walls</label>
                    </div>
                    <div>
                        <input type="checkbox" id="civil-option6" name="civil[]" value="Fencing and Gate Installation">
                        <label for="civil-option6">Fencing and Gate Installation</label>
                    </div>
                    <div>
            <input type="checkbox" id="architectural-option-others" name="civil[]" value="Others">
            <label for="architectural-option-others">Others</label>
            <input type="text" id="others-input" name="others-input" placeholder="Please specify">
        </div>
                    <hr id="civ-mech">
                </div>
            </div>
            <div class="category">
                <label for="mechanical">Mechanical</label>
                <div class="options">
                    <div>
                        <input type="checkbox" id="mechanical-option1" name="mechanical[]" value="HVAC">
                        <label for="mechanical-option1" title="(Heating, Ventilation, Air Conditioning)">HVAC</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mechanical-option2" name="mechanical[]" value="Fire Protection Systems">
                        <label for="mechanical-option2" title="(Sprinklers, Fire Extinguishers)">Fire Protection Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mechanical-option3" name="mechanical[]" value="Lifts/Elevators">
                        <label for="mechanical-option3" title="(Installation and Maintenance)">Lifts/Elevators</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mechanical-option4" name="mechanical[]" value="Air-Handling Units">
                        <label for="mechanical-option4" title="(Ductwork, Vents)">Air-Handling Units</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mechanical-option5" name="mechanical[]" value="Pumps and Motors">
                        <label for="mechanical-option5" title="(For water, HVAC systems)"> Pumps and Motors</label>
                    </div>
                    <div>
                        <input type="checkbox" id="mechanical-option6" name="mechanical[]" value="Chillers and Boilers">
                        <label for="mechanical-option6">Chillers and Boilers</label>
                    </div>
                    <div>
            <input type="checkbox" id="architectural-option-others" name="mechanical[]" value="Others">
            <label for="architectural-option-others">Others</label>
            <input type="text" id="others-input" name="others-input" placeholder="Please specify">
        </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="category">
                <label for="electrical">Electrical</label>
                <div class="options">
                    <div>
                        <input type="checkbox" id="electrical-option1" name="electrical[]" value="Power Supply Systems">
                        <label for="electrical-option1" title="(Transformers, Main Distribution Boards)">Power Supply Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option2" name="electrical[]" value="Lighting Systems">
                        <label for="electrical-option2" title="(Indoor, Outdoor, Emergency Lighting)">Lighting Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option3" name="electrical[]" value="Auxiliary Services">
                        <label for="electrical-option3" title="(Backup Generators, UPS, Batteries)">Auxiliary Services</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option4" name="electrical[]" value="Wiring and Cabling">
                        <label for="electrical-option4" title="(Power, Data, Telecommunication)">Wiring and Cabling</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option5" name="electrical[]" value="Earthing and Grounding Systems">
                        <label for="electrical-option5">Earthing and Grounding Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option6" name="electrical[]" value="Security Systems">
                        <label for="electrical-option6" title="(CCTV, Alarms, Access Control)">Security Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="electrical-option7" name="electrical[]" value="Audio-Visual Systems">
                        <label for="electrical-option7" title="(Sound, Projection Equipment)">Audio-Visual Systems</label>
                    </div>
                    <div>
            <input type="checkbox" id="architectural-option-others" name="electrical[]" value="Others">
            <label for="architectural-option-others">Others</label>
            <input type="text" id="others-input" name="others-input" placeholder="Please specify">
        </div>
                    <hr id="elec-plum">
                </div>
            </div>
            <div class="category">
                <label for="plumbing">Plumbing</label>
                <div class="options">
                    <div>
                        <input type="checkbox" id="plumbing-option1" name="plumbing[]" value="Water Supply Systems">
                        <label for="plumbing-option1" title="(Pipes, Pumps, Water Tanks)">Water Supply Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option2" name="plumbing[]plumbing[]" value="Drainage Systems">
                        <label for="plumbing-option2" title="(Sanitary, Stormwater)">Drainage Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option3" name="plumbing[]" value="Sewage Treatment">
                        <label for="plumbing-option3" title="(Wastewater, Septic Systems)">Sewage Treatment</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option4" name="plumbing[]" value="Gas Systems">
                        <label for="plumbing-option4" title="(Piping, Metering)">Gas Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option5" name="plumbing[]" value="Hot Water Systems">
                        <label for="plumbing-option5" title="(Heaters, Solar Systems)">Hot Water Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option6" name="plumbing[]" value="Water Filtrarion System">
                        <label for="plumbing-option6">Water Filtration Systems</label>
                    </div>
                    <div>
                        <input type="checkbox" id="plumbing-option7" name="plumbing[]" value="Fixture and Fittings">
                        <label for="plumbing-option7" title="(Toilets, Faucets, Showers)">Fixtures and Fittings</label>
                    </div>
                    <div>
            <input type="checkbox" id="architectural-option-others" name="plumbing[]" value="Others">
            <label for="architectural-option-others">Others</label>
            <input type="text" id="others-input" name="others-input" placeholder="Please specify">
        </div>
                </div>
            </div>
        </div>
    </div>



<!-- ======================================== DROPDOWN  -->
<hr>
            <!-- Two-Column Layout -->
            <div class="form-group">
                <!-- Left Column -->
                <div>
                    <label for="propertyType">Type of Property:</label>
                    <select id="propertyType" name="propertyType">
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

                    <label for="projectLocation">Project Location/Address:</label>
                    <input type="text" id="projectLocation" name="projectLocation" placeholder="e.g., 123 Main St.">

                    <label for="projectSize">Project Size/Area:</label>
                    <input type="text" id="projectSize" name="projectSize" placeholder="e.g., 1500 sq. ft.">

                    <label for="timeline" id="DesiredTimeline">Desired Timeline:</label>
                    <div class="date-group">
                        <input type="date" id="startDate" name="startDate">
                        <input type="date" id="endDate" name="endDate">
                    </div>

                    <label for="budgetRange">Budget Range:</label>
                    <input type="number" id="budgetRange" name="budgetRange" placeholder="e.g., 500000">

                    <label for="communicationMode">Preferred Mode of Communication:</label>
                    <input type="text" id="communicationMode" name="communicationMode" placeholder="e.g., Email">

                    <label for="contactTime">Best Time to Contact:</label>
                    <input type="text" id="contactTime" name="contactTime" placeholder="e.g., 9 AM - 5 PM">
                </div>

                <!-- Right Column -->
                <div>
                    <label for="materialsPreference">Materials Preference:</label>
                    <input type="text" id="materialsPreference" name="materialsPreference" placeholder="e.g., High-quality wood">

                    <label for="designRequirements">Design Requirements:</label>
                    <input type="text" id="designRequirements" name="designRequirements" placeholder="e.g., Minimalist">

                    <label for="servicesNeeded">Services Needed:</label>
                    <input type="text" id="servicesNeeded" name="servicesNeeded" placeholder="e.g., Renovation">

                    <label for="attachments">Attachments:</label>
                    <input type="file" id="attachments" name="attachments">

                    <label for="scopeOfWork">Scope of Work:</label>
                    <input type="text" id="scopeOfWork" name="scopeOfWork" placeholder="e.g., Interior Design">

                    <label for="specialRequests">Special Requests/Requirements:</label>
                    <input type="text" id="specialRequests" name="specialRequests" placeholder="e.g., Eco-friendly materials">

                    
                    <label for="siteVisit" id="SiteVisit">Site Visit:</label>
<div class="site-visit-group">
    <div class="input-group">
        <input type="date" id="siteVisitDate" name="siteVisitDate">
    </div>
    
    <div class="input-group">
        <input type="time" id="siteVisitTime" name="siteVisitTime">
    </div>
</div>


                </div>
            </div>
            <button type="submit" id="SubmitQuote">Submit Quotation</button>
        </form>
        
    </div>
</section>



<!-- ================================================== MAIN CONTENTS  -->

<!-- -------------------------------------------------------------------------------------------  -->
 
<!-- ================================== EDIT PROFILE MODAL  -->

<div id="editProfileModal" class="modal editProf">
  <div class="modal-content editProf">
    <span class="close editProf">&times;</span>
    <h2>Edit Profile</h2>
    <hr>
    <form>
      <div class="form-container-editProf">
        <!-- Left Column -->
        <div class="form-column editProf">
          <div class="form-group editProf">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" placeholder="Enter your first name">
          </div>
          <div class="form-group editProf">
            <label for="email">Email address</label>
            <input type="email" id="email" placeholder="Enter your email">
          </div>
          <div class="form-group editProf">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" placeholder="Enter your phone number" 
                oninput="validatePhoneNumber(this)" maxlength="11">
            <small id="phoneError" style="color: red; display: none;">Phone number must be valid.</small>
          </div>
        </div>

        <!-- Right Column -->
        <div class="form-column editProf">
          <div class="form-group editProf">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" placeholder="Enter your last name">
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
      
      <button type="submit" class="save-changes-btn editProf">Save changes</button>
    </form>
  </div>
</div>


<!-- ================================== EDIT PROFILE MODAL  -->

<!-- -------------------------------------------------------------------------------------------  -->


    <script src="client_quotation.js"></script>
</body>
</html>