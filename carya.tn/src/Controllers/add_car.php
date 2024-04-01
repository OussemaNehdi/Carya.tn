<?php 
    // Include necessary files
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/controllers/image_upload_handler.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $refferer = isset($_POST['refferer']) ? parse_url($_POST['refferer'], PHP_URL_PATH) : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/Mini-PHP-Project/carya.tn/index.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required parameters are set
        if (!isset($_POST['brand']) || !isset($_POST['model']) || !isset($_POST['color']) || 
            !isset($_POST['price']) || !isset($_POST['km']) || !isset($_FILES['car_image'])) {
                // Redirect with an error message if any required parameter is missing
                header("Location: $refferer?message=Missing%20required%20parameters%20for%20adding%20car.&type=error");
                exit();
            }

        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $km = $_POST['km'];
        $owner_id = $_SESSION['user_id'];
        $refferer = parse_url($_POST['refferer'], PHP_URL_PATH);
        $file_name = handleImageUpload($_FILES['car_image'], '/Mini-PHP-Project/carya.tn/Resources/car_images/');

        if (strpos($file_name, "error") !== false) {
            $refferer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
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
    }
?>