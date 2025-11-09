<?php
require_once '../includes/config.php';

if(!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch event
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if(!$event) {
    header('Location: dashboard.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $event_date = sanitize_input($_POST['event_date']);
    $event_time = sanitize_input($_POST['event_time']);
    $venue = sanitize_input($_POST['venue']);
    $organizer = sanitize_input($_POST['organizer']);
    $max_participants = (int)$_POST['max_participants'];
    $status = sanitize_input($_POST['status']);
    
    if(empty($title) || empty($event_date) || empty($event_time) || empty($venue)) {
        $error = 'Please fill in all required fields';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE events 
                SET title = ?, description = ?, event_date = ?, event_time = ?, 
                    venue = ?, organizer = ?, max_participants = ?, status = ?
                WHERE event_id = ?
            ");
            
            if($stmt->execute([$title, $description, $event_date, $event_time, $venue, $organizer, $max_participants, $status, $event_id])) {
                $success = 'Event updated successfully!';
                // Refresh event data
                $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
                $stmt->execute([$event_id]);
                $event = $stmt->fetch();
            }
        } catch(PDOException $e) {
            $error = 'Failed to update event. Please try again.';
        }
    }
}

$page_title = 'Edit Event';
include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        
        <div class="card event-card">
            <div class="card-header">
                <h4>Edit Event</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title *</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($event['description']); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_date" class="form-label">Event Date *</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="event_time" class="form-label">Event Time *</label>
                            <input type="time" class="form-control" id="event_time" name="event_time" value="<?php echo $event['event_time']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="venue" class="form-label">Venue *</label>
                        <input type="text" class="form-control" id="venue" name="venue" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="organizer" class="form-label">Organizer</label>
                        <input type="text" class="form-control" id="organizer" name="organizer" value="<?php echo htmlspecialchars($event['organizer']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Maximum Participants</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo $event['max_participants']; ?>" min="1">
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class_ ="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="upcoming" <?php echo $event['status'] == 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                            <option value="ongoing" <?php echo $event['status'] == 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                            <option value="completed" <?php echo $event['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>