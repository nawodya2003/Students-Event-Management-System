<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $page_title ?? 'Student Event Management'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <?php
        // Check if the current script is in the 'admin' directory
        $is_admin_page = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
        $css_path = $is_admin_page ? '../css/style.css' : 'css/style.css';
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $is_admin_page ? '../index.php' : 'index.php'; ?>">Event Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php $base_path = $is_admin_page ? '../' : ''; ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>events.php">Events</a></li>
                    
                    <?php if(is_logged_in()): ?>
                        
                        <?php if(is_admin()): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>admin/dashboard.php">Admin Panel</a></li>
                        <?php endif; ?>
                        
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>logout.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a></li>
                    
                    <?php else: ?>
                        
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>register.php">Register</a></li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container my-4">