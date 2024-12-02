<?php
// Start output buffering to prevent header issues
ob_start();
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = $_POST['loginUSN'] ?? null;
    $password = $_POST['loginPassword'] ?? null;

    // Check if inputs are empty
    if (empty($usn) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }

    // Prepare SQL query to fetch password for the entered USN
    $sql = "SELECT password FROM users WHERE usn = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Preparation Error: " . $conn->error);
    }

    // Bind USN parameter and execute the query
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Start session and redirect to dashboard
            session_start();
            $_SESSION['usn'] = $usn;
            header("Location: /interview/dashborad1.html"); // Use relative URL path
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=invalid_password");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=user_not_found");
        exit();
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed via GET
    header("Location: login.php");
    exit();
}

// End output buffering
ob_end_flush();
?>
