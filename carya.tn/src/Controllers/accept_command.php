<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=You%20need%20to%20login%20first.&type=error");
    exit();
}

if (!isset($_POST['command_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Command%20ID%20is%20required.&type=error");
    exit();
}

$user_id = $_SESSION['user_id'];

$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');
$command_id = $_POST['command_id'];

$command = Command::getCommandById($command_id);

$car = Car::getCarById($command->car_id);



Command::AcceptCommand($command_id);

header("Location: $refferer?message=Command%20Accepted%20.&type=success");


?>