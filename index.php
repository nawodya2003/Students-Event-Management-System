<?php
require_once 'includes/config.php';
$page_title = 'Home - Student Event Management';
include 'includes/header.php';
?>

<div class="welcome-hero  ">
    <h1 class="display-4">Welcome to Student Event Management</h1>
    <p class="lead">Your one-stop platform for discovering and registering for campus events</p>
    <hr class="my-4">
    <p>Browse upcoming workshops, seminars, and more!</p>
    
    <a class="btn btn-primary btn-lg" href="events.php" role="button">Browse Events</a>
    
    <?php if(!is_logged_in()): ?>
        <a class="btn btn-success btn-lg" href="register.php" role="button">Register Now</a>
    <?php endif; ?>
</div>

<div class="row mt-5">
    <div class="col-md-4 mb-4">
        <div class="card event-card h-100">
            <div class="card-body text-center">
                <h3 style="font-size: 3rem;">📅</h3>
                <h5 class="card-title">Easy Registration</h5>
                <p class="card-text">Register for events with just a few clicks</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card event-card h-100">
            <div class="card-body text-center">
                <h3 style="font-size: 3rem;">🔔</h3>
                <h5 class="card-title">Stay Updated</h5>
                <p class="card-text">Get notified about upcoming events</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card event-card h-100">
            <div class="card-body text-center">
                <h3 style="font-size: 3rem;">🎓</h3>
                <h5 class="card-title">Learn & Network</h5>
                <p class="card-text">Participate in workshops and seminars</p>
            </div>
        </div>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>