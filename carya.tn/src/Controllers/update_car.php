<?php 
// Include the Car model and the image upload handler
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Controllers/image_upload_handler.php';

// Check if the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit("Method Not Allowed");
}

// The refferer is the page that redirected the user to this page
$refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');

// Check if the parameters are set
if (!isset($_POST['car_id']) || !isset($_POST['brand']) || !isset($_POST['model']) || 
    !isset($_POST['color']) || !isset($_POST['price']) || !isset($_POST['km']) || 
    !isset($_FILES['image'])) {
    header("Location: $refferer?message=Missing%20required%20variables%20for%20updating%20car.&type=error");
    exit();
}


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: $refferer?message=You%20need%20to%20login%20first.&type=error");
    exit();
}

// Get form data
$car_id = $_POST['car_id'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$color = $_POST['color'];
$price = $_POST['price'];
$km = $_POST['km'];

// Check if the image file is uploaded
if (!empty($_FILES['image']['name'])) {
    // Handle image upload
    $file_name = handleImageUpload($_FILES['image'], '/Mini-PHP-Project/carya.tn/Resources/car_images/');
    if (strpos($file_name, "error") !== false) {
        // Redirect with an error message if image upload fails
        $refferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        header("Location: $refferer?id=$car_id&$file_name");
        exit(); // Ensure script execution stops after redirect
    }
} else {
    // Use the old image if no new image is uploaded
    $car = Car::getCarById($car_id);
    $file_name = $car->image;
}

// Check if the logged-in user owns the car
$car = Car::getCarById($car_id);

// Check if the car exists
if (!$car) {
    header("Location: $refferer?type=error&message=Car%20not%20found.");
    exit(); // Ensure script execution stops after redirect
}

$owner_id = $car->owner_id;
if ($owner_id != $_SESSION['user_id']) {
    header("Location: $refferer?type=error&message=You%20do%20not%20have%20permission%20to%20update%20this%20car.");
    exit(); // Ensure script execution stops after redirect
}

// Check if the car is available for update
if (!$car->isCarAvailable()) {
    header("Location: $refferer?type=errormessage=Car%20is%20currently%20in%20use%20and%20cannot%20be%20updated.");
    exit(); // Ensure script execution stops after redirect
}

try {
    // Update car details
    $car->updateCar($brand, $model, $color, $file_name, $km, $price);
    header("Location: $refferer?message=Car%20updated%20successfully.&type=success");
    exit(); // Ensure script execution stops after redirect
} catch (Exception $e) {
    header("Location: $refferer?type=error&message=" . urlencode($e->getMessage()));
    exit(); // Ensure script execution stops after redirect
}

?>