<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the logged-in user's ID
    $id = $_SESSION['user']['id'];

    // Sanitize and retrieve inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if (!empty($password) && $password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password if provided
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

    try {
        // Prepare the update query
        $query = "UPDATE users 
                  SET first_name = ?, last_name = ?, username = ?, email = ?";
        
        if (!empty($password)) {
            $query .= ", password = ?";
        }

        $query .= " WHERE id = ?";

        $stmt = $conn->prepare($query);

        // Bind parameters dynamically
        if (!empty($password)) {
            $stmt->bind_param("sssssi", $first_name, $last_name, $username, $email, $hashed_password, $id);
        } else {
            $stmt->bind_param("ssssi", $first_name, $last_name, $username, $email, $id);
        }

        // Execute the query
        if ($stmt->execute()) {
            // Update session data
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;

            // Redirect back to the dashboard
            header('Location: admin_dashboard.php?success=1');
            exit;
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>
