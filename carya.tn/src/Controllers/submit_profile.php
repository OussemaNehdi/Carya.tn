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

    // Check if the first name is set in the form
    if (isset($_POST['fname']) && !empty($_POST['fname'])) {
        // Get the first name from the form
        $firstName = htmlspecialchars($_POST['fname']);
        echo $firstName;
        // Update the user's first name
        User::updateFirstNameById($userId, $firstName);
    }

    // Check if the last name is set in the form
    if (isset($_POST['lname']) && !empty($_POST['lname'])) {
        // Get the last name from the form
        $lastName = htmlspecialchars($_POST['lname']);
        echo $lastName;

        // Update the user's last name
        User::updateLastNameById($userId, $lastName);
    }

    if (isset($_POST['country']) && isset($_POST['state']) && !empty($_POST['country']) && !empty($_POST['state'])){
        // Get the country and state from the form
        $country = htmlspecialchars($_POST['country']);
        $state = htmlspecialchars($_POST['state']);

        // Update the user's country and state
        User::updateUserLocationById($userId, $country, $state);
    }

    //update the user's email
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        // Get the email from the form
        $email = htmlspecialchars($_POST['email']);
        echo $email;

        // Update the user's email
        User::updateEmailById($userId, $email);
    }
    else {
        echo "Email is empty";
    }

    header("Location: http://localhost/Mini-PHP-Project/carya.tn/templates/profile.php?message=Profile%20updated%20successfully&type=success");
}




?>