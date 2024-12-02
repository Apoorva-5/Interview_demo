<?php
// Enable error reporting during development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 during development
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); // Set an appropriate log file path

// Database configuration
$servername = "localhost:3307"; // Use localhost for local server
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "students_db"; // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error); // Log the error
    exit("An error occurred. Please try again later."); // Graceful exit
}
?>
