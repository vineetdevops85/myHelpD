<?php
// Include your database connection file
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['id']) && isset($_POST['tag']) && isset($_POST['alarm']) && isset($_POST['solutions'])) {
        $id = $_POST['id'];
        $tag = $_POST['tag'];
        $alarm = $_POST['alarm'];
        $solutions = $_POST['solutions'];

        // Prepare and execute the SQL query to update the knowledge base entry
        $sql = "UPDATE knowledgebase SET tag = ?, alarm = ?, solutions = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $tag, $alarm, $solutions, $id);

        if ($stmt->execute()) {
            // Update successful
            echo "Knowledge Base entry updated successfully!";
        } else {
            // Update failed
            echo "Error updating knowledge base entry: " . $conn->error;
        }

        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Required fields not set
        echo "All fields are required!";
    }
} else {
    // Redirect if accessed directly without POST request
    header("Location: knowledgebase.php");
    exit();
}
?>
