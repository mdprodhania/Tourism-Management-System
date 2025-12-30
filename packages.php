<?php
session_start();
require_once 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .packages-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 40px;
            text-align: center;
        }

        .page-header h1 {
            font-size: 36px;
            margin: 0 0 10px 0;
        }

        .page-header p {
            font-size: 16px;
            margin: 0;
            opacity: 0.9;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-right {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-btn {
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

        .nav-btn:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .package-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .package-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
        }

        .package-content {
            padding: 25px;
        }

        .package-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .package-destination {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .package-details {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .package-description {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
            height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .package-pricing {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .price-original {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
        }

        .price-current {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }

        .price-discount {
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .package-capacity {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .capacity-bar {
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            margin-top: 5px;
            overflow: hidden;
        }

        .capacity-fill {
            height: 100%;
            background: #28a745;
            width: 0%;
            transition: width 0.3s;
        }

        .package-actions {
            display: flex;
            gap: 10px;
        }

        .btn-view {
            flex: 1;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-book {
            flex: 1;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-book:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .no-packages {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
        }

        .no-packages h3 {
            color: #666;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .no-packages p {
            color: #999;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .filter-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .filter-inputs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-inputs input,
        .filter-inputs select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .filter-btn {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .filter-btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="packages-container">
        <div class="page-header">
            <h1>🌍 Explore Our Travel Packages</h1>
            <p>Discover amazing destinations and unforgettable experiences</p>
            <div class="nav-buttons">
                <a href="index.php" class="nav-btn">← Home</a>
                <div class="nav-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="nav-btn">Dashboard</a>
                        <a href="includes/logout.php" class="nav-btn">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="nav-btn">Login</a>
                        <a href="register.php" class="nav-btn">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-title">Filter Packages</div>
            <div class="filter-inputs">
                <input type="text" id="searchInput" placeholder="Search by package name or destination..." style="flex: 1; min-width: 200px;">
                <select id="destinationFilter">
                    <option value="">All Destinations</option>
                </select>
                <button class="filter-btn" onclick="filterPackages()">Filter</button>
                <button class="filter-btn" onclick="resetFilters()" style="background: #999;">Reset</button>
            </div>
        </div>

        <div class="packages-grid" id="packagesGrid">
            <!-- Packages will be loaded here by JavaScript -->
        </div>

        <div id="noPackages" class="no-packages" style="display: none;">
            <h3>No Packages Found</h3>
            <p>Try adjusting your search filters or check back later for more packages.</p>
        </div>
    </div>
    
    <!-- Details Modal -->
    <div id="detailsModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto;">
        <div style="background: white; margin: 50px auto; padding: 30px; width: 90%; max-width: 900px; border-radius: 10px;">
            <div id="detailsContent"></div>
        </div>
    </div>

    <script>
        let allPackages = [];

        // Load packages from database
        async function loadPackages() {
            try {
                const response = await fetch('includes/get_packages.php');
                const data = await response.json();
                
                if (data.success) {
                    allPackages = data.packages;
                    displayPackages(allPackages);
                    populateDestinationFilter();
                } else {
                    console.error('Error loading packages:', data.error);
                }
            } catch (error) {
                console.error('Fetch error:', error);
            }
        }

        function displayPackages(packages) {
            const grid = document.getElementById('packagesGrid');
            const noPackages = document.getElementById('noPackages');
            
            if (packages.length === 0) {
                grid.innerHTML = '';
                noPackages.style.display = 'block';
                return;
            }

            noPackages.style.display = 'none';
            grid.innerHTML = packages.map(pkg => {
                const discount = pkg.discount_price ? Math.round(((pkg.price - pkg.discount_price) / pkg.price) * 100) : 0;
                const capacity = Math.round((pkg.persons_booked / pkg.max_persons) * 100);
                const emoji = getDestinationEmoji(pkg.destination);

                return `
                    <div class="package-card">
                        <div class="package-image">${emoji}</div>
                        <div class="package-content">
                            <div class="package-title">${escapeHtml(pkg.package_name)}</div>
                            <span class="package-destination">${escapeHtml(pkg.destination)}</span>
                            
                            <div class="package-details">
                                <div class="detail-item">📅 ${pkg.duration_days} Days</div>
                                <div class="detail-item">🌙 ${pkg.duration_nights} Nights</div>
                            </div>

                            <div class="package-description">${escapeHtml(pkg.description)}</div>

                            <div class="package-pricing">
                                ${pkg.discount_price ? `<span class="price-original">$${parseFloat(pkg.price).toFixed(2)}</span>` : ''}
                                <span class="price-current">$${parseFloat(pkg.discount_price || pkg.price).toFixed(2)}</span>
                                ${discount > 0 ? `<span class="price-discount">${discount}% OFF</span>` : ''}
                            </div>

                            <div class="package-capacity">
                                <div>Seats Available: ${pkg.max_persons - pkg.persons_booked}/${pkg.max_persons}</div>
                                <div class="capacity-bar">
                                    <div class="capacity-fill" style="width: ${capacity}%"></div>
                                </div>
                            </div>

                            <div class="package-actions">
                                <button class="btn-view" onclick="viewDetails(${pkg.id})">View Details</button>
                                <button class="btn-book" onclick="bookPackage(${pkg.id})" ${pkg.persons_booked >= pkg.max_persons ? 'disabled' : ''}>
                                    ${pkg.persons_booked >= pkg.max_persons ? 'Full' : 'Book Now'}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function getDestinationEmoji(destination) {
            const emojis = {
                'Maldives': '🏝️',
                'Nepal': '⛰️',
                'Paris': '🗼',
                'Kenya': '🦁',
                'Thailand': '🏯',
                'Egypt': '🏛️'
            };
            return emojis[destination] || '🌍';
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        function populateDestinationFilter() {
            const select = document.getElementById('destinationFilter');
            const destinations = [...new Set(allPackages.map(p => p.destination))];
            destinations.forEach(dest => {
                const option = document.createElement('option');
                option.value = dest;
                option.textContent = dest;
                select.appendChild(option);
            });
        }

        function filterPackages() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const destination = document.getElementById('destinationFilter').value;

            const filtered = allPackages.filter(pkg => {
                const matchSearch = pkg.package_name.toLowerCase().includes(search) || 
                                  pkg.destination.toLowerCase().includes(search);
                const matchDestination = !destination || pkg.destination === destination;
                return matchSearch && matchDestination;
            });

            displayPackages(filtered);
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('destinationFilter').value = '';
            displayPackages(allPackages);
        }

        function viewDetails(packageId) {
            // Find package details
            const pkg = allPackages.find(p => p.id === packageId);
            if (!pkg) return;
            
            // Load and display reviews
            fetch('includes/get_package_reviews.php?package_id=' + packageId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayPackageDetails(pkg, data.reviews, data.average_rating);
                    }
                });
        }
        
        function displayPackageDetails(pkg, reviews, avgRating) {
            const modal = document.getElementById('detailsModal');
            const content = document.getElementById('detailsContent');
            
            const reviewsHTML = reviews.length > 0 ? reviews.map(r => `
                <div style="padding: 10px 0; border-bottom: 1px solid #eee;">
                    <div style="font-weight: 600;">${r.first_name} ${r.last_name}</div>
                    <div style="color: #ffc107;">
                        ${Array(r.rating).fill('★').join('')}${Array(5-r.rating).fill('☆').join('')}
                    </div>
                    <div style="margin-top: 5px; color: #666;">${r.review_text}</div>
                </div>
            `).join('') : '<p>No reviews yet. Be the first to review!</p>';
            
            content.innerHTML = `
                <h2>${pkg.package_name}</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                    <div>
                        <h3>Package Details</h3>
                        <p><strong>Destination:</strong> ${pkg.destination}</p>
                        <p><strong>Duration:</strong> ${pkg.duration_days} Days / ${pkg.duration_nights} Nights</p>
                        <p><strong>Price:</strong> <span style="font-size: 18px; color: #667eea;">$${parseFloat(pkg.discount_price || pkg.price).toFixed(2)}</span></p>
                        <p><strong>Description:</strong> ${pkg.description}</p>
                        <p><strong>Itinerary:</strong> ${pkg.itinerary}</p>
                        <p><strong>Available Seats:</strong> ${pkg.max_persons - pkg.persons_booked}/${pkg.max_persons}</p>
                        <button class="btn-book" onclick="bookPackage(${pkg.id})" style="width: 100%; margin-top: 10px;">Book Now</button>
                    </div>
                    <div>
                        <h3>Reviews (${reviews.length})</h3>
                        <div style="background: #f9f9f9; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                            <span style="font-size: 24px; color: #ffc107;">★ ${avgRating}</span>
                            <span style="color: #999;"> / 5.0</span>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            ${reviewsHTML}
                        </div>
                    </div>
                </div>
                <button class="btn-view" onclick="closeDetails()" style="width: 100%;">Close</button>
            `;
            
            modal.style.display = 'block';
        }
        
        function closeDetails() {
            document.getElementById('detailsModal').style.display = 'none';
        }

        function bookPackage(packageId) {
            // Check if user is logged in (via PHP session)
            const userLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
            
            if (!userLoggedIn) {
                if (confirm('You need to login to book a package. Redirect to login?')) {
                    window.location.href = 'login.php';
                }
                return;
            }

            // User is logged in, proceed to booking
            window.location.href = 'booking.php?package_id=' + packageId;
        }

        // Load packages when page loads
        document.addEventListener('DOMContentLoaded', loadPackages);

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', filterPackages);
        document.getElementById('destinationFilter').addEventListener('change', filterPackages);
    </script>
</body>
</html>
