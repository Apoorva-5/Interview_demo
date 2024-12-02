<?php
// Include the database connection file
require 'dbconnection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['registerName'];
    $usn = $_POST['registerUSN'];
    $password = $_POST['registerPassword'];
    $confirmPassword = $_POST['registerConfirmPassword'];

    // Input validation
    if (empty($name) || empty($usn) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the user data
    $sql = "INSERT INTO users (name, usn, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Error: " . $conn->error;
        exit;
    }

    // Bind the parameters to the query
    $stmt->bind_param("sss", $name, $usn, $hashedPassword);

    // Execute the query and check if the insertion is successful
    if ($stmt->execute()) {
        echo "Registration successful.";
        // Redirect to the login page
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
}
$conn->close();
?>
