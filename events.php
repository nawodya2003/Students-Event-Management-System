<?php
require_once 'includes/config.php';

$stmt = $pdo->query("
    SELECT e.*, 
           (SELECT COUNT(*) FROM registrations WHERE event_id = e.event_id) as registered_count
    FROM events e
    WHERE e.event_date >= CURDATE() AND e.status = 'upcoming'
    ORDER BY e.event_date ASC
");
$events = $stmt->fetchAll();

$page_title = 'Browse Events';
include 'includes/header.php';
?>

<h2 class="mb-4">Upcoming Events</h2>

<?php if(count($events) > 0): ?>
    <div class="row">
        <?php foreach($events as $event): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card event-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                        
                        <ul class="list-unstyled mt-auto">
                            <li><strong>📅 Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></li>
                            <li><strong>🕒 Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></li>
                            <li><strong>📍 Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></li>
                            <li><strong>👥 Registered:</strong> <?php echo $event['registered_count']; ?>/<?php echo $event['max_participants']; ?></li>
                        </ul>
                        
                        <?php if(is_logged_in()): ?>
                            <?php if($event['registered_count'] >= $event['max_participants']): ?>
                                <button class="btn btn-secondary w-100" disabled>Event Full</button>
                            <?php else: ?>
                                <a href="event_registration.php?id=<?php echo $event['event_id']; ?>" class="btn btn-primary w-100">Register Now</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary w-100">Login to Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">No upcoming events at the moment. Check back later!</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>