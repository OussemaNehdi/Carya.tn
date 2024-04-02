<?php
// Include the Car, Command and User models
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if all required parameters are set
if (!isset($_POST['car_id']) || empty($_POST['car_id'])) {
    header("Location: $refferer?message=Car%20ID%20is%20required.&type=error");
    exit();
}

// Check if the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: $refferer?message=You%20need%20to%20login%20first.&type=error");
    exit();
}

// Get the user id, password, car id, start date and end date from the POST request
$user_id = $_SESSION['user_id'];
$password = $_POST['password'];
$car_id = $_POST['car_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Set the rental days
$startDateTime = new DateTime($start_date);
$endDateTime = new DateTime($end_date);
$rental_days = $startDateTime->diff($endDateTime)->days;

// Get the user
$user = User::getUserById($user_id);

// Check if the user exists
if (!$user) {
    header('Location: ' . $refferrer . '?type=error&message=user_not_found');
    exit();
}

// Check if the user's password is correct
if ($user->password !== $password) {
    header('Location: ' . $refferrer . '?type=error&message=wrong_password');
    exit();
}

// Add the rental command
try {
    Command::addRentalCommand($car_id, $user_id, $start_date, $end_date, $rental_days);
    header('Location: ' . $refferrer . '?message=rental_command_added&type=success');
}
catch (PDOException $e) {
    header('Location: ' . $refferrer . '?type=error&message=' . $e->getMessage());
    exit();
}
?>
