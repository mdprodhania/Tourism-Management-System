<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tourism Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background: #f5f5f5;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: #333;
            color: white;
            padding: 20px;
        }
        
        .sidebar h2 {
            color: #667eea;
            margin-bottom: 30px;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-menu li {
            margin-bottom: 15px;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        .nav-menu a:hover,
        .nav-menu a.active {
            background: #667eea;
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
        
        .admin-header h1 {
            color: #333;
        }
        
        .btn-logout {
            background: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-logout:hover {
            background: #da190b;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
        }
        
        .content-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            display: none;
        }
        
        .content-section.active {
            display: block;
        }
        
        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        
        .btn-primary:hover {
            background: #5568d3;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead {
            background: #f9f9f9;
        }
        
        .table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        
        .table td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .btn-small {
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 12px;
        }
        
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        
        .btn-delete {
            background: #f44336;
            color: white;
        }
        
        .btn-approve {
            background: #4CAF50;
            color: white;
        }
        
        .btn-reject {
            background: #ff9800;
            color: white;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul class="nav-menu">
                <li><a href="#" onclick="showSection('dashboard')" class="nav-link active">Dashboard</a></li>
                <li><a href="#" onclick="showSection('destinations')" class="nav-link">Destinations</a></li>
                <li><a href="#" onclick="showSection('packages')" class="nav-link">Packages</a></li>
                <li><a href="#" onclick="showSection('users')" class="nav-link">Users</a></li>
                <li><a href="#" onclick="showSection('bookings')" class="nav-link">Bookings</a></li>
                <li><a href="#" onclick="showSection('reviews')" class="nav-link">Reviews</a></li>
                <li><a href="includes/logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <button class="btn-logout" onclick="location.href='includes/logout.php'">Logout</button>
            </div>
            
            <div id="message"></div>
            
            <!-- Dashboard Section -->
            <div id="dashboard" class="content-section active">
                <h2 class="section-title">Dashboard Overview</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Bookings</h3>
                        <div class="value" id="totalBookings">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Active Packages</h3>
                        <div class="value" id="activePackages">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Users</h3>
                        <div class="value" id="totalUsers">0</div>
                    </div>
                    <div class="stat-card">
                        <h3>Pending Reviews</h3>
                        <div class="value" id="pendingReviews">0</div>
                    </div>
                </div>
            </div>
            
            <!-- Destinations Section -->
            <div id="destinations" class="content-section">
                <h2 class="section-title">Manage Destinations</h2>
                <button class="btn-primary" onclick="openDestinationModal()">+ Add Destination</button>
                <div id="message-destinations" class="message" style="display: none;"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="destinationsTable">
                        <tr><td colspan="5">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Packages Section -->
            <div id="packages" class="content-section">
                <h2 class="section-title">Manage Packages</h2>
                <button class="btn-primary" onclick="location.href='add_package.php'">+ Add Package</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Destination</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="packagesTable">
                        <tr><td colspan="6">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Users Section -->
            <div id="users" class="content-section">
                <h2 class="section-title">Manage Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        <tr><td colspan="6">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Bookings Section -->
            <div id="bookings" class="content-section">
                <h2 class="section-title">Manage Bookings</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Package</th>
                            <th>Travel Date</th>
                            <th>Persons</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsTable">
                        <tr><td colspan="6">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Reviews Section -->
            <div id="reviews" class="content-section">
                <h2 class="section-title">Moderate Reviews</h2>
                <div id="message-reviews" class="message" style="display: none;"></div>
                <div id="reviewsContainer"></div>
            </div>
        </div>
    </div>
    
    <!-- Destination Modal -->
    <div id="destinationModal" class="modal">
        <div class="modal-content">
            <h2>Add/Edit Destination</h2>
            <form id="destinationForm">
                <input type="hidden" id="destId">
                
                <div class="form-group">
                    <label>Destination Name *</label>
                    <input type="text" id="destName" required>
                </div>
                
                <div class="form-group">
                    <label>Country *</label>
                    <input type="text" id="destCountry" required>
                </div>
                
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" id="destLocation">
                </div>
                
                <div class="form-group">
                    <label>Best Season</label>
                    <input type="text" id="destSeason">
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="destDescription"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Attractions</label>
                    <textarea id="destAttractions"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="url" id="destImage">
                </div>
                
                <button type="submit" class="btn-primary">Save Destination</button>
                <button type="button" class="btn-primary" style="background: #999;" onclick="closeDestinationModal()">Cancel</button>
            </form>
        </div>
    </div>
    
    <script src="../js/admin_dashboard.js"></script>
</body>
</html>
