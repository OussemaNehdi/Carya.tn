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
<div class="export-popup-container">
    <table>
        <tr>
            <th>Rent ID</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Rental Date</th>
            <th>Start Date</th>
            <th>End Date</th>
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
                <td><?= $row->car_price ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Download button for renting history -->
    <div class="center">
        <button><a href="http://localhost/Mini-PHP-Project/carya.tn/src/Controllers/Download_Rent_History.php">Download</a></button>
    </div>
</div>