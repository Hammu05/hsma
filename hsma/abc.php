<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="abc.css">
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
                <span class="profession">Hello [Name]!</span>
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
        <div class="text">FirstName's Dashboard</div>
        <hr id="dashSeparate">

        <div class="container">
           content here
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
    <form>
      <div class="form-container editProf">
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

    <script src="abc.js"></script>
</body>
</html>
