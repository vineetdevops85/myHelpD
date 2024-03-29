<?php
// Include your database configuration file
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // SQL query to delete the knowledge base entry with the specified ID
    $sql = "DELETE FROM knowledgebase WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo "Knowledge base entry deleted successfully";
    } else {
        // Error in deletion
        echo "Error deleting knowledge base entry: " . $conn->error;
    }
} else {
    // Invalid request
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
