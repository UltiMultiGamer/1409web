<?php

// Start the session
session_start();

// Define logout function
function logout(){
    // Unset all of the session variables
    $_SESSION = array();
    session_destroy();
    header("location: login.php");
    exit;
}

// Call the logout function
logout();

?>
