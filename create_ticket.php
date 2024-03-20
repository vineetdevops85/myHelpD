<?php
include 'db_config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $siteid = $_POST['siteid'];
    $fa = $_POST['fa'];

    // File upload handling
    $targetDir = "uploads/"; // Specify the target directory where files will be saved
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($fileName)) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Insert the new ticket into the database along with file details
                $sql = "INSERT INTO tickets (user_id, subject, description, siteid, fa, status, created_at, file_path) 
                        VALUES ('$user_id', '$subject', '$description', '$siteid', '$fa', 'open', NOW(), '$targetFilePath')";

                if ($conn->query($sql) === TRUE) {
                    echo "Ticket created successfully";
                } else {
                    echo "Error creating ticket: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file format. Allowed formats: jpg, jpeg, png, gif, pdf, doc, zip, txt, docx";
        }
    } else {
        echo "Please select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Create New Ticket</h2>

    <!-- HTML form for creating a ticket with additional inputs -->
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject"><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea><br>
        <label for="siteid">Site ID:</label>
        <input type="text" name="siteid" id="siteid"><br>
        <label for="fa">FA Location:</label>
        <input type="text" name="fa" id="fa"><br>
        <label for="file">Attach File:</label>
        <input type="file" name="file" id="file"><br>
        <input type="submit" value="Create Ticket">
    </form>
</body>
</html>
