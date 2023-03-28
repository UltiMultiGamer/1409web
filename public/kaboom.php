<?php 
session_start();
require_once "../auth/postconfig.php";


$sql = "DELETE FROM posts;";
if (mysqli_query($conn, $sql)) {
    echo "All posts deleted successfully";
} else {
    echo "Error deleting posts: " . mysqli_error($conn);
}

// 4. Close the connection
mysqli_close($conn);


?>