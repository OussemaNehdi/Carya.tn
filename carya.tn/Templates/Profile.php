<?php
// Include database connection and any necessary libraries
require_once('../src/Lib/connect.php');

include '../src/Model/Car.php';
include '../src/Model/Command.php';
include '../src/Model/User.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Get the user ID from the URL
$user_id = $_SESSION['user_id'];

// Get the user information
$userInfo = User::getUserById($user_id);

// Get the active renting cars for the user
$activeRentingCars = Command::getRentalCommandsByUserId($user_id);
foreach ($activeRentingCars as &$row) {
    $carDetails = Car::getCarById($row->car_id);
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
}

unset($row);    

// Filter the active renting cars by dates
$currentDate = "2024-04-06";

$activeRentingCars = array_filter($activeRentingCars, function($car) use ($currentDate) {
    return $currentDate >= $car->start_date && $currentDate <= $car->end_date;
});






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <?php if ($userInfo): ?>
        <h2>User Information</h2>
        <p>Full Name: <?php echo $userInfo->firstName . ' ' . $userInfo->lastName; ?></p>
        <p>Email: <?php echo $userInfo->email; ?></p>
        
        <!-- Add more user information fields as needed -->

        <?php if ($activeRentingCars): ?>
            <h2>Active Renting Cars</h2>
            <ul>
                <?php foreach ($activeRentingCars as $car): ?>
                    <li><?php echo $car->car_id . ' ' . $car->car_model. ' | '. "Remaining Days: " . date_diff(date_create($currentDate), date_create($car->end_date))->format('%a'); ?></li>
                   
                    <!-- Add more car details as needed -->
                <?php endforeach; ?>
            </ul>   
        <?php else: ?>
            <p>No active renting cars at the moment.</p>
        <?php endif; ?>
    <p><a href="http://localhost/Mini-PHP-Project/carya.tn/Templates/Export_rent_history.php">Export Rent History</a></p>
    
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>
