<?php
$conn = new mysqli('localhost', 'root', '', 'tourism_db');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Create Destinations Table
echo "Creating destinations table...\n";
$conn->query("CREATE TABLE IF NOT EXISTS destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    destination_name VARCHAR(150) NOT NULL UNIQUE,
    description LONGTEXT,
    location VARCHAR(255),
    country VARCHAR(100),
    best_season VARCHAR(100),
    attractions LONGTEXT,
    image_url VARCHAR(500),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status)
)");

// Create Bookings Table
echo "Creating bookings table...\n";
$conn->query("CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    travel_date DATE NOT NULL,
    num_persons INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    booking_status ENUM('active', 'cancelled', 'completed') DEFAULT 'active',
    special_requests LONGTEXT,
    cancellation_date DATETIME,
    refund_amount DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_package_id (package_id),
    INDEX idx_booking_status (booking_status)
)");

// Create Reviews Table
echo "Creating reviews table...\n";
$conn->query("CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(200),
    review_text LONGTEXT,
    review_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    admin_notes LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE,
    INDEX idx_package_id (package_id),
    INDEX idx_review_status (review_status),
    INDEX idx_user_id (user_id)
)");

// Insert sample destinations
echo "Inserting sample destinations...\n";
$destinations = [
    ['Maldives Beach', 'Tropical island paradise with pristine beaches and crystal clear waters.', 'South Asian Region', 'Maldives', 'November to April', 'Coral Reefs, Water Sports, Snorkeling, Diving', 'images/maldives.jpg'],
    ['Himalayan Mountains', 'Majestic mountain range with trekking trails and natural beauty.', 'Central Asia', 'Nepal', 'September to November', 'Mountain Trekking, Everest Base Camp, Local Culture', 'images/nepal.jpg'],
    ['Eiffel Tower Paris', 'Iconic city of lights with art, culture, and romantic ambiance.', 'Northern France', 'France', 'April to June', 'Eiffel Tower, Louvre Museum, Arc de Triomphe', 'images/paris.jpg'],
    ['African Safari', 'Wild African savanna with incredible wildlife and natural reserves.', 'East Africa', 'Kenya', 'June to October', 'Lion, Elephant, Giraffe, Game Drives', 'images/kenya.jpg'],
    ['Thai Islands', 'Tropical islands with beaches, temples, and vibrant nightlife.', 'Southeast Asia', 'Thailand', 'November to February', 'Phuket, Krabi Islands, Temples', 'images/thailand.jpg'],
    ['Egyptian Pyramids', 'Ancient wonders and historical monuments of Egypt.', 'North Africa', 'Egypt', 'October to April', 'Pyramids, Sphinx, Nile River, Museums', 'images/egypt.jpg']
];

foreach ($destinations as $dest) {
    $conn->query("INSERT IGNORE INTO destinations (destination_name, description, location, country, best_season, attractions, image_url, status) VALUES ('" . $conn->real_escape_string($dest[0]) . "', '" . $conn->real_escape_string($dest[1]) . "', '" . $conn->real_escape_string($dest[2]) . "', '" . $conn->real_escape_string($dest[3]) . "', '" . $conn->real_escape_string($dest[4]) . "', '" . $conn->real_escape_string($dest[5]) . "', '" . $conn->real_escape_string($dest[6]) . "', 'active')");
}

// Add sample users if they don't exist
echo "Adding sample users...\n";
$admin_pass = password_hash('Admin@123', PASSWORD_DEFAULT);
$user_pass = password_hash('User@123', PASSWORD_DEFAULT);

$conn->query("INSERT IGNORE INTO users (first_name, last_name, email, username, phone, password, role, status) VALUES ('Admin', 'User', 'admin@tourism.com', 'admin_user', '9999999999', '$admin_pass', 'admin', 'active')");
$conn->query("INSERT IGNORE INTO users (first_name, last_name, email, username, phone, password, role, status) VALUES ('John', 'Doe', 'user@tourism.com', 'user_tourism', '9876543210', '$user_pass', 'user', 'active')");

echo "Database setup completed successfully!\n";
echo "All tables created.\n";
echo "Sample data inserted.\n";

$conn->close();
?>
