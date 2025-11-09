<?php
require_once 'includes/config.php';

if(!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 

$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if(!$event) {
    header('Location: events.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM registrations WHERE user_id = ? AND event_id = ?");
$stmt->execute([$_SESSION['user_id'], $event_id]);
$already_registered = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST' && !$already_registered) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM registrations WHERE event_id = ?");
        $stmt->execute([$event_id]);
        $registered_count = $stmt->fetch()['count'];
        
        if($registered_count >= $event['max_participants']) {
            $error = 'Sorry, this event is fully booked.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $event_id]);
            $success = 'Registration successful! You are now registered for this event.';
            $already_registered = true; 
        }
    } catch(PDOException $e) {
        $error = 'Registration failed. You might already be registered.';
    }
}

$page_title = 'Event Registration';
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card event-card">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h2>
                <hr>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <div class="event-details mb-4">
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                    <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></p>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                    <p><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer']); ?></p>
                </div>
                
                <?php if($already_registered): ?>
                    <div class="alert alert-success">
                        ✓ You are already registered for this event!
                    </div>
                    <a href="events.php" class="btn btn-secondary">Back to Events</a>
                <?php else: ?>
                    <form method="POST" action="" id="eventRegForm">
                        <div class="alert alert-info">
                            <strong>Confirm your registration for this event</strong>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Your Email</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Confirm Registration</button>
                        <a href="events.php" class="btn btn-secondary">Cancel</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>