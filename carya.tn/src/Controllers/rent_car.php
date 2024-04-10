<?php
// Include the required files
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Mini-PHP-Project/carya.tn/Templates/fetch_cars.php');
    exit();
}

// Check if all required parameters are set
if (!isset($_POST['car_id']) || empty($_POST['car_id'])) {
    header('Location: /Mini-PHP-Project/carya.tn/Templates/fetch_cars.php?message=Car%20ID%20is%20required.&type=error');
    exit();
}

// Check if the session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /Mini-PHP-Project/carya.tn/Templates/login.php?message=You%20need%20to%20login%20first.&type=error');
    exit();
}

$refferrer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
$user_id = $_SESSION['user_id'];
$password = $_POST['password'];

$car_id = $_POST['car_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$startDateTime = new DateTime($start_date);
$endDateTime = new DateTime($end_date);
$rental_days = $startDateTime->diff($endDateTime)->days;

// Check if the car is available
if (Car::isCarRented($car_id, $start_date, $end_date)) {
    header('Location: ' . $refferrer . '?type=error&message=Car%20is%20not%20available%20for%20the%20selected%20dates');
    exit();
}

$user = User::getUserById($user_id);
// Check if user exists
if (!$user) {
    header('Location: ' . $refferrer . '?type=error&message=User%20not%20found');
    exit();
}

// Check if the password is correct
if (!password_verify($password, $user->password)) {
    header('Location: ' . $refferrer . '?type=error&message=wrong%20password');
    exit();
}

try {
    Command::addRentalCommand($car_id, $user_id, $start_date, $end_date, $rental_days);
    header('Location: ' . $refferrer . '?message=rental%20command%20added&type=success');
}
catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}
?>
