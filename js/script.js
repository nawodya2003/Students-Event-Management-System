// Wait for the DOM to be fully loaded before running script
document.addEventListener('DOMContentLoaded', function() {
  
    // --- Registration Form Validation ---
    const registerForm = document.getElementById('registrationForm'); 
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const studentId = document.getElementById('student_id').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorMessageDiv = document.getElementById('errorMessages');
            
            errorMessageDiv.innerHTML = '';
            let errors = [];
            
            // --- EDITABLE: Client-Side Validation Logic ---
            if (name === '' || email === '' || studentId === '' || password === '') {
                errors.push('All fields with * are mandatory.');
            }
            
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.length > 0 && !emailPattern.test(email)) {
                errors.push('Please enter a valid email format.');
            }
            
            if (password.length > 0 && password.length < 6) {
                errors.push('Password must be at least 6 characters long.');
            }
            
            if (password !== confirmPassword) {
                errors.push('Passwords do not match.');
            }
            // --- End of Validation Logic ---
            
            if (errors.length > 0) {
                event.preventDefault(); 
                
                let errorHTML = '<div class="alert alert-danger"><ul>';
                errors.forEach(function(error) {
                    errorHTML += '<li>' + error + '</li>';
                });
                errorHTML += '</ul></div>';
                
                errorMessageDiv.innerHTML = errorHTML;
            }
        });
    }

    // --- Admin Delete Confirmation ---
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            const isConfirmed = window.confirm('Are you sure you want to delete this? This action cannot be undone.');
            
            if (!isConfirmed) {
                event.preventDefault();
            }
        });
    });

});