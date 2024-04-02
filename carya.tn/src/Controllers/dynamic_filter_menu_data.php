<?php 
// this file will give the dynamic filter menu the data it needs

// Include the file with database connection and the Car class
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/car.php';


// Fetch distinct values for brands, models, colors, maximum kilometers, and price ranges from the cars table
try {
    $brands = Car::getDistinctValues('brand');
    $models = Car::getDistinctValues('model');
    $colors = Car::getDistinctValues('color');
    $max_km = Car::getMaxValue('km');
    $max_price = Car::getMaxValue('price');
} catch (PDOException $e) {
    // Redirect with an error message if a PDO exception occurs
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Error:%20" . urlencode($e->getMessage()));
    exit(); // Ensure script execution stops after redirect
} catch (Exception $ex) {
    // Redirect with an error message if any other exception occurs
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=Error:%20" . urlencode($ex->getMessage()));
    exit(); // Ensure script execution stops after redirect
}
?>