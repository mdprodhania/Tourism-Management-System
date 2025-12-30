<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .history-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
        }
        
        .bookings-grid {
            display: grid;
            gap: 20px;
            margin-top: 30px;
        }
        
        .booking-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .booking-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .booking-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }
        
        .status-completed {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        
        .detail-item {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .detail-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .booking-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-cancel {
            background: #f44336;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #da190b;
        }
        
        .btn-review {
            background: #667eea;
            color: white;
        }
        
        .btn-review:hover {
            background: #5568d3;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .error {
            background: #ffebee;
            color: #d32f2f;
        }
        
        .success {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="history-container">
        <h1>My Booking History</h1>
        <p>View and manage your tour bookings</p>
        
        <div id="message"></div>
        <div id="bookingsContainer" class="bookings-grid"></div>
    </div>
    
    <!-- Review Modal -->
    <div id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="background: white; margin: 50px auto; padding: 30px; width: 90%; max-width: 500px; border-radius: 8px;">
            <h2>Submit Review</h2>
            <form id="reviewForm">
                <input type="hidden" id="reviewBookingId">
                <input type="hidden" id="reviewPackageId">
                
                <div style="margin-bottom: 15px;">
                    <label>Rating *</label>
                    <select id="reviewRating" name="rating" required>
                        <option value="">Select rating</option>
                        <option value="5">★★★★★ Excellent</option>
                        <option value="4">★★★★ Good</option>
                        <option value="3">★★★ Average</option>
                        <option value="2">★★ Poor</option>
                        <option value="1">★ Very Poor</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>Title *</label>
                    <input type="text" id="reviewTitle" name="title" placeholder="Review title" required>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>Review *</label>
                    <textarea id="reviewText" name="review_text" placeholder="Share your experience..." required style="min-height: 100px;"></textarea>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-review">Submit Review</button>
                    <button type="button" class="btn" style="background: #999; color: white;" onclick="document.getElementById('reviewModal').style.display='none'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Check if user is logged in
        fetch('includes/session_check.php')
            .then(response => {
                if (!response.ok) {
                    window.location.href = 'login.php';
                }
            });
        
        function loadBookings() {
            fetch('includes/get_user_bookings.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('bookingsContainer');
                        if (data.bookings.length === 0) {
                            container.innerHTML = '<div class="empty-state"><p>No bookings found. <a href="packages.php">Browse packages</a></p></div>';
                            return;
                        }
                        
                        container.innerHTML = data.bookings.map(booking => `
                            <div class="booking-card">
                                <div class="booking-header">
                                    <div>
                                        <div class="booking-title">${booking.package_name} - ${booking.destination}</div>
                                        <div style="font-size: 12px; color: #999;">Booking ID: #${booking.id}</div>
                                    </div>
                                    <span class="booking-status status-${booking.booking_status}">${booking.booking_status.toUpperCase()}</span>
                                </div>
                                
                                <div class="booking-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Travel Date</div>
                                        <div class="detail-value">${new Date(booking.travel_date).toLocaleDateString()}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Persons</div>
                                        <div class="detail-value">${booking.num_persons}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Total Price</div>
                                        <div class="detail-value">$${parseFloat(booking.total_price).toFixed(2)}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Status</div>
                                        <div class="detail-value">${booking.payment_status.toUpperCase()}</div>
                                    </div>
                                </div>
                                
                                <div class="booking-actions">
                                    ${booking.booking_status === 'active' ? `
                                        <button class="btn btn-cancel" onclick="cancelBooking(${booking.id})">Cancel Booking</button>
                                    ` : ''}
                                    ${booking.booking_status === 'completed' ? `
                                        <button class="btn btn-review" onclick="openReviewModal(${booking.id}, ${booking.package_id})">Leave Review</button>
                                    ` : ''}
                                </div>
                            </div>
                        `).join('');
                    }
                });
        }
        
        function cancelBooking(bookingId) {
            if (!confirm('Are you sure you want to cancel this booking?')) return;
            
            const formData = new FormData();
            formData.append('booking_id', bookingId);
            
            fetch('includes/cancel_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const msgDiv = document.getElementById('message');
                msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
                msgDiv.textContent = data.message;
                if (data.success) {
                    setTimeout(loadBookings, 1500);
                }
            });
        }
        
        function openReviewModal(bookingId, packageId) {
            document.getElementById('reviewBookingId').value = bookingId;
            document.getElementById('reviewPackageId').value = packageId;
            document.getElementById('reviewForm').reset();
            document.getElementById('reviewModal').style.display = 'block';
        }
        
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'submit_review');
            formData.append('booking_id', document.getElementById('reviewBookingId').value);
            formData.append('package_id', document.getElementById('reviewPackageId').value);
            
            fetch('includes/review_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const msgDiv = document.getElementById('message');
                msgDiv.className = 'message ' + (data.success ? 'success' : 'error');
                msgDiv.textContent = data.message;
                document.getElementById('reviewModal').style.display = 'none';
                if (data.success) {
                    setTimeout(loadBookings, 1500);
                }
            });
        });
        
        // Load bookings on page load
        loadBookings();
    </script>
</body>
</html>
