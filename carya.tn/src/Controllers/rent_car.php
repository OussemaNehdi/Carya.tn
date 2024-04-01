<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Mini-PHP-Project/carya.tn/Templates/fetch_cars.php');
    exit();
}

if (!isset($_POST['car_id']) || empty($_POST['car_id'])) {
    header('Location: /Mini-PHP-Project/carya.tn/Templates/fetch_cars.php?message=Car%20ID%20is%20required.&type=error');
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

$user = User::getUserById($user_id);
if ($user->password !== $password) {
    header('Location: ' . $refferrer . '?type=error&message=wrong_password');
    exit();
}

try {
    Command::addRentalCommand($car_id, $user_id, $start_date, $end_date, $rental_days);
    header('Location: ' . $refferrer . '?message=rental_command_added&type=success');
}
catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}
?>
