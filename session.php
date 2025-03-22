<?php
// Start the session
session_start();

// Check if user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>