<?php

// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';
// Include the User model
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the session or any other source
    $userId = $_SESSION['user_id'];

    // Get the first name and last name from the form
    $firstName = htmlspecialchars($_POST['fname']);
    $lastName = htmlspecialchars($_POST['lname']);

    // Update the user's first name and last name
    User::updateUsernamesById($userId, $firstName, $lastName);

    // Redirect back to profile.php after 3 seconds
    header("refresh:0.2; url=http://localhost/Mini-PHP-Project/carya.tn/Templates/profile.php");
    exit;
}




?>