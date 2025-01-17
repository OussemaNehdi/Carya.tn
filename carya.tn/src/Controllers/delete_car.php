<?php
// Include necessary files
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php'; // Include the file with the Car class

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// The reffer will be the page that the user will be sent to once the code is executed
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the 'id' parameter is set in the GET request
if (!isset($_GET['id'])) {
    // Redirect with an error message if the car ID is not set
    header("Location: $refferer ?message=Error:%20Car%20ID%20not%20set.&type=error");
    exit(); // Ensure script execution stops after redirect
}

// Get the car ID from the GET parameter
$car_id = $_GET['id'];

try {
    // Get the car details by ID
    $car = Car::getCarById($car_id);

    // Check if the car exists
    if (!$car) {
        // Redirect with an error message if the car does not exist
        header("Location: $refferer?message=Error:%20Car%20not%20found.&type=error");
        exit(); // Ensure script execution stops after redirect
    }

    // Get the owner ID of the car
    $owner_id = $car->owner_id;

    // Construct the image path
    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Resources/car_images/' . $car->image;

    // Attempt to delete the car by ID
    $car->deleteCarById();

    // Delete the image file from the server
    unlink($image_path);

    // Redirect with a success message
    header("Location: $refferer?message=Car%20deleted%20successfully!&type=success");
    exit(); // Ensure script execution stops after redirect

} catch (PDOException $e) {
    // Redirect with an error message if a PDO exception occurs
    header("Location: $refferer?type=success&message=Error:%20" . urlencode($e->getMessage()));
    exit(); // Ensure script execution stops after redirect
} catch (Exception $ex) {
    // Redirect with an error message if any other exception occurs
    header("Location: $refferer?type=success&message=Error:%20" . urlencode($ex->getMessage()));
    exit(); // Ensure script execution stops after redirect
}
?>
