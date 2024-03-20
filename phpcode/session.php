<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit; // Stop further execution of the script
}
// Include the database connection file
require_once "dbconnect.php";

// Initialize variables for messages and user data
$errorMessage = '';
$userName = '';

// Check if the user is logged in (you can implement your authentication logic here)
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    try {
        // Fetch the name of the logged-in user
        $stmt = $conn->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($userData) {
            $userName = $userData['name'];
        } else {
            $errorMessage = "User not found.";
        }
    } catch(PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
} else {
    $errorMessage = "User not logged in.";
}
?>