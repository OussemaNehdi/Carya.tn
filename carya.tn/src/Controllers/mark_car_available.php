<?php
// Include the Car model
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

// the refferer will be the page that the user will be sent to once the code is executed
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// Check if the 'id' parameter is set in the GET request
if (!isset($_GET['id'])) {
    header("Location: $refferer?message=Missing%20required%20parameters%20for%20marking%20car%20as%20available&type=error");
    exit();
}

// Check if the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: $refferer?message=You%20need%20to%20login%20first&type=error");
    exit();
}

$car_id = $_GET['id'];
$owner_id = $_SESSION['user_id'];

// Get the car by ID
$car = Car::getCarById($car_id);

// Check if the car exists
if (!$car) {
    header("Location: $refferer?message=Car%20not%20found&type=error");
    exit();
}

// Check if the user is the owner of the car
if ($car->owner_id != $owner_id) {
    header("Location: $refferer?message=You%20are%20not%20the%20owner%20of%20this%20car&type=error");
    exit();
}

try {
    $car->markCarAvailable();
    header("Location: $refferer?message=Car%20marked%20as%20available%20successfully!&type=success");
    exit();
} catch (Exception $e) {
    header("Location: $refferer?type=error&message=Error:%20" . urlencode($e->getMessage()));
    exit();
}
?>