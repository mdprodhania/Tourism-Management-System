-- Create Database
CREATE DATABASE IF NOT EXISTS tourism_db;
USE tourism_db;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Create Index for email
CREATE INDEX IF NOT EXISTS idx_email ON users(email);

-- Create Password Reset Tokens Table
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(100) NOT NULL UNIQUE,
    expires_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_user_id (user_id)
);

-- Create Packages Table
CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_name VARCHAR(150) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    duration_days INT NOT NULL,
    duration_nights INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    discount_price DECIMAL(10, 2),
    description LONGTEXT,
    itinerary LONGTEXT,
    image_url VARCHAR(500),
    max_persons INT DEFAULT 10,
    persons_booked INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_destination (destination)
);

-- Insert sample packages (optional)
INSERT INTO packages (package_name, destination, duration_days, duration_nights, price, discount_price, description, itinerary, max_persons, status) VALUES
('Beach Paradise', 'Maldives', 5, 4, 1200.00, 999.00, 'Enjoy crystal clear waters and white sand beaches in the Maldives.', 'Day 1: Arrival | Day 2-4: Beach activities and water sports | Day 5: Departure', 15, 'active'),
('Mountain Adventure', 'Nepal', 7, 6, 800.00, 699.00, 'Trek through the majestic Himalayas and experience mountain culture.', 'Day 1: Kathmandu arrival | Day 2-6: Mountain trekking | Day 7: Return to Kathmandu', 12, 'active'),
('City Explorer', 'Paris', 4, 3, 1500.00, 1299.00, 'Discover the charm and elegance of Paris, the City of Lights.', 'Day 1: Arrival & Eiffel Tower | Day 2: Louvre Museum | Day 3: Montmartre & local cuisine | Day 4: Departure', 20, 'active'),
('Safari Experience', 'Kenya', 6, 5, 1400.00, 1199.00, 'Witness the incredible wildlife of African savanna.', 'Day 1: Arrival in Nairobi | Day 2-5: Game drives | Day 6: Departure', 10, 'active'),
('Island Hopping', 'Thailand', 8, 7, 950.00, 799.00, 'Explore multiple islands with pristine beaches and vibrant nightlife.', 'Day 1: Bangkok arrival | Day 2-7: Island hopping tours | Day 8: Return', 18, 'active'),
('Historical Journey', 'Egypt', 6, 5, 1100.00, 899.00, 'Explore ancient wonders and the mysteries of Egypt.', 'Day 1: Cairo arrival | Day 2-4: Pyramids & Sphinx tours | Day 5: Nile river cruise | Day 6: Departure', 15, 'active');

-- Create Destinations Table
CREATE TABLE IF NOT EXISTS destinations (
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
);

-- Create Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
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
);

-- Create Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
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
);

-- Insert sample destinations
INSERT INTO destinations (destination_name, description, location, country, best_season, attractions, image_url, status) VALUES
('Maldives Beach', 'Tropical island paradise with pristine beaches and crystal clear waters.', 'South Asian Region', 'Maldives', 'November to April', 'Coral Reefs, Water Sports, Snorkeling, Diving', 'images/maldives.jpg', 'active'),
('Himalayan Mountains', 'Majestic mountain range with trekking trails and natural beauty.', 'Central Asia', 'Nepal', 'September to November', 'Mountain Trekking, Everest Base Camp, Local Culture', 'images/nepal.jpg', 'active'),
('Eiffel Tower Paris', 'Iconic city of lights with art, culture, and romantic ambiance.', 'Northern France', 'France', 'April to June', 'Eiffel Tower, Louvre Museum, Arc de Triomphe', 'images/paris.jpg', 'active'),
('African Safari', 'Wild African savanna with incredible wildlife and natural reserves.', 'East Africa', 'Kenya', 'June to October', 'Lion, Elephant, Giraffe, Game Drives', 'images/kenya.jpg', 'active'),
('Thai Islands', 'Tropical islands with beaches, temples, and vibrant nightlife.', 'Southeast Asia', 'Thailand', 'November to February', 'Phuket, Krabi Islands, Temples', 'images/thailand.jpg', 'active'),
('Egyptian Pyramids', 'Ancient wonders and historical monuments of Egypt.', 'North Africa', 'Egypt', 'October to April', 'Pyramids, Sphinx, Nile River, Museums', 'images/egypt.jpg', 'active');

-- Insert sample admin user (password: admin123)
INSERT INTO users (first_name, last_name, email, phone, password, role, status) VALUES
('Admin', 'User', 'admin@tourism.com', '9999999999', '$2y$10$G.yJ9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9Y9', 'admin', 'active');

-- Insert sample regular user (password: user123)
-- Uncomment to insert: password hash needs to be generated using PHP password_hash()
-- INSERT INTO users (first_name, last_name, email, phone, password, role, status) 
-- VALUES ('John', 'Doe', 'john@tourism.com', '9876543210', 'hashed_password_here', 'user', 'active');
