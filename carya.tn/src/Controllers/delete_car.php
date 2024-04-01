<?php
// Include necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php'; // Include the file with the Car class

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// The $refferer variable holds the URL of the page that referred the user to the current page. 
// It is used to redirect the user back to the page they came from after the operation is complete.
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the 'id' parameter is set in the GET request
if (!isset($_GET['id'])) {
    // Redirect with an error message if the car ID is not set
    header("Location: $refferer ?error=Error:%20Car%20ID%20not%20set.");
    exit(); // Ensure script execution stops after redirect
}

// Get the car ID from the GET parameter
$car_id = $_GET['id'];

try {
    // Get the car details by ID
    $car = Car::getCarById($car_id);

    // Check if the car exists
    if ($car) {
        
        // Get the owner ID of the car
        $owner_id = $car->owner_id;

        // Construct the image path
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Resources/car_images/' . $car->image;

        // Attempt to delete the car by ID
        $car->deleteCarById();

        // Delete the image file from the server
        unlink($image_path);

        // Redirect with a success message
        header("Location: $refferer?message=Car%20deleted%20successfully!");
        exit(); // Ensure script execution stops after redirect
    } else {
        // Redirect with an error message if the car does not exist
        header("Location: $refferer?error=Error:%20Car%20not%20found.");
        exit(); // Ensure script execution stops after redirect
    }
} catch (PDOException $e) {
    // Redirect with an error message if a PDO exception occurs
    header("Location: $refferer?error=Error:%20" . urlencode($e->getMessage()));
    exit(); // Ensure script execution stops after redirect
} catch (Exception $ex) {
    // Redirect with an error message if any other exception occurs
    header("Location: $refferer?error=Error:%20" . urlencode($ex->getMessage()));
    exit(); // Ensure script execution stops after redirect
}
?>
