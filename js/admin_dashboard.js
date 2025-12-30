// Check if user is admin
fetch('../includes/admin_check.php')
    .then(response => {
        if (!response.ok) {
            window.location.href = '../login.php';
        }
    });

function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Add active class to clicked link
    event.target.classList.add('active');
    
    // Load data for specific sections
    if (sectionId === 'dashboard') {
        loadDashboardStats();
    } else if (sectionId === 'destinations') {
        loadDestinations();
    } else if (sectionId === 'packages') {
        loadPackages();
    } else if (sectionId === 'users') {
        loadUsers();
    } else if (sectionId === 'bookings') {
        loadBookings();
    } else if (sectionId === 'reviews') {
        loadReviews();
    }
}

function loadDashboardStats() {
    fetch('../includes/get_packages.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const activeCount = data.packages.filter(p => p.status === 'active').length;
                document.getElementById('activePackages').textContent = activeCount;
            }
        });
}

function loadDestinations() {
    fetch('../includes/get_destinations.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('destinationsTable');
                tbody.innerHTML = data.destinations.map(dest => `
                    <tr>
                        <td>${dest.destination_name}</td>
                        <td>${dest.country}</td>
                        <td>${dest.location || '-'}</td>
                        <td><span style="background: ${dest.status === 'active' ? '#e8f5e9' : '#ffebee'}; padding: 5px 10px; border-radius: 4px; color: ${dest.status === 'active' ? '#2e7d32' : '#c62828'};">${dest.status}</span></td>
                        <td>
                            <button class="btn-small btn-edit" onclick="editDestination(${dest.id})">Edit</button>
                            <button class="btn-small btn-delete" onclick="deleteDestination(${dest.id})">Delete</button>
                        </td>
                    </tr>
                `).join('');
            }
        });
}

function openDestinationModal() {
    document.getElementById('destId').value = '';
    document.getElementById('destinationForm').reset();
    document.getElementById('destinationModal').style.display = 'block';
}

function closeDestinationModal() {
    document.getElementById('destinationModal').style.display = 'none';
}

document.getElementById('destinationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const destId = document.getElementById('destId').value;
    const action = destId ? 'update_destination' : 'add_destination';
    
    const formData = new FormData();
    formData.append('action', action);
    formData.append('destination_name', document.getElementById('destName').value);
    formData.append('country', document.getElementById('destCountry').value);
    formData.append('location', document.getElementById('destLocation').value);
    formData.append('best_season', document.getElementById('destSeason').value);
    formData.append('description', document.getElementById('destDescription').value);
    formData.append('attractions', document.getElementById('destAttractions').value);
    formData.append('image_url', document.getElementById('destImage').value);
    
    if (destId) {
        formData.append('id', destId);
    }
    
    fetch('../includes/destination_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('message-destinations');
        msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
        msgDiv.textContent = data.message;
        msgDiv.style.display = 'block';
        
        if (data.success) {
            closeDestinationModal();
            setTimeout(loadDestinations, 1500);
        }
    });
});

function editDestination(destId) {
    fetch('../includes/get_destinations.php?id=' + destId)
        .then(response => response.json())
        .then(data => {
            const dest = data.destinations[0];
            document.getElementById('destId').value = dest.id;
            document.getElementById('destName').value = dest.destination_name;
            document.getElementById('destCountry').value = dest.country;
            document.getElementById('destLocation').value = dest.location || '';
            document.getElementById('destSeason').value = dest.best_season || '';
            document.getElementById('destDescription').value = dest.description || '';
            document.getElementById('destAttractions').value = dest.attractions || '';
            document.getElementById('destImage').value = dest.image_url || '';
            document.getElementById('destinationModal').style.display = 'block';
        });
}

function deleteDestination(destId) {
    if (!confirm('Are you sure you want to delete this destination?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_destination');
    formData.append('id', destId);
    
    fetch('../includes/destination_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('message-destinations');
        msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
        msgDiv.textContent = data.message;
        msgDiv.style.display = 'block';
        
        if (data.success) {
            setTimeout(loadDestinations, 1500);
        }
    });
}

function loadPackages() {
    fetch('../includes/get_packages.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('packagesTable');
                tbody.innerHTML = data.packages.map(pkg => `
                    <tr>
                        <td>${pkg.package_name}</td>
                        <td>${pkg.destination}</td>
                        <td>${pkg.duration_days} days / ${pkg.duration_nights} nights</td>
                        <td>$${parseFloat(pkg.price).toFixed(2)}</td>
                        <td><span style="background: ${pkg.status === 'active' ? '#e8f5e9' : '#ffebee'}; padding: 5px 10px; border-radius: 4px; color: ${pkg.status === 'active' ? '#2e7d32' : '#c62828'};">${pkg.status}</span></td>
                        <td>
                            <button class="btn-small btn-edit" onclick="location.href='edit_package.php?id=${pkg.id}'">Edit</button>
                            <button class="btn-small btn-delete" onclick="deletePackage(${pkg.id})">Delete</button>
                        </td>
                    </tr>
                `).join('');
            }
        });
}

function deletePackage(pkgId) {
    if (!confirm('Are you sure you want to delete this package?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_package');
    formData.append('id', pkgId);
    
    fetch('../includes/delete_package.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('message');
        msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
        msgDiv.textContent = data.message;
        
        if (data.success) {
            setTimeout(loadPackages, 1500);
        }
    });
}

function loadUsers() {
    fetch('../includes/get_users.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('usersTable');
                tbody.innerHTML = data.users.map(user => `
                    <tr>
                        <td>${user.first_name} ${user.last_name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone || '-'}</td>
                        <td><span style="background: ${user.role === 'admin' ? '#e3f2fd' : '#f3e5f5'}; padding: 5px 10px; border-radius: 4px; color: ${user.role === 'admin' ? '#1565c0' : '#6a1b9a'};">${user.role}</span></td>
                        <td><span style="background: ${user.status === 'active' ? '#e8f5e9' : '#ffebee'}; padding: 5px 10px; border-radius: 4px; color: ${user.status === 'active' ? '#2e7d32' : '#c62828'};">${user.status}</span></td>
                        <td>
                            <button class="btn-small btn-edit" onclick="editUser(${user.id})">Edit</button>
                        </td>
                    </tr>
                `).join('');
            }
        });
}

function loadBookings() {
    fetch('../includes/get_all_bookings.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('bookingsTable');
                tbody.innerHTML = data.bookings.map(booking => `
                    <tr>
                        <td>${booking.user_name}</td>
                        <td>${booking.package_name}</td>
                        <td>${new Date(booking.travel_date).toLocaleDateString()}</td>
                        <td>${booking.num_persons}</td>
                        <td>$${parseFloat(booking.total_price).toFixed(2)}</td>
                        <td><span style="background: ${booking.booking_status === 'active' ? '#e8f5e9' : '#ffebee'}; padding: 5px 10px; border-radius: 4px; color: ${booking.booking_status === 'active' ? '#2e7d32' : '#c62828'};">${booking.booking_status}</span></td>
                    </tr>
                `).join('');
            }
        });
}

function loadReviews() {
    fetch('../includes/get_pending_reviews.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('reviewsContainer');
                if (data.reviews.length === 0) {
                    container.innerHTML = '<p>No pending reviews to moderate.</p>';
                    return;
                }
                
                container.innerHTML = data.reviews.map(review => `
                    <div style="background: #f9f9f9; padding: 20px; margin-bottom: 20px; border-radius: 8px; border-left: 4px solid #667eea;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                            <div>
                                <strong>${review.first_name} ${review.last_name}</strong> - ${review.package_name}
                                <div style="font-size: 12px; color: #999; margin-top: 3px;">Rating: ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</div>
                            </div>
                        </div>
                        <h4>${review.title}</h4>
                        <p>${review.review_text}</p>
                        <div style="display: flex; gap: 10px;">
                            <button class="btn-small btn-approve" onclick="approveReview(${review.id})">Approve</button>
                            <button class="btn-small btn-reject" onclick="rejectReview(${review.id})">Reject</button>
                        </div>
                    </div>
                `).join('');
            }
        });
}

function approveReview(reviewId) {
    const formData = new FormData();
    formData.append('action', 'approve_review');
    formData.append('review_id', reviewId);
    
    fetch('../includes/review_moderation.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('message-reviews');
        msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
        msgDiv.textContent = data.message;
        msgDiv.style.display = 'block';
        
        if (data.success) {
            setTimeout(loadReviews, 1500);
        }
    });
}

function rejectReview(reviewId) {
    const notes = prompt('Enter reason for rejection:');
    if (notes === null) return;
    
    const formData = new FormData();
    formData.append('action', 'reject_review');
    formData.append('review_id', reviewId);
    formData.append('admin_notes', notes);
    
    fetch('../includes/review_moderation.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgDiv = document.getElementById('message-reviews');
        msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
        msgDiv.textContent = data.message;
        msgDiv.style.display = 'block';
        
        if (data.success) {
            setTimeout(loadReviews, 1500);
        }
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('destinationModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Load initial dashboard
window.addEventListener('load', loadDashboardStats);
