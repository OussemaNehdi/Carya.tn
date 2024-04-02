<?php
// Include the necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

// Check if the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=You%20need%20to%20login%20first.&type=error");
    exit();
}

// Check for the post parameters
if (!isset($_POST['command_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Command%20ID%20is%20required.&type=error");
    exit();
}

// Get the user id from the session
$user_id = $_SESSION['user_id'];

// The reffer will be the page that the user will be sent to once the code is executed
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Get the command
$command_id = $_POST['command_id'];
$command = Command::getCommandById($command_id);

if (!$command) {
    header("Location: $refferer?message=Command%20not%20found.&type=error");
    exit();
}

// Get the car
$car = Car::getCarById($command->car_id);



// Accept the command
Command::AcceptCommand($command_id);

// Redirect the user to the refferer
header("Location: $refferer?message=Command%20Accepted%20.&type=success");
?>