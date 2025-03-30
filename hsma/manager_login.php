<?php
session_start();
include 'db.php'; // Include database connection

// Handle admin registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_admin'])) {
    $firstname = trim($_POST['first_name']);
    $lastname = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
        } else {
            // Insert into database with admin role
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $role = 'admin';
            $stmt->bind_param("ssssss", $firstname, $lastname, $username, $email, $hashed_password, $role);
            $stmt->execute();

            echo "<script>alert('Admin registration successful! You can now log in as admin.');</script>";
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
                if ($role == 'manager') {
                    header('Location: manager_quotation.php');
                } else {
                    echo "<script>alert('Unknown role. Contact administrator.');</script>";
                    echo "<script>window.location.href = 'manager_login.php';</script>";
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
    <link rel="stylesheet" href="manager_login.css">
</head>

<body>

    <div class="homepage">
        <button class="btnlogin-popup">Manager</button>
    </div>

    <div class="wrapper">
        <span class="icon-close">
            <img src="close.png" alt="close">
        </span>

        <!-- Login Form -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="manager_login.php" method="POST"> <!-- Change form action to homepage.php -->
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
</div>

                <button type="submit" name="login" class="btn">Login</button>

                <div class="login-register">
                    <p><a href="#" class="register-link"></a></p>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-box register">
            <h2>Register</h2>
            <form action="manager_login.php" method="POST">


            
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

                <button type="submit" name="register" class="btn">Register</button>

                <div class="login-register">
                    <p><a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="manager_login.js"></script>
</body>
</html>