// Reset password form validation
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    let isValid = true;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Validate password
    if (password === '') {
        document.getElementById('password_error').textContent = 'Password is required';
        isValid = false;
    } else if (password.length < 6) {
        document.getElementById('password_error').textContent = 'Password must be at least 6 characters';
        isValid = false;
    }
    
    // Validate confirm password
    if (confirmPassword === '') {
        document.getElementById('confirm_password_error').textContent = 'Please confirm your password';
        isValid = false;
    } else if (password !== confirmPassword) {
        document.getElementById('confirm_password_error').textContent = 'Passwords do not match';
        isValid = false;
    }
    
    // Submit if valid
    if (isValid) {
        this.submit();
    }
});

// Real-time validation for password
document.getElementById('password').addEventListener('blur', function() {
    const error = document.getElementById('password_error');
    if (this.value === '') {
        error.textContent = 'Password is required';
    } else if (this.value.length < 6) {
        error.textContent = 'Password must be at least 6 characters';
    } else {
        error.textContent = '';
    }
});

// Real-time validation for confirm password
document.getElementById('confirm_password').addEventListener('blur', function() {
    const error = document.getElementById('confirm_password_error');
    const password = document.getElementById('password').value;
    
    if (this.value === '') {
        error.textContent = 'Please confirm your password';
    } else if (this.value !== password) {
        error.textContent = 'Passwords do not match';
    } else {
        error.textContent = '';
    }
});

// Clear error on input
document.getElementById('password').addEventListener('input', function() {
    document.getElementById('password_error').textContent = '';
});

document.getElementById('confirm_password').addEventListener('input', function() {
    document.getElementById('confirm_password_error').textContent = '';
});
