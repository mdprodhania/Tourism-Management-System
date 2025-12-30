<?php
session_start();
require_once 'includes/db_config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get package ID from URL
$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;
if ($package_id === 0) {
    header('Location: packages.php');
    exit;
}

// Get package details
$stmt = $conn->prepare("SELECT id, package_name, price, discount_price FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();
$stmt->close();

if (!$package) {
    header('Location: packages.php');
    exit;
}

$package_price = $package['discount_price'] ? $package['discount_price'] : $package['price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Package - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .booking-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .price-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        
        .btn-book {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-book:hover {
            background: #5568d3;
        }
        
        .error {
            color: #d32f2f;
            padding: 10px;
            background: #ffebee;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .success {
            color: #388e3c;
            padding: 10px;
            background: #e8f5e9;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <h2>Book: <?php echo htmlspecialchars($package['package_name']); ?></h2>
        
        <div id="message"></div>
        
        <form id="bookingForm">
            <input type="hidden" name="package_id" id="package_id" value="<?php echo $package_id; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            
            <div class="form-group">
                <label for="package_name">Package</label>
                <input type="text" id="package_name" value="<?php echo htmlspecialchars($package['package_name']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="travelDate">Travel Date *</label>
                <input type="date" id="travelDate" name="travel_date" required>
            </div>
            
            <div class="form-group">
                <label for="numPersons">Number of Persons *</label>
                <input type="number" id="numPersons" name="num_persons" min="1" max="50" value="1" required>
            </div>
            
            <div class="price-info">
                <p><strong>Price per person:</strong> $<?php echo number_format($package_price, 2); ?></p>
                <p><strong>Total Price:</strong> <span id="totalPrice">$<?php echo number_format($package_price, 2); ?></span></p>
            </div>
            
            <div class="form-group">
                <label for="specialRequests">Special Requests</label>
                <textarea id="specialRequests" name="special_requests" placeholder="Any special requests for your tour..."></textarea>
            </div>
            
            <button type="submit" class="btn-book">Complete Booking</button>
            <a href="packages.php" style="display: block; text-align: center; margin-top: 10px; color: #667eea; text-decoration: none;">← Back to Packages</a>
        </form>
    </div>
    
    <script>
        // Set minimum travel date to today
        document.getElementById('travelDate').min = new Date().toISOString().split('T')[0];
        
        // Update price calculation
        function updatePrice() {
            const persons = parseInt(document.getElementById('numPersons').value) || 1;
            const pricePerPerson = <?php echo $package_price; ?>;
            const total = pricePerPerson * persons;
            document.getElementById('totalPrice').textContent = '$' + total.toFixed(2);
        }
        
        document.getElementById('numPersons').addEventListener('change', updatePrice);
        
        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'create_booking');
            
            fetch('includes/booking_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const msgDiv = document.getElementById('message');
                if (data.success) {
                    msgDiv.className = 'success';
                    msgDiv.textContent = data.message + ' Redirecting...';
                    setTimeout(() => {
                        window.location.href = 'booking_history.php';
                    }, 2000);
                } else {
                    msgDiv.className = 'error';
                    msgDiv.textContent = data.message;
                }
            });
        });
    </script>
</body>
</html>
