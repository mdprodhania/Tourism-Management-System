// Edit package form validation
document.getElementById('editPackageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
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
    
    // Basic validation
    if (packageName === '' || packageName.length < 2) {
        isValid = false;
        alert('Package name is required (min 2 characters)');
    } else if (destination === '' || destination.length < 2) {
        isValid = false;
        alert('Destination is required (min 2 characters)');
    } else if (durationDays < 1) {
        isValid = false;
        alert('Duration must be at least 1 day');
    } else if (price <= 0) {
        isValid = false;
        alert('Price must be greater than 0');
    } else if (discountPrice !== null && discountPrice >= price) {
        isValid = false;
        alert('Discount price must be less than original price');
    } else if (description === '' || description.length < 10) {
        isValid = false;
        alert('Description is required (min 10 characters)');
    } else if (itinerary === '' || itinerary.length < 10) {
        isValid = false;
        alert('Itinerary is required (min 10 characters)');
    } else if (maxPersons < 1) {
        isValid = false;
        alert('Max persons must be at least 1');
    }
    
    // Submit form if valid
    if (isValid) {
        this.submit();
    }
});
