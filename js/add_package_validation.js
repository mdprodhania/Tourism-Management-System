// Add package form validation
document.getElementById('addPackageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Clear all error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    let isValid = true;
    
    // Get form values
    const packageName = document.getElementById('package_name').value.trim();
    const destination = document.getElementById('destination').value.trim();
    const durationDays = parseInt(document.getElementById('duration_days').value);
    const durationNights = parseInt(document.getElementById('duration_nights').value);
    const price = parseFloat(document.getElementById('price').value);
    const discountPrice = document.getElementById('discount_price').value ? parseFloat(document.getElementById('discount_price').value) : null;
    const description = document.getElementById('description').value.trim();
    const itinerary = document.getElementById('itinerary').value.trim();
    const maxPersons = parseInt(document.getElementById('max_persons').value);
    
    // Validate package name
    if (packageName === '' || packageName.length < 2) {
        document.getElementById('package_name_error').textContent = 'Package name is required (min 2 characters)';
        isValid = false;
    }
    
    // Validate destination
    if (destination === '' || destination.length < 2) {
        document.getElementById('destination_error').textContent = 'Destination is required (min 2 characters)';
        isValid = false;
    }
    
    // Validate duration days
    if (durationDays < 1) {
        document.getElementById('duration_days_error').textContent = 'Duration must be at least 1 day';
        isValid = false;
    }
    
    // Validate duration nights
    if (durationNights < 0) {
        document.getElementById('duration_nights_error').textContent = 'Duration nights cannot be negative';
        isValid = false;
    }
    
    // Validate price
    if (price <= 0) {
        document.getElementById('price_error').textContent = 'Price must be greater than 0';
        isValid = false;
    }
    
    // Validate discount price
    if (discountPrice !== null && discountPrice >= price) {
        document.getElementById('discount_price_error').textContent = 'Discount price must be less than original price';
        isValid = false;
    }
    
    // Validate description
    if (description === '' || description.length < 10) {
        document.getElementById('description_error').textContent = 'Description is required (min 10 characters)';
        isValid = false;
    }
    
    // Validate itinerary
    if (itinerary === '' || itinerary.length < 10) {
        document.getElementById('itinerary_error').textContent = 'Itinerary is required (min 10 characters)';
        isValid = false;
    }
    
    // Validate max persons
    if (maxPersons < 1) {
        document.getElementById('max_persons_error').textContent = 'Max persons must be at least 1';
        isValid = false;
    }
    
    // Submit form if valid
    if (isValid) {
        this.submit();
    }
});
