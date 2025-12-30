<?php
require_once '../includes/admin_check.php';
require_once '../includes/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tourism Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .admin-header h1 {
            font-size: 32px;
            margin: 0;
        }

        .admin-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-header {
            padding: 10px 20px;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-header:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .content-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .section-header h2 {
            color: #333;
            margin: 0;
        }

        .btn-add {
            padding: 12px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .packages-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .packages-table thead {
            background: #f8f9fa;
        }

        .packages-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        .packages-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .packages-table tbody tr:hover {
            background: #f8f9fa;
        }

        .package-name {
            font-weight: 600;
            color: #333;
        }

        .package-price {
            color: #667eea;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit, .btn-delete, .btn-toggle {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-edit:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-toggle {
            background: #ffc107;
            color: #333;
        }

        .btn-toggle:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .search-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-filter input,
        .search-filter select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-filter input {
            flex: 1;
            min-width: 200px;
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                text-align: center;
            }

            .header-actions {
                justify-content: center;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .packages-table {
                font-size: 12px;
            }

            .packages-table th,
            .packages-table td {
                padding: 10px 5px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div>
                <h1>👨‍💼 Admin Dashboard</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</p>
            </div>
            <div class="header-actions">
                <a href="../index.php" class="btn-header">← Home</a>
                <a href="../dashboard.php" class="btn-header">Profile</a>
                <a href="../includes/logout.php" class="btn-header">Logout</a>
            </div>
        </div>

        <?php
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
        }

        // Get statistics
        $stats = [];
        
        // Total users
        $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
        $stats['total_users'] = $result->fetch_assoc()['count'];
        
        // Total packages
        $result = $conn->query("SELECT COUNT(*) as count FROM packages");
        $stats['total_packages'] = $result->fetch_assoc()['count'];
        
        // Active packages
        $result = $conn->query("SELECT COUNT(*) as count FROM packages WHERE status = 'active'");
        $stats['active_packages'] = $result->fetch_assoc()['count'];
        
        // Total bookings
        $result = $conn->query("SELECT SUM(persons_booked) as total FROM packages");
        $booking_result = $result->fetch_assoc();
        $stats['total_bookings'] = $booking_result['total'] ?? 0;
        ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_packages']; ?></div>
                <div class="stat-label">Total Packages</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['active_packages']; ?></div>
                <div class="stat-label">Active Packages</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_bookings']; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>📦 Manage Tour Packages</h2>
                <a href="add_package.php" class="btn-add">+ Add New Package</a>
            </div>

            <div class="search-filter">
                <input type="text" id="searchInput" placeholder="Search packages..." onkeyup="filterTable()">
                <select id="statusFilter" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <?php
            // Get all packages
            $result = $conn->query("SELECT * FROM packages ORDER BY created_at DESC");
            
            if ($result->num_rows > 0) {
                echo '<table class="packages-table" id="packagesTable">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Destination</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Bookings</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                while ($package = $result->fetch_assoc()) {
                    $capacity = $package['max_persons'];
                    $booked = $package['persons_booked'];
                    $discount = $package['discount_price'] ? number_format(((($package['price'] - $package['discount_price']) / $package['price']) * 100), 0) : 0;
                    $status_class = $package['status'] === 'active' ? 'status-active' : 'status-inactive';
                    $status_text = ucfirst($package['status']);
                    
                    echo '<tr>
                        <td class="package-name">' . htmlspecialchars($package['package_name']) . '</td>
                        <td>' . htmlspecialchars($package['destination']) . '</td>
                        <td class="package-price">$' . number_format($package['price'], 2) . '</td>
                        <td>' . ($discount > 0 ? $discount . '%' : 'None') . '</td>
                        <td>' . $booked . '/' . $capacity . '</td>
                        <td><span class="status-badge ' . $status_class . '">' . $status_text . '</span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit_package.php?id=' . $package['id'] . '" class="btn-edit">Edit</a>
                                <a href="../includes/delete_package.php?id=' . $package['id'] . '" class="btn-delete" onclick="return confirm(\'Are you sure?\')">Delete</a>
                            </div>
                        </td>
                    </tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<div class="no-data">
                    <p>No packages found. <a href="add_package.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Create one now</a></p>
                </div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const table = document.getElementById('packagesTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let row of rows) {
                const name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                const status = row.getElementsByTagName('td')[5].textContent.toLowerCase();

                const matchSearch = name.includes(searchInput);
                const matchStatus = !statusFilter || status.includes(statusFilter);

                row.style.display = matchSearch && matchStatus ? '' : 'none';
            }
        }
    </script>
</body>
</html>
