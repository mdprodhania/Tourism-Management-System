// Forgot password form validation
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear error messages
    document.getElementById('email_error').textContent = '';
    
    let isValid = true;
    const email = document.getElementById('email').value.trim();
    
    // Validate email
    if (email === '') {
        document.getElementById('email_error').textContent = 'Email is required';
        isValid = false;
    } else if (!isValidEmail(email)) {
        document.getElementById('email_error').textContent = 'Invalid email format';
        isValid = false;
    }
    
    // Submit if valid
    if (isValid) {
        this.submit();
    }
});

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Real-time validation
document.getElementById('email').addEventListener('blur', function() {
    const error = document.getElementById('email_error');
    if (this.value.trim() === '') {
        error.textContent = 'Email is required';
    } else if (!isValidEmail(this.value.trim())) {
        error.textContent = 'Invalid email format';
    } else {
        error.textContent = '';
    }
});

document.getElementById('email').addEventListener('input', function() {
    document.getElementById('email_error').textContent = '';
});
