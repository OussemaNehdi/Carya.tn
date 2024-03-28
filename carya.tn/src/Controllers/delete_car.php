<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php'; // Include the file with database connection
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php'; // Include the file with the Car class

    // deletes a car
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

    $car_id = $_GET['id'];
    
    $car = Car::getCarById($car_id);

    $owner_id = $car->owner_id;

    $image_path =  $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Resources/car_images/' . $car->image;
    
    try {
        Car::deleteCarById($car_id);
        
        // deletes the image file from the server
        unlink($image_path);
        
        header('Location: http://localhost/Mini-PHP-Project/carya.tn/Templates/admin_dashboard.php?message=Car_deleted');
        exit(); // Ensure script execution stops after redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
