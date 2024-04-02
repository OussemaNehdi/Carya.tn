<?php
    // this file returns the information of a car or a user based on the id and type
    // it is called using AJAX from the admin dashboard
    // it's used for the click on id functionality of the commands table

    // include the Car and User classes
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

    // check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405); // Method Not Allowed
        exit("Method Not Allowed");
    }

    // check if the session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=You%20need%20to%20login%20first.&type=error");
        exit();
    }

    // check if the id and type are set in the GET parameters
    if (!isset($_GET['id']) || !isset($_GET['type'])) {
        header("Location: http://localhost/Mini-PHP-Project/carya.tn/index.php?message=ID%20and%20Type%20are%20required.&type=error");
        exit();
    }

    // get the id and type from the GET parameters
    $id = $_GET['id'];
    $type = $_GET['type'];
    
    // initialize the output variable
    $output = '';

    // check the type
    if ($type == 'car' || $type == 'image') {
        // get the car by id
        $car = Car::getCarById($id);

        if ($car) {
            if ($type == 'car') {
                $output .= "<h3>Car Information</h3>";
                $output .= "<p>ID: " . $car->id . "</p>";
                $output .= "<p>Brand: " . $car->brand . "</p>";
                $output .= "<p>Model: " . $car->model . "</p>";
            } else if ($type == 'image') {
                $output = "<img id=\"car-image-{$id}\" class=\"car-image-displayed\" src=\"http://localhost/Mini-PHP-Project/carya.tn/Resources/car_images/{$car->image}\" alt=\"Car Image\">";
            }
        } else {
            $output = "Car not found!";
        }
    } else if ($type == 'user') {
        // get the user by id
        $user = User::getUserById($id);

        if ($user) {
            $output .= "<h3>User Information</h3>";
            $output .= "<p>ID: " . $user->id . "</p>";
            $output .= "<p>First Name: " . $user->firstName . "</p>";
            $output .= "<p>Last Name: " . $user->lastName . "</p>";
        } else {
            $output = "User not found!";
        }
    }

    echo $output;
?>
