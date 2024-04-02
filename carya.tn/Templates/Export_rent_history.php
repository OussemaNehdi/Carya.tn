<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Lib/connect.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/Mini-PHP-Project/carya.tn/templates/login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get renting history for the user
$rentingHistory = Command::getRentalCommandsByUserId($user_id);

// Get user details
$user = User::getUserById($user_id);

// Update car details in renting history
foreach ($rentingHistory as &$row) {
    $carDetails = Car::getCarById($row->car_id);
    $row->car_id = $carDetails->brand;
    $row->car_model = $carDetails->model;
    $row->car_price = $carDetails->price;
    $row->confirmed = $row->confirmed == 1 ? "Confirmed" : "Not Confirmed";
}
unset($row);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renting History</title>
    <link rel="stylesheet" href="http://localhost/Mini-PHP-Project/carya.tn/style.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
            }
            .popup {
                display: none;
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border: 1px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                z-index: 1000;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .center {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .download-button {
                background-color: brown;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
            }

            .download-button:hover {
                background-color: #8B4513;
            }

        </style>
    </head>
    <body>
        <table>
            <tr>
                <th>Rent ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Rental Date</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Price</th>
                
            </tr>

            <?php foreach ($rentingHistory as $row): ?>
                <tr>
                    <td><?= $row->command_id ?></td>
                    <td><?= $row->car_id ?></td>
                    <td><?= $row->car_model ?></td>
                    <td><?= $row->rental_date ?></td>
                    <td><?= $row->start_date ?></td>
                    <td><?= $row->end_date ?></td>
                    <td><?= $row->confirmed ?></td>
                    <td><?= $row->car_price ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <!-- Download button for renting history -->
    <div class="center">
        <button><a href="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/Download_Rent_History.php">Download</a></button>
    </div>
</div>