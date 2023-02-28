<?php
$servername = "localhost";
$serverusername = "master";
$password = "";
$dbname = "social";
// Create connection
$conn = new mysqli($servername, $serverusername, $password, $dbname);




// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate input
if (isset($_POST['title'])) {
    $title = $_POST['title'];
} else {
    $title = '';
}

if (isset($_POST['description'])) {
    $description = $_POST['description'];
} else {
    $description = '';
}

if (isset($_POST['media_type'])) {
    $media_type = $_POST['media_type'];
} else {
    $media_type = '';
}

if (isset($_POST['button_label'])) {
    $button_label = $_POST['button_label'];
} else {
    $button_label = '';
}

if (isset($_POST['button_link'])) {
    $button_link = $_POST['button_link'];
} else {
    $button_link = '';
}

// Check if file was uploaded without errors
if(isset($_FILES["media"]) && $_FILES["media"]["error"] == 0){
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["media"]["name"]);
    $file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_type;
    $target_file = $target_dir . $file_name;

    // Allow certain file formats
    $allow_types=array("jpg","jpeg","png","gif");

    if(in_array($file_type, $allow_types)){
        // Upload file to server
        if(move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)){
            // Insert post data into database
            $sql = "INSERT INTO posts (title, description, media_type, file_path, button_label, button_link, author, author_id) VALUES ('$title', '$description', '$media_type', '$file_name', '$button_label', '$button_link', '$author', '$author_id')";
            if ($conn->query($sql) === TRUE) {
                header("location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{
            echo "Sorry, there was an error uploading your file.";
        }
    }else{
        echo 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
    }
}



