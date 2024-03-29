<?php
// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection
// Include the User model
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $customer = $_POST['check1'];

    $role = $customer;

    if (isset($first_name, $last_name, $email, $password)) {

        // Sanitize the email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = trim($email);

        $user = User::getUserByEmail($email);

        if ($user) {
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=User already exists&slide=register');
            exit();
        }

        // Validate the password
        if (strlen($password) < 8) {
            header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=Password must be at least 8 characters&slide=register');
            exit();
        } else {
            $password = trim($password);
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Add the user
        User::addUser($first_name, $last_name, $hashed_password, $email, $role);
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=Account created successfully');
        exit();

    } else {
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?message=All fields are required&slide=register');
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>