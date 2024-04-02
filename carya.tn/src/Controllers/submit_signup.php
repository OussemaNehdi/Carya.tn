<?php
// Include the database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection
// Include the User model
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the paramaters are set
if (!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/login.php?type=error&message=All fields are required&slide=register');
    exit();
}

// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the form data
$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$customer = $_POST['check1'];

$role = $customer;

// Sanitize the email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = trim($email);

$user = User::getUserByEmail($email);

if ($user) {
    header("Location: $refferer?type=error&message=User already exists&slide=register");
    exit();
}

// Validate the password
if (strlen($password) < 8) {
    header("Location: $refferer?type=error&message=Password must be at least 8 characters&slide=register");
    exit();
} else {
    $password = trim($password);
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Add the user
User::addUser($first_name, $last_name, $hashed_password, $email, $role);
header("Location: $refferer?message=Account created successfully&type=success");
exit();
?>