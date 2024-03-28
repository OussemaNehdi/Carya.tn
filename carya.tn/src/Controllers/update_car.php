<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Controllers/image_upload_handler.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check for required variables
    if (!isset($_POST['car_id']) || !isset($_POST['brand']) || !isset($_POST['model']) || 
        !isset($_POST['color']) || !isset($_POST['price']) || !isset($_POST['km']) || 
        !isset($_FILES['image']) || !isset($_POST['refferer'])) {
        // Redirect with an error message if any required variable is missing
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Missing%20required%20variables%20for%20updating%20car.');
        exit(); // Ensure script execution stops after redirect
    }

    // Get form data
    $car_id = $_POST['car_id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $km = $_POST['km'];
    $refferer = parse_url($_POST['refferer'], PHP_URL_PATH);

    // Check if the image file is uploaded
    if (!empty($_FILES['image']['name'])) {
        // Handle image upload
        $file_name = handleImageUpload($_FILES['image']);
        if (strpos($file_name, "Error") !== false) {
            // Redirect with an error message if image upload fails
            $refferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
            header("Location: $refferer?id=$car_id?message=$file_name");
            exit(); // Ensure script execution stops after redirect
        }
    } else {
        // Use the old image if no new image is uploaded
        $car = Car::getCarById($car_id);
        $file_name = $car->image;
    }

    // Check if the logged-in user owns the car
    $car = Car::getCarById($car_id);
    $owner_id = $car->owner_id;
    if ($owner_id != $_SESSION['user_id']) {
        header('Location: http://localhost/Mini-PHP-Project/?error=You%20do%20not%20have%20permission%20to%20update%20this%20car.');
        exit(); // Ensure script execution stops after redirect
    }

    // Check if the car is available for update
    if (!$car->isCarAvailable()) {
        header('Location: http://localhost/Mini-PHP-Project/?error=Car%20is%20currently%20in%20use%20and%20cannot%20be%20updated.');
        exit(); // Ensure script execution stops after redirect
    }

    try {
        // Update car details
        $car->updateCar($brand, $model, $color, $file_name, $km, $price);
        header('Location: http://localhost/Mini-PHP-Project/?message=Car%20updated%20successfully!');
        exit(); // Ensure script execution stops after redirect
    } catch (Exception $e) {
        header('Location: http://localhost/Mini-PHP-Project/?error=' . urlencode($e->getMessage()));
        exit(); // Ensure script execution stops after redirect
    }
}
?>