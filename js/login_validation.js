// Login form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear all error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    let isValid = true;
    
    // Get form values
    const login = document.getElementById('login').value.trim();
    const password = document.getElementById('password').value;
    
    // Validate login (username or email)
    if (login === '') {
        document.getElementById('login_error').textContent = 'Username or email is required';
        isValid = false;
    }
    
    // Validate password
    if (password === '') {
        document.getElementById('password_error').textContent = 'Password is required';
        isValid = false;
    } else if (password.length < 6) {
        document.getElementById('password_error').textContent = 'Password must be at least 6 characters';
        isValid = false;
    }
    
    // Submit form if valid
    if (isValid) {
        this.submit();
    }
});

// Real-time validation feedback
document.getElementById('login').addEventListener('blur', function() {
    const error = document.getElementById('login_error');
    if (this.value.trim() === '') {
        error.textContent = 'Username or email is required';
    } else {
        error.textContent = '';
    }
});

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

// Clear error messages on input
document.getElementById('login').addEventListener('input', function() {
    document.getElementById('login_error').textContent = '';
});

document.getElementById('password').addEventListener('input', function() {
    document.getElementById('password_error').textContent = '';
});
