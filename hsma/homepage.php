<?php
session_start();
include 'db.php'; // Include database connection

// Handle form submissions
if (isset($_POST['register'])) {
    // Sanitize and retrieve form inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash password
    $terms_conditions = isset($_POST['terms_conditions']) ? 1 : 0;

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
        } else {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, terms_conditions, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $role = 'client';
            $stmt->bind_param("sssssis", $first_name, $last_name, $username, $email, $password, $terms_conditions, $role);
            $stmt->execute();

            echo "<script>alert('Registration successful! You can now log in.');</script>";
            echo "<script>window.location.href = 'homepage.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('An error occurred. Please try again.');</script>";
    }
}

    elseif (isset($_POST['login'])) {
        // Login logic
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        try {
            // Fetch user from database
            $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $username, $user_email, $hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Password is correct, set session
                    $_SESSION['user'] = [
                        'id' => $id,
                        'username' => $username,
                        'email' => $user_email,
                        'role' => $role
                    ];

                    // Redirect based on role
                    if ($role == 'client') {
                        header('Location: client_dashboard.php');
                    } else {
                        echo "<script>alert('Unknown role. Contact administrator.');</script>";
                        echo "<script>window.location.href = 'homepage.php';</script>";
                    }
                    exit;
                } else {
                    echo "<script>alert('Invalid email or password.');</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('An error occurred. Please try again.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Satisfactions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css">
</head>

<body>
    <header>
        <img src="hsma.png">
        <nav class="navigation">
            <a href="homepage.php">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
            <button class="btnlogin-popup">Login</button>
        </nav>
    </header>

    <div class="homepage">
        <h2 class="anim">COMMITMENT TO YOUR SATISFACTION, <br>EVERY STEP OF THE WAY.</h2>
        <a href="quotation.php" class="regis-btn anim">Get a quotation</a>
    </div>

    <div class="wrapper">
        <span class="icon-close">
            <img src="close.png" alt="close">
        </span>

        <!-- Login Form -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="homepage.php" method="POST"> <!-- Change form action to homepage.php -->
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember_me">Remember Me</label>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" name="login" class="btn">Login</button>

                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-box register">
            <h2>Register</h2>
            <form action="homepage.php" method="POST">


            
            <div class="input-boxNames name-container">
    <div class="name-field">
        <input type="text" name="first_name" required>
        <label>First Name</label>
    </div>
    <div class="name-field">
        <input type="text" name="last_name" required>
        <label>Last Name</label>
    </div>
</div>

                <div class="input-box">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>

                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="terms_conditions">
                        I agree to the 
                        <a href="#" id="termsLink">terms & conditions</a>
                    </label>
                </div>

                <button type="submit" name="register" class="btn">Register</button>

                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

<!-- ========================== TERMS AND CONDITIONS MODAL  -->

<div id="termsModal" class="modal tac">
        <div class="modal-content tac">
            <span class="close tac">&times;</span>
            <h1>Terms and Conditions</h1>
            <br>
            <hr>

            <p id="tacNumbering">1. Acceptance of Terms</p>
            <small id="tacSmallDesc">By accessing or using Home Satisfaction’s Online Construction Project Monitoring Management System with Cost Estimation Service, operated by Home Satisfaction, you agree to comply with and be bound by these Terms and Conditions. If you do not agree to these Terms, please do not use the Service.</small>

            <p id="tacNumbering">2. Description of Service</p>
            <small id="tacSmallDesc">Our platform provides tools for monitoring construction projects, estimating costs, and managing related tasks. The Service is designed to assist clients, contractors, and project managers in streamlining their construction workflows and achieving better project outcomes.</small>

            <p id="tacNumbering">3. User Registration and Accounts</p>
                <li id="tacBulletPoints"><b>Eligibility:</b> You must be at least 18 years old to use this Service.</li>
                <li id="tacBulletPoints"><b>Account Security:</b> You are responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account.</li>
                <li id="tacBulletPoints"><b>Accurate Information:</b> You agree to provide accurate, current, and complete information during the registration process.</li>
                <li id="tacBulletPoints"><b>Termination:</b> We reserve the right to suspend or terminate accounts if any activity violates these Terms or is deemed harmful to the Service.</li>

            <p id="tacNumbering">4. Use of Service</p>
            <small id="tacSmallDesc">You agree to use the Service only for lawful purposes and in accordance with these Terms. Prohibited activities include but are not limited to:</small>
                <li id="tacBulletPoints">Attempting to gain unauthorized access to the Service or other user accounts.</li>
                <li id="tacBulletPoints">Misrepresenting project data, cost estimations, or other information.</li>
                <li id="tacBulletPoints">Using the Service to infringe on the rights of others or for fraudulent purposes.</li>
                <li id="tacBulletPoints">Reverse-engineering, copying, or modifying the Service.</li>

            <p id="tacNumbering">5. Cost Estimation Tools</p>
            <small id="tacSmallDesc">The cost estimation tools provided within the Service are based on user input and industry data. While we strive for accuracy, these tools are intended for reference purposes only. Home Satisfaction does not guarantee the precision or applicability of cost estimations for real-world projects.</small>

            <p id="tacNumbering">6. Construction Project Monitoring and Liability</p>
                <li id="tacBulletPoints">The Service is a platform to assist users in monitoring construction projects and managing cost estimations. However, Home Satisfaction is not involved in the actual execution, management, or supervision of construction projects.</li>
                <li id="tacBulletPoints">Users acknowledge that construction project delays, cost overruns, and quality control issues may arise and are the responsibility of the project stakeholders, not Home Satisfaction.</li>
                <li id="tacBulletPoints">Home Satisfaction shall not be held liable for damages, delays, or disputes arising from project execution, contractor performance, or inaccuracies in the information provided by users.</li>
                <li id="tacBulletPoints">The Service is a supplementary tool and does not replace professional advice or management by licensed construction professionals.</li>

            <p id="tacNumbering">7. Intellectual Property</p>
                <li id="tacBulletPoints">All content, software, tools, and features provided through the Service are the property of Home Satisfaction or its licensors and are protected by copyright and intellectual property laws.</li>
                <li id="tacBulletPoints">Users may not copy, reproduce, distribute, or create derivative works from any content provided through the Service without express written consent.</li>

            <p id="tacNumbering">8. User-Generated Content</p>
                <li id="tacBulletPoints">You retain ownership of any content (data, project details, documents, etc.) you upload to the Service.</li>
                <li id="tacBulletPoints">You grant Home Satisfaction a non-exclusive, royalty-free license to use your content solely for operating, maintaining, and improving the Service.</li>
                <li id="tacBulletPoints">You represent and warrant that your content does not violate the rights of third parties or applicable laws.</li>

            <p id="tacNumbering">9. Privacy Policy</p>
            <small id="tacSmallDesc">Your use of the Service is also governed by our Privacy Policy, which explains how we collect, store, and use your information. By using the Service, you consent to our data practices as described in the Privacy Policy.</small>

            <p id="tacNumbering">10. Disclaimers</p>
                <li id="tacBulletPoints">The Service is provided “as is” and “as available” without warranties of any kind, express or implied.</li>
                <li id="tacBulletPoints">Home Satisfaction does not guarantee that the Service will be uninterrupted, secure, or error-free.</li>
                <li id="tacBulletPoints">We are not responsible for project delays, inaccuracies in cost estimations, or any other issues arising from the use of the Service.</li>

            <p id="tacNumbering">11. Limitation of Liability</p>
            <small id="tacSmallDesc">To the maximum extent permitted by law:</small>
                <li id="tacBulletPoints">Home Satisfaction shall not be liable for any indirect, incidental, special, or consequential damages arising out of or related to your use of the Service.</li>
                <li id="tacBulletPoints">Our total liability under these Terms shall not exceed the amount you have paid, if any, for accessing the Service.</li>
                <li id="tacBulletPoints">Home Satisfaction disclaims responsibility for any financial, legal, or physical damages related to construction projects monitored or estimated using the Service.</li>	

            <p id="tacNumbering">12. Indemnification</p>
            <small id="tacSmallDesc">You agree to indemnify, defend, and hold harmless Home Satisfaction, its affiliates, and employees from any claims, damages, losses, or liabilities arising from your breach of these Terms or misuse of the Service.</small>

            <p id="tacNumbering">13. Modifications to Terms</p>
            <small id="tacSmallDesc">We reserve the right to update or modify these Terms at any time. Changes will become effective upon posting on the Service. Your continued use of the Service after changes are posted constitutes acceptance of the updated Terms.</small>

            <p id="tacNumbering">14. Termination</p>
            <small id="tacSmallDesc">We may suspend or terminate your access to the Service without prior notice if you violate these Terms. Upon termination, your right to access the Service will cease immediately, and any content associated with your account may be deleted.</small>

            <p id="tacNumbering">15. Governing Law</p>
            <small id="tacSmallDesc">These Terms are governed by and construed in accordance with the laws of the Republic of the Philippines. You agree to submit to the exclusive jurisdiction of the courts located in Rizal, Philippines.</small>

            <p id="tacNumbering">16. Contact Us</p>
            <small id="tacSmallDesc">If you have questions about these Terms or the Service, please contact us at:</small>
            <br><br>
            <small id="tacSmallDesc"><b>Home Satisfaction</b></small><br>
            <small id="tacSmallDesc">Barangay, Piedra Blanca Homes, Blk 12 Lot 26 Alexis St, Antipolo, 1870 Rizal</small><br>
            <small id="tacSmallDesc">info@homesatisfactions.com</small><br>
            <small id="tacSmallDesc">09705739332</small>
        </div>
    </div>

    <script src="homepage.js"></script>
</body>
</html>