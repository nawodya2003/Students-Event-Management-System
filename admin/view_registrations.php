<?php
// --- FIXED: Renamed file from view_reji'.php to view_registrations.php ---
require_once '../includes/config.php';

if(!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit();
}

$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if(!$event) {
    header('Location: dashboard.php');
    exit();
}

// Fetch registrations
$stmt = $pdo->prepare("
    SELECT r.*, u.name, u.email, u.student_id, u.contact_number
    FROM registrations r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.event_id = ?
    ORDER BY r.registration_date DESC
");
$stmt->execute([$event_id]);
$registrations = $stmt->fetchAll();

$page_title = 'View Registrations';
include '../includes/header.php';
?>

<div class="card event-card">
    <div class="card-header">
        <h4><?php echo htmlspecialchars($event['title']); ?> - Registrations</h4>
        <p class="mb-0">Total Registered: <?php echo count($registrations); ?>/<?php echo $event['max_participants']; ?></p>
    </div>
    <div class="card-body">
        <?php if(count($registrations) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($registrations as $index => $reg): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($reg['name']); ?></td>
                                <td><?php echo htmlspecialchars($reg['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($reg['email']); ?></td>
                                <td><?php echo htmlspecialchars($reg['contact_number']); ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($reg['registration_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $reg['status'] == 'registered' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($reg['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <button onclick="window.print()" class="btn btn-secondary">Print List</button>
                <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No registrations yet for this event.</div>
            <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>