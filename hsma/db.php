<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hsma";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the character set to UTF-8 to prevent issues with special characters
$conn->set_charset("utf8");

?>
