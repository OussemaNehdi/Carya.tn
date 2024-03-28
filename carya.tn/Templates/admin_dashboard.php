<?php 
$title="Admin";
$class=""
?>

<?php ob_start(); ?>

<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include CSS file -->
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/CSS/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Include user list -->
    <section>
    <h2>List of Users</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Created</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php


                // Get all users
                $users = User::getAllUsers();

                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user->id}</td>";
                    echo "<td>{$user->firstName}</td>";
                    echo "<td>{$user->lastName}</td>";
                    echo "<td>{$user->email}</td>";
                    echo "<td>{$user->creation_date}</td>";
                    echo "<td>{$user->role}</td>";

                    // Display appropriate action based on user's role
                    echo "<td>";
                    if ($user->role== 'banned') {
                        echo "<a href=\"requests/unban_user.php?id={$user->id}\">Unban</a>";
                    } else if ($user->role == 'admin') {
                        echo "Admin";
                    } else {
                        echo "<a href=\"requests/ban_user.php?id={$user->id}\">Ban</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>


<style>
    .car-image {
        cursor: pointer;
        width: 100px;
    }
</style>

<section>
    <h2>List of Cars</h2>
    <table>
        <thead>
            <tr>
                <th>Car ID</th>
                <th>Car Brand</th>
                <th>Car Model</th>
                <th>Color</th>
                <th>Kilometers</th>
                <th>Owner</th>
                <th>Price</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            // Get all cars
            $cars = Car::getAllCars();

            foreach ($cars as $car) {
                // Display car information and actions
                echo "<tr>";
                echo "<td class='car-image' data-id='{$car->id}'>{$car->id}</td>";
                echo "<td class='car-image' data-id='{$car->id}'>{$car->brand}</td>";
                echo "<td class='car-image' data-id='{$car->id}'>{$car->model}</td>";
                echo "<td class='car-image' data-id='{$car->id}'>{$car->color}</td>";
                echo "<td>{$car->km}</td>";
                echo "<td class='user-info' data-id='{$car->owner_id}'>{$car->owner_id}</td>";
                echo "<td>{$car->price}</td>";

                // Check if the car is available
                $available = Command::isCarAvailable($car->id, date('Y-m-d'));
                
                // Display availability status
                echo "<td>";
                if ($available) {
                    echo "Yes";
                } else {
                    echo "No";
                }   
                // Display actions based on availability
                echo "<td>";
                if ($available) {
                    echo "<a href='http://localhost/Mini-PHP-Project/PHP/delete_car.php?id={$car->id}'>Delete</a>";
                    // Add update option if the user is the owner of the car
                    if ($car->owner_id == $_SESSION['user_id']) {
                        echo " | <a href='../update_car.php?id={$car->id}'>Update</a>";
                    }
                } else {
                    echo "Car is in use";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>

    <?php

try {
    // Get all rental commands
    $car_commands_result = Command::getAllRentalCommands();
    
    // Display car commands
    echo "<section>";
    echo "<h2>List of Car Commands</h2>";
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Command ID</th>";
    echo "<th>Car ID</th>";
    echo "<th>User ID</th>";
    echo "<th>Start Date</th>";
    echo "<th>End Date</th>";
    echo "<th>Price Paid</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($car_commands_result as $car_command) {
        // Fetch car information for the command
        $car = Car::getCarById($car_command->car_id);
        
        // Fetch user information for the command
        $user = User::getUserById($car_command->user_id);
        
        // Calculate end date based on start date and duration
        $end_date = date('Y-m-d', strtotime($car_command->start_date . ' + ' . $car_command->rental_period . ' days'));
        // Calculate price paid based on price per day and duration
        $price_paid = $car->price * $car_command->rental_period;

        // Display car command information
        echo "<tr>";
        echo "<td>{$car_command->command_id}</td>";
        echo "<td class='car-info' data-id='{$car->id}'>{$car->id}</td>";
        echo "<td class='user-info' data-id='{$user->id}'>{$user->id}</td>";
        echo "<td>{$car_command->start_date}</td>";
        echo "<td>{$end_date}</td>";
        echo "<td>{$price_paid}</td>";
        echo "<td><a href=\"http://localhost/Mini-PHP-Project/PHP/admin_dashboard/requests/cancel_command.php?id={$car_command->command_id}\">Cancel Command</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</section>";
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>

    <!-- Add Car Button -->
    <button><a href="http://localhost/Mini-PHP-Project/PHP/add_car.php">Add Car</a></button>
    
    <!-- Include JavaScript file -->
    <script src="http://localhost/Mini-PHP-Project/JS/script.js"></script>
</body>
</html>
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>