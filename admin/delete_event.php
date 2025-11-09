<?php
// --- NEW FILE ---
// This file was linked in dashboard.php but did not exist.

require_once '../includes/config.php';

// Check if user is logged in AND is an admin
if(!is_logged_in() || !is_admin()) {
    header('Location: ../login.php'); // Redirect to login
    exit();
}

// Get the event ID from the URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($event_id > 0) {
    try {
        // We must delete from 'registrations' first due to foreign key constraints
        $stmt = $pdo->prepare("DELETE FROM registrations WHERE event_id = ?");
        $stmt->execute([$event_id]);
        
        // Now we can delete the event itself
        $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt->execute([$event_id]);
        
        // TODO: Add a success message to the session
        
    } catch (PDOException $e) {
        // TODO: Add an error message to the session
        // echo "Error: " . $e->getMessage();
    }
}

// Redirect back to the dashboard
header('Location: dashboard.php');
exit();
?>