<?php
// --- EDITABLE: DATABASE CONFIGURATION ---
// Change these values to match your database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'student_event_management');
// --- End of Editable Config ---


// Create connection using PDO (modern and secure)
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,       // Fetch as associative arrays
            PDO::ATTR_EMULATE_PREPARES      => false                   // Use real prepared statements
        ]
    );
} catch(PDOException $e) {
    // If connection fails, stop the script and show error
    die("Connection failed: " . $e->getMessage());
}

// Start session
// This must be on EVERY page that uses $_SESSION
// By putting it in config.php, it's included everywhere.
session_start();

// --- HELPER FUNCTIONS ---

/**
 * Basic security function to clean user text input
 * @param string $data The input data
 * @return string The sanitized data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); // Prevents XSS attacks
    return $data;
}

/**
 * Checks if a user is currently logged in
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Checks if the logged-in user is an admin
 * @return bool
 */
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>