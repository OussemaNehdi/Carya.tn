<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("Location: $refferer?message=Invalid%20request%20method");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: $refferer?message=Missing%20required%20parameters%20for%20marking%20car%20as%20available");
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$car_id = $_GET['id'];
$owner_id = $_SESSION['user_id'];

$car = Car::getCarById($car_id);
if ($car->owner_id != $owner_id) {
    header("Location: $refferer?message=You%20are%20not%20the%20owner%20of%20this%20car");
    exit();
}

if ($car->isCarInUse()) {
    header("Location: $refferer?message=Car%20is%20already%20in%20use");
    exit();
}

try {
    $car->markCarUnavailable();
    header("Location: $refferer?message=Car%20marked%20as%20unavailable%20successfully!");
    exit();
} catch (Exception $e) {
    header("Location: $refferer?error=Error:%20" . urlencode($e->getMessage()));
    exit();
}
?>