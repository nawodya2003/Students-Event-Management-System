<?php
require_once 'includes/config.php';

if(is_logged_in()) {
    if(is_admin()) {
        header('Location: admin/dashboard.php'); 
        exit();
    } else {
        header('Location: events.php');
        exit();
    }
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $stmt = $pdo->prepare("SELECT user_id, name, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            if($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: events.php');
            }
            exit(); 
        } else {
            $error = 'Invalid email or password';
        }
    }
}

$page_title = 'Login';
include 'includes/header.php';
?>

<div class="form-container">
    <h2 class="text-center mb-4">Login</h2>
    
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php" id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Login</button>
        
        <p class="text-center mt-3">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>