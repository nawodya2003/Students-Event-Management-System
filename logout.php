<?php
// Start the session to access it
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the homepage
header('Location: index.php');
exit();
?>