</main> 
    <footer class="mt-auto py-3">
        <div class="container ">
            <p>23IT0522 | Student Event Management System</p>
            <p>-- All rights reserved --</p>
        </div>
    </footer>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    
    <?php
        // Check if the current script is in the 'admin' directory
        $is_admin_page = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
        $js_path = $is_admin_page ? '../js/script.js' : 'js/script.js';
    ?>
    <script src="<?php echo $js_path; ?>"></script>
</body>
</html>