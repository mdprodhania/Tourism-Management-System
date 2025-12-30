// Form validation
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear all error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    let isValid = true;
    
    // Get form values
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Validate first name
    if (firstName === '') {
        document.getElementById('first_name_error').textContent = 'First name is required';
        isValid = false;
    } else if (firstName.length < 2) {
        document.getElementById('first_name_error').textContent = 'First name must be at least 2 characters';
        isValid = false;
    }
    
    // Validate last name
    if (lastName === '') {
        document.getElementById('last_name_error').textContent = 'Last name is required';
        isValid = false;
    } else if (lastName.length < 2) {
        document.getElementById('last_name_error').textContent = 'Last name must be at least 2 characters';
        isValid = false;
    }
    
    // Validate email
    if (email === '') {
        document.getElementById('email_error').textContent = 'Email is required';
        isValid = false;
    } else if (!isValidEmail(email)) {
        document.getElementById('email_error').textContent = 'Invalid email format';
        isValid = false;
    }
    
    // Validate phone (optional field)
    if (phone !== '' && !isValidPhone(phone)) {
        document.getElementById('phone_error').textContent = 'Invalid phone format';
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
    
    // Validate confirm password
    if (confirmPassword === '') {
        document.getElementById('confirm_password_error').textContent = 'Please confirm your password';
        isValid = false;
    } else if (password !== confirmPassword) {
        document.getElementById('confirm_password_error').textContent = 'Passwords do not match';
        isValid = false;
    }
    
    // Submit form if valid
    if (isValid) {
        this.submit();
    }
});

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Phone validation helper
function isValidPhone(phone) {
    const phoneRegex = /^[0-9\-\+\s\(\)]+$/;
    return phoneRegex.test(phone) && phone.length >= 7;
}

// Real-time validation feedback
document.getElementById('first_name').addEventListener('blur', function() {
    const error = document.getElementById('first_name_error');
    if (this.value.trim() === '') {
        error.textContent = 'First name is required';
    } else if (this.value.trim().length < 2) {
        error.textContent = 'First name must be at least 2 characters';
    } else {
        error.textContent = '';
    }
});

document.getElementById('last_name').addEventListener('blur', function() {
    const error = document.getElementById('last_name_error');
    if (this.value.trim() === '') {
        error.textContent = 'Last name is required';
    } else if (this.value.trim().length < 2) {
        error.textContent = 'Last name must be at least 2 characters';
    } else {
        error.textContent = '';
    }
});

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

document.getElementById('phone').addEventListener('blur', function() {
    const error = document.getElementById('phone_error');
    if (this.value !== '' && !isValidPhone(this.value)) {
        error.textContent = 'Invalid phone format';
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
