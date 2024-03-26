<?php

session_start();

//make connection
include_once ('connect.php');

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // TODO: Add your own code here to check the username and password against your database.
    // This is just a placeholder for demonstration purposes.
    if($email == '' && $password == 'password') {
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username; 

        // Redirect user to welcome page
        header("location: home.php");
    } else {
        // Display an error message if username doesn't exist
        echo "Invalid username or password.";
    }
}
?>