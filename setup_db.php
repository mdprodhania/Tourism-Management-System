<?php
$conn = new mysqli('localhost', 'root', '', 'tourism_db');
if ($conn->connect_error) die('Connection failed: ' . $conn->connect_error);

// Read the SQL file
$sql_file = __DIR__ . '/database/setup.sql';
$sql = file_get_contents($sql_file);

// Split by semicolon and filter comments
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    function($s) {
        return !empty($s) && strpos(trim($s), '--') !== 0;
    }
);

$count = 0;
$errors = [];
foreach ($statements as $statement) {
    $statement = trim($statement);
    if (empty($statement)) continue;
    
    // Skip comment lines
    if (strpos($statement, '--') === 0) continue;
    
    if ($conn->multi_query($statement)) {
        // Clear results
        while ($conn->next_result()) {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        }
        $count++;
    } else {
        // Only log real errors
        if (strpos($conn->error, 'already exists') === false && 
            strpos($conn->error, 'Duplicate') === false &&
            !empty($conn->error)) {
            $errors[] = "Error: " . $conn->error . "\nStatement: " . substr($statement, 0, 100);
        }
    }
}

// Verify tables exist
$tables = ['users', 'packages', 'destinations', 'bookings', 'reviews', 'password_reset_tokens'];
$missing = [];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows === 0) {
        $missing[] = $table;
    }
}

echo "Database setup completed.\n";
echo "Executed: $count statements\n";

if (!empty($errors)) {
    echo "\nErrors encountered:\n";
    foreach ($errors as $error) {
        echo $error . "\n\n";
    }
}

if (!empty($missing)) {
    echo "Missing tables: " . implode(', ', $missing) . "\n";
} else {
    echo "All required tables exist!\n";
}

// Verify users table has username column
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'username'");
if ($result->num_rows === 0) {
    echo "Adding username column...\n";
    $conn->query("ALTER TABLE users ADD COLUMN username VARCHAR(100) UNIQUE AFTER email");
    $conn->query("CREATE INDEX idx_username ON users(username)");
    echo "Username column added.\n";
}

$conn->close();
echo "\nDone!\n";
?>
