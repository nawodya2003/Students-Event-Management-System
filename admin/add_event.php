<?php
require_once '../includes/config.php';

if(!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $event_date = sanitize_input($_POST['event_date']);
    $event_time = sanitize_input($_POST['event_time']);
    $venue = sanitize_input($_POST['venue']);
    $organizer = sanitize_input($_POST['organizer']);
    $max_participants = (int)$_POST['max_participants'];
    
    if(empty($title) || empty($event_date) || empty($event_time) || empty($venue)) {
        $error = 'Please fill in all required fields';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO events (title, description, event_date, event_time, venue, organizer, max_participants, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            if($stmt->execute([$title, $description, $event_date, $event_time, $venue, $organizer, $max_participants, $_SESSION['user_id']])) {
                $success = 'Event created successfully!';
                // Clear form
                $_POST = array();
            }
        } catch(PDOException $e) {
            $error = 'Failed to create event. Please try again.';
        }
    }
}

$page_title = 'Add New Event';
include '../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card event-card">
            <div class="card-header">
                <h4>Create New Event</h4>
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
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_date" class="form-label">Event Date *</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="event_time" class="form-label">Event Time *</label>
                            <input type="time" class="form-control" id="event_time" name="event_time" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="venue" class="form-label">Venue *</label>
                        <input type="text" class="form-control" id="venue" name="venue" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="organizer" class="form-label">Organizer</label>
                        <input type="text" class="form-control" id="organizer" name="organizer">
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Maximum Participants</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" value="100" min="1">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Event</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>