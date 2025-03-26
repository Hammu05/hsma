<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// JavaScript alert and redirect
echo "<script>
    alert('You have successfully logged out.');
    window.location.href = 'homepage.php'; // Redirect to homepage or login page
</script>";
exit;
?>