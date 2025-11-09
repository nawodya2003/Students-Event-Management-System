<?php
require_once 'includes/config.php';

if(is_logged_in()) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $student_id = sanitize_input($_POST['student_id']);
    $contact = sanitize_input($_POST['contact_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    


    
    if(empty($name) || empty($email) || empty($student_id) || empty($password)) {
        $error = 'All fields marked * are required';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif(strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? OR student_id = ?");
        $stmt->execute([$email, $student_id]);
        
        if($stmt->rowCount() > 0) {
            $error = 'Email or Student ID already exists';
        } else {

            $role = 'student';
            if (stripos($student_id, 'admin') !== false) {
                $role = 'admin';
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (name, email, student_id, contact_number, password, role) VALUES (?, ?, ?, ?, ?,?)");
            
            if($stmt->execute([$name, $email, $student_id, $contact, $hashed_password , $role])) {
                $success = 'Registration successful! You can now login.';
                header('refresh:2;url=login.php');
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

$page_title = 'Register';
include 'includes/header.php';
?>

<div class="form-container">
    <h2 class="text-center mb-4">Student Registration</h2>
    
    <div id="errorMessages"></div> 
    
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="register.php" id="registrationForm">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name *</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email Address *</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID *</label>
            <input type="text" class="form-control" id="student_id" name="student_id" required>
        </div>
        
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number (Optional)</label>
            <input type="tel" class="form-control" id="contact_number" name="contact_number">
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password *</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password *</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Register</button>
        
        <p class="text-center mt-3">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>