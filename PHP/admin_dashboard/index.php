<?php
    // Include file to check if the user is an admin
    include 'requests/is_admin.php';

    // Include navbar
    include '../../HTML/navbar.php';

    // Include database connection
    include('../connect.php');
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
    <?php include 'user_list.php'; ?>

    <!-- Include car list -->
    <?php include 'car_list.php'; ?>

    <!-- Include command list -->
    <?php include 'command_list.php'; ?>

    <!-- User Info and Car Info Display -->
    <?php include 'info_popup.php'; ?>

    <!-- Add Car Button -->
    <button><a href="http://localhost/Mini-PHP-Project/PHP/add_car.php">Add Car</a></button>
    
    <!-- Include JavaScript file -->
    <script src="http://localhost/Mini-PHP-Project/JS/script.js"></script>
</body>
</html>
