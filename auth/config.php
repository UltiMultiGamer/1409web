<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'master');
define('DB_PASSWORD', '');
define('DB_NAME', 'social');

// Attempt to connect to MySQL database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if(!$conn){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
