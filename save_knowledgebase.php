<?php
include 'db_config.php'; // Include your database configuration file

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tag = $_POST['tag'];
    $img_path = $_POST['img_path'];
    $alarm = $_POST['alarm'];
    $solutions = $_POST['solutions'];

    // Prepare and execute SQL statement to insert knowledge base details into the database
    $sql = "INSERT INTO knowledgebase (tag, img_path, alarm, solutions) 
            VALUES ('$tag', '$img_path', '$alarm', '$solutions')";

    if ($conn->query($sql) === TRUE) {
        echo "Knowledge Base added successfully";
    } else {
        echo "Error adding knowledge base: " . $conn->error;
    }
}
?>
