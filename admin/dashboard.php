<?php
// All admin pages must include config.php from the parent directory
require_once '../includes/config.php';

// Check if user is logged in AND is an admin
if(!is_logged_in() || !is_admin()) {
    header('Location: ../login.php'); // Redirect to login
    exit();
}

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as count FROM events");
$total_events = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$total_students = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM registrations");
$total_registrations = $stmt->fetch()['count'];

// Get recent events
$stmt = $pdo->query("
    SELECT e.*, 
           (SELECT COUNT(*) FROM registrations WHERE event_id = e.event_id) as reg_count
    FROM events e
    ORDER BY e.created_at DESC
    LIMIT 5
");
$recent_events = $stmt->fetchAll();

$page_title = 'Admin Dashboard';
include '../includes/header.php'; // Include header from parent directory
?>

<h2 class="mb-4">Admin Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card admin-stat-card bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Events</h5>
                <h2 class="display-6"><?php echo $total_events; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card admin-stat-card bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Students</h5>
                <h2 class="display-6"><?php echo $total_students; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card admin-stat-card bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Registrations</h5>
                <h2 class="display-6"><?php echo $total_registrations; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card event-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Events</h5>
        <a href="add_event.php" class="btn btn-primary btn-sm">Add New Event</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Registrations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($recent_events) > 0): ?>
                        <?php foreach($recent_events as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                                <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                <td><?php echo $event['reg_count']; ?>/<?php echo $event['max_participants']; ?></td>
                                <td>
                                    <a href="edit_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="view_registrations.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="delete_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-danger delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No events found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; // Include footer from parent directory ?>