<?php
    // this file returns the information of a car or a user based on the id and type
    // it is called using AJAX from the admin dashboard
    // it's used for the hover functionality of the commands table

    include('../../connect.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id = $_GET['id'];
        $type = $_GET['type'];
        $output = '';

        if ($type == 'car' || $type == 'image') {
            $sql = "SELECT * FROM cars WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $car = mysqli_fetch_assoc($result);
                if ($type == 'car') {
                    $output .= "<h3>Car Information</h3>";
                    $output .= "<p>ID: " . $car['id'] . "</p>";
                    $output .= "<p>Brand: " . $car['brand'] . "</p>";
                    $output .= "<p>Model: " . $car['model'] . "</p>";
                }
                else if ($type == 'image') {
                    $output = "<img id=\"car-image-{$id}\" class=\"car-image\" src=\"http://localhost/Mini-PHP-Project/Resources/Images/car_images/{$car['image']}\" alt=\"Car Image\">";
                }
                
            } else {
                $output = "Car not found!";
            }
        } else if ($type == 'user') {
            $sql = "SELECT * FROM users WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $output .= "<h3>User Information</h3>";
                $output .= "<p>ID: " . $user['id'] . "</p>";
                $output .= "<p>First Name: " . $user['firstName'] . "</p>";
                $output .= "<p>Last Name: " . $user['lastName'] . "</p>";
            } else {
                $output = "User not found!";
            }
        }
        echo $output;
    }
?>
