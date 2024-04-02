<?php
// Include the database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';
// Include the User model
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: $refferer?type=error&message=You are already logged in&slide=home");
    exit();
}

// Check if all required parameters are set
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    // Redirect with an error message if any required parameter is missing
    header("Location: $refferer?type=error&message=Missing%20required%20parameters%20for%20submitting%20login%20form&slide=login");
    exit();
}

// Get the form data, sanitize the email
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Get the user from the database
$user = User::getUserByEmail($email);

// If the user exists
if ($user) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Check if the password is correct
    if ($user->password === $password) {
        // Check if the user is banned
        if ($user->role === 'banned') {
            header("Location: $refferer?type=error&message=You are banned&slide=login");
            exit();
        }
        // Set the session variables
        $_SESSION['user'] = $user->firstName;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;

        header("Location: $refferer?type=success&message=Logged in successfully&slide=home");
        exit();
    } else {
        header("Location: $refferer?type=error&message=Incorrect_password&slide=login");
        exit();
    }
} else {
    header("Location: $refferer?type=error&message=User not found&slide=login");
    exit();
}
?>