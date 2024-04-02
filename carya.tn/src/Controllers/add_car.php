<?php 
    // Include necessary files
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/controllers/image_upload_handler.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit("Method Not Allowed");
    }

    // Check if the session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=You%20need%20to%20login%20first.&type=error");
        exit();
    }

    // The reffer will be the page that the user will be sent to once the code is executed
    $refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');
    
    
    // Check if all required parameters are set
    if (!isset($_POST['brand']) || !isset($_POST['model']) || !isset($_POST['color']) || 
        !isset($_POST['price']) || !isset($_POST['km']) || !isset($_FILES['car_image'])) {
            // Redirect with an error message if any required parameter is missing
            header("Location: $refferer?message=Missing%20required%20parameters%20for%20adding%20car.&type=error");
            exit();
        }

    // Get the parameters
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $km = $_POST['km'];

    // Check if the price and km are numbers
    if (!is_numeric($price) || !is_numeric($km)) {
        header("Location: $refferer?message=Price%20and%20Kilometers%20must%20be%20numbers.&type=error");
        exit();
    }

    // Get the owner id from the session
    $owner_id = $_SESSION['user_id'];

    // Handle the image upload
    $file_name = handleImageUpload($_FILES['car_image'], '/Mini-PHP-Project/carya.tn/Resources/car_images/');

    // Check if the file name contains the word error
    if (strpos($file_name, "error") !== false) {        
        header("Location: $refferer?$file_name");
        exit();
    } else {
        try {
            // Add the car to the database
            Car::addCar($brand, $model, $color, $file_name, $km, $price, $owner_id);
            header("Location: $refferer?message=Car%20added%20successfully!&type=success");
            exit();
        } catch (Exception $e) {
            header("Location: $refferer?error=Error:%20" . urlencode($e->getMessage()));
            exit();
        }
    }

?>