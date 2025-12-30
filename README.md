# Tourism Management System

A comprehensive web application for managing tourism packages, destinations, bookings, and customer reviews. Features complete admin and user management with secure authentication.
https://mdprodhania.github.io/Tourism-Management-System/

## 🌟 Features

### 1. **User Management**
- ✅ User registration with validation
- ✅ Secure login/logout system
- ✅ Password reset via email
- ✅ User profile management
- ✅ Session timeout protection (24 hours)

### 2. **Admin Login & Management**
- ✅ Secure admin authentication
- ✅ Admin-only dashboard access
- ✅ User role management (admin/user)
- ✅ Admin session validation

### 3. **Destination Management (CRUD)**
- ✅ Add new tourist destinations
- ✅ Edit destination details
- ✅ Delete destinations
- ✅ View destination information
- ✅ Manage destination status (active/inactive)
- ✅ Store attractions, best season, location info

### 4. **Tour Package Management (CRUD)**
- ✅ Create tour packages
- ✅ Edit package details (name, price, duration, itinerary)
- ✅ Delete packages
- ✅ Track booking capacity and availability
- ✅ Offer discount pricing
- ✅ Manage package status

### 5. **User Booking System**
- ✅ Browse available packages
- ✅ View package details and reviews
- ✅ Create bookings with date and person selection
- ✅ Automatic price calculation
- ✅ Payment status tracking
- ✅ Special requests support

### 6. **Booking History & Cancellation**
- ✅ View all user bookings
- ✅ Display booking details (dates, persons, price, status)
- ✅ Cancel bookings within 7 days before travel
- ✅ Automatic refund calculation (100% refund)
- ✅ Booking status tracking

### 7. **Review & Rating System**
- ✅ Users can submit reviews for completed bookings
- ✅ Rating system (1-5 stars)
- ✅ Admin review moderation
- ✅ Approve/reject reviews
- ✅ Display approved reviews on packages
- ✅ Average rating calculation

## 📁 Project Structure

```
Tourism Management System/
├── index.php                          # Home page
├── login.php                          # User login
├── register.php                       # User registration
├── forgot_password.php                # Password reset request
├── reset_password.php                 # Password reset form
├── dashboard.php                      # User dashboard
├── packages.php                       # Browse packages
├── booking.php                        # Book a package
├── booking_history.php                # View bookings & manage
│
├── admin/
│   ├── index.php                      # Admin dashboard
│   ├── add_package.php                # Add new package
│   ├── edit_package.php               # Edit package
│   └── dashboard.php                  # Admin panel
│
├── includes/
│   ├── db_config.php                  # Database configuration
│   ├── session_check.php              # Session validation
│   ├── admin_check.php                # Admin access check
│   ├── login_handler.php              # Login processing
│   ├── register_handler.php           # Registration processing
│   ├── logout.php                     # Logout functionality
│   ├── forgot_password_handler.php    # Password reset request
│   ├── reset_password_handler.php     # Password reset processing
│   ├── booking_handler.php            # Create bookings
│   ├── cancel_booking.php             # Cancel bookings
│   ├── get_user_bookings.php          # Retrieve user bookings
│   ├── get_package_reviews.php        # Get package reviews
│   ├── get_packages.php               # Get all packages
│   ├── get_destinations.php           # Get all destinations
│   ├── destination_handler.php        # Destination CRUD
│   ├── review_handler.php             # Submit reviews
│   ├── review_moderation.php          # Moderate reviews
│   ├── get_pending_reviews.php        # Get reviews pending approval
│   ├── get_users.php                  # Admin: get all users
│   ├── get_all_bookings.php           # Admin: get all bookings
│   ├── add_package.php                # Add package (legacy)
│   ├── edit_package.php               # Edit package (legacy)
│   └── delete_package.php             # Delete package
│
├── database/
│   └── setup.sql                      # Database & table creation
│
├── css/
│   └── style.css                      # Main stylesheet
│
├── js/
│   ├── validation.js                  # Form validation
│   ├── login_validation.js            # Login form validation
│   ├── admin_dashboard.js             # Admin panel functionality
│   ├── add_package_validation.js      # Add package validation
│   ├── edit_package_validation.js     # Edit package validation
│   ├── forgot_password_validation.js  # Password reset validation
│   └── reset_password_validation.js   # Password reset validation
│
├── logs/                              # Application logs
└── README.md                          # This file
```

## 🗄️ Database Schema

### Tables Created:

1. **users**
   - Stores user accounts with roles (user/admin)
   - Fields: id, first_name, last_name, email, phone, password, role, status, created_at, updated_at

2. **password_reset_tokens**
   - Manages password reset requests
   - Fields: id, user_id, token, expires_at, created_at

3. **destinations**
   - Tourist destinations information
   - Fields: id, destination_name, description, location, country, best_season, attractions, image_url, status, created_at, updated_at

4. **packages**
   - Tour packages
   - Fields: id, package_name, destination, duration_days, duration_nights, price, discount_price, description, itinerary, image_url, max_persons, persons_booked, status, created_at, updated_at

5. **bookings**
   - User bookings
   - Fields: id, user_id, package_id, booking_date, travel_date, num_persons, total_price, payment_status, booking_status, special_requests, cancellation_date, refund_amount, created_at, updated_at

6. **reviews**
   - Package reviews and ratings
   - Fields: id, booking_id, user_id, package_id, rating (1-5), title, review_text, review_status (pending/approved/rejected), admin_notes, created_at, updated_at

## Installation Steps

### Prerequisites
- XAMPP (PHP 7.0+, MySQL 5.6+)
- Web browser
- Text editor

### Setup Instructions

1. **Clone/Extract Project**
   ```bash
   Extract the project to: C:\xampp\htdocs\Tourism Management System
   ```

2. **Create Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create new database: `tourism_db`
   - Select the database
   - Go to "Import" tab
   - Choose `database/setup.sql` file
   - Click "Go" to execute SQL

3. **Configure Database**
   - File: `includes/db_config.php` is already configured
   - Default settings:
     - Host: localhost
     - User: root
     - Password: (empty)
     - Database: tourism_db

4. **Start Server**
   - Start XAMPP (Apache & MySQL)
   - Access application: http://localhost/Tourism%20Management%20System/

## 🔐 Default Credentials

### Admin Account
- **Email:** admin@tourism.com
- **Password:** admin123

### Test User (Optional)
- **Email:** user@tourism.com
- **Password:** user123

## 📊 User Workflows

### For Regular Users:

1. **Registration → Login**
   - Register with email and password
   - Login to access booking system

2. **Browse & Book Packages**
   - View available packages with details
   - Read reviews and ratings
   - Select travel date and number of persons
   - Complete booking

3. **Manage Bookings**
   - View booking history
   - Cancel bookings (7+ days before travel)
   - Submit reviews for completed tours
   - Track refunds

### For Admins:

1. **Login to Admin Panel**
   - Access: http://localhost/Tourism%20Management%20System/admin/
   - Admin credentials required

2. **Manage Destinations**
   - Add/Edit/Delete destinations
   - Set best season and attractions
   - Manage destination status

3. **Manage Packages**
   - Create tour packages
   - Set pricing and discounts
   - Define itineraries
   - Track booking capacity

4. **Manage Users**
   - View all registered users
   - Monitor user accounts
   - Manage user roles

5. **View Bookings**
   - Monitor all user bookings
   - Track payment status
   - View booking details

6. **Moderate Reviews**
   - Approve/reject pending reviews
   - Add admin notes
   - Manage review quality

## 🔒 Security Features

- ✅ Password hashing using bcrypt ($2y$10)
- ✅ SQL injection prevention with prepared statements
- ✅ Session management with timeout
- ✅ Admin access verification
- ✅ User role validation
- ✅ CSRF protection ready
- ✅ Email validation
- ✅ Input sanitization

## 📱 Features by Role

### User Features:
- Register and manage account
- Browse packages with filters
- View detailed package information
- Submit bookings with date selection
- View booking history
- Cancel bookings (with restrictions)
- Submit reviews and ratings
- View approved reviews

### Admin Features:
- Full dashboard with statistics
- Destination CRUD operations
- Package CRUD operations
- User management
- Booking oversight
- Review moderation
- Status tracking and reports

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Backend:** PHP 7.0+
- **Database:** MySQL
- **Server:** Apache (XAMPP)
- **Authentication:** Sessions with bcrypt hashing

## 📝 Sample Data Included

The setup.sql file includes sample data:

### Sample Packages (6):
1. Beach Paradise - Maldives
2. Mountain Adventure - Nepal
3. City Explorer - Paris
4. Safari Experience - Kenya
5. Island Hopping - Thailand
6. Historical Journey - Egypt

### Sample Destinations (6):
1. Maldives Beach
2. Himalayan Mountains
3. Eiffel Tower Paris
4. African Safari
5. Thai Islands
6. Egyptian Pyramids

## 🐛 Testing Checklist

- [x] Admin login with valid credentials
- [x] Admin login rejection with invalid credentials
- [x] User registration and login
- [x] Password reset functionality
- [x] Destination CRUD operations
- [x] Package CRUD operations
- [x] Create booking with validation
- [x] View booking history
- [x] Cancel booking (with date validation)
- [x] Submit review for completed booking
- [x] Admin review moderation
- [x] View package reviews
- [x] Session timeout
- [x] Role-based access control

## 📞 Support

For issues or questions:
1. Check database connection in `includes/db_config.php`
2. Verify SQL file was imported correctly
3. Ensure PHP sessions are enabled
4. Check browser console for JavaScript errors
5. Review PHP error logs in XAMPP

## 📄 License

This project is part of the Tourism Management System assignment.

## ✨ Highlights

This complete tourism management system includes:
- **Full authentication system** with admin and user roles
- **Complete CRUD operations** for destinations and packages
- **Advanced booking system** with capacity management
- **Sophisticated review system** with admin moderation
- **Cancellation management** with automated refunds
- **Responsive design** for all screen sizes
- **Data validation** at frontend and backend
- **Secure database** with proper indexes and relationships

**Alternative:** Run SQL commands directly in phpMyAdmin:
```sql
CREATE DATABASE IF NOT EXISTS tourism_db;
USE tourism_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

CREATE INDEX idx_email ON users(email);
```

### 3. Configure Database Connection

Edit `includes/db_config.php` if your database credentials differ:
```php
define('DB_HOST', 'localhost');      // Your database host
define('DB_USER', 'root');           // Your database username
define('DB_PASSWORD', '');           // Your database password
define('DB_NAME', 'tourism_db');     // Your database name
```

### 4. File Placement

Place the entire Tourism Management System folder in:
- **Windows (XAMPP):** `C:\xampp\htdocs\Tourism Management System\`
- **Linux:** `/opt/lampp/htdocs/Tourism Management System/`
- **macOS:** `/Library/WebServer/Documents/Tourism Management System/`

## Usage

### Access the Registration Page

1. Start XAMPP (Apache and MySQL modules)
2. Open your browser and navigate to:
   ```
   http://localhost/Tourism Management System/register.php
   ```

### Register a New User

1. Fill in all required fields:
   - First Name
   - Last Name
   - Email Address
   - Password (minimum 6 characters)
   - Confirm Password

2. Phone Number is optional

3. Click "Register Account" button

### Validation

**Client-Side Validation (JavaScript):**
- Real-time feedback as user types
- Error messages displayed below each field
- Form submission prevented if invalid

**Server-Side Validation (PHP):**
- Validates all input data
- Checks email format
- Verifies passwords match
- Checks for duplicate email addresses
- Sanitizes input to prevent SQL injection

## Success Response

When registration is successful:
- Data is stored in the database
- User is redirected back to registration page with success message:
  ```
  "Account registered successfully! Welcome [FirstName] [LastName]!"
  ```
- Password is hashed using `PASSWORD_DEFAULT` algorithm
- Success message can be seen in the green alert box

## Error Handling

Errors are displayed in red alert boxes:
- Missing required fields
- Invalid email format
- Password mismatch
- Password too short
- Email already registered
- Database connection errors

## Database Fields

| Field | Type | Description |
|-------|------|-------------|
| id | INT | Auto-increment primary key |
| first_name | VARCHAR(100) | User's first name |
| last_name | VARCHAR(100) | User's last name |
| email | VARCHAR(255) | Unique email address |
| phone | VARCHAR(20) | Optional phone number |
| password | VARCHAR(255) | Hashed password |
| created_at | TIMESTAMP | Account creation date |
| updated_at | TIMESTAMP | Last update date |
| status | ENUM | Account status (active/inactive) |

## Security Features

1. **Password Hashing:** Uses PHP's `password_hash()` with PASSWORD_DEFAULT algorithm
2. **SQL Injection Prevention:** Uses prepared statements with parameterized queries
3. **Input Sanitization:** Trims and validates all user inputs
4. **Email Validation:** Regular expressions check email format
5. **Duplicate Prevention:** Checks for existing email addresses before insertion
6. **HTML Escaping:** Uses `htmlspecialchars()` for output safety

## Verification in Database

To verify registered users in phpMyAdmin:

1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Select `tourism_db` database
3. Select `users` table
4. Click "Browse" tab
5. View all registered users with their details

**SQL Query to view users:**
```sql
SELECT id, first_name, last_name, email, phone, created_at, status 
FROM users 
ORDER BY created_at DESC;
```

## File Descriptions

### register.php
- Main HTML form for user registration
- Displays success/error messages
- Includes form fields with validation attributes
- Responsive design for all devices

### includes/db_config.php
- Database connection configuration
- Establishes MySQLi connection
- Handles connection errors

### includes/register_handler.php
- Processes form submission
- Validates all input data
- Checks for duplicate emails
- Hashes and inserts password into database
- Redirects with success/error messages

### database/setup.sql
- SQL script to create database and table
- Creates necessary indexes for performance
- Can be imported directly into phpMyAdmin

### css/style.css
- Beautiful gradient background
- Responsive form layout
- Professional styling for inputs and buttons
- Success and error message styling
- Mobile-friendly design

### js/validation.js
- Client-side form validation
- Real-time validation feedback
- Email and phone format checking
- Password matching verification
- User-friendly error messages

## Testing the Registration

### Test Case 1: Successful Registration
1. Go to registration page
2. Enter: 
   - First Name: md
   - Last Name: masum
   - Email: masum123@gmail.com
   - Phone: 1234567890
   - Password: Password123
   - Confirm: Password123
3. Click "Register Account"
4. Should see: "Account registered successfully! Welcome md masum!"

### Test Case 2: Duplicate Email
1. Try registering with same email as before
2. Should see: "Email address already registered"

### Test Case 3: Password Mismatch
1. Enter different passwords in password fields
2. Should see: "Passwords do not match"

### Test Case 4: Invalid Email
1. Enter invalid email format
2. Should see: "Invalid email format"

## Troubleshooting

### Database Connection Error
- Check XAMPP Apache and MySQL are running
- Verify `db_config.php` credentials
- Ensure `tourism_db` database exists

### Table Not Found Error
- Run the `setup.sql` script in phpMyAdmin
- Verify table creation was successful

### Password Not Hashing
- Ensure PHP version supports `password_hash()` (PHP 5.5+)
- Check error logs in XAMPP

### Form Submission Issues
- Clear browser cache
- Check browser console for JavaScript errors
- Verify all form field names match PHP POST variables

## Future Enhancements

- Add email verification
- Implement login system
- Add password reset functionality
- Create user profile management
- Add role-based access control
- Implement two-factor authentication

## License

© 2025 Tourism Management System. All rights reserved.

## Support

For issues or questions, please review:
1. Database connection settings in `includes/db_config.php`
2. Ensure all files are in correct folders
3. Check XAMPP error logs for detailed errors
4. Verify MySQL service is running



