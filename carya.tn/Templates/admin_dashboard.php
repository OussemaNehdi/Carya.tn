<?php
// Include necessary files
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/controllers/is_admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Command.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/User.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/src/Model/Car.php';

// Set title and class
$title = "Admin Dashboard";
$class = "";

// Start output buffering
ob_start();

// Start or resume session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<h1>Admin Dashboard</h1>
<script src="http://localhost/Mini-PHP-Project/carya.tn/script.js"></script>

<!-- User list -->
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
            <?php foreach (User::getAllUsers() as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->firstName ?></td>
                    <td><?= $user->lastName ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->creation_date ?></td>
                    <td><?= $user->role ?></td>
                    <td><?= $user->displayUserActions() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- Car list -->
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
            <?php foreach (Car::getAllCars() as $car): ?>
                <tr>
                    <td class='car-image' data-id='<?= $car->id ?>'><?= $car->id ?></td>
                    <td class='car-image' data-id='<?= $car->id ?>'><?= $car->brand ?></td>
                    <td class='car-image' data-id='<?= $car->id ?>'><?= $car->model ?></td>
                    <td class='car-image' data-id='<?= $car->id ?>'><?= $car->color ?></td>
                    <td><?= $car->km ?></td>
                    <td class='user-info' data-id='<?= $car->owner_id ?>'><?= $car->owner_id ?></td>
                    <td><?= $car->price ?></td>
                    <td><?= $car->isCarAvailable() ? "Yes" : "No" ?></td>
                    <td><?= $car->displayCarAvailabilityActions() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- Car commands list -->
<section>
    <h2>List of Car Commands</h2>
    <table>
        <thead>
            <tr>
                <th>Command ID</th>
                <th>Car ID</th>
                <th>User ID</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (Command::getAllRentalCommands() as $command): ?>
                <?php
                    // Get car and user information for the current command
                    $car = Car::getCarById($command->car_id);
                    $user = User::getUserById($command->user_id);
                    $price_paid = $car->price * $command->rental_period;
                ?>
                <tr>
                    <td><?= $command->command_id ?></td>
                    <td class='car-info' data-id='<?= $car->id ?>'><?= $car->id ?></td>
                    <td class='user-info' data-id='<?= $user->id ?>'><?= $user->id ?></td>
                    <td><?= $command->start_date ?></td>
                    <td><?= $command->end_date ?></td>
                    <td><?= $price_paid ?></td>
                    <td>
                        <a href="http://localhost/Mini-PHP-Project/carya.tn/src/controllers/cancel_command.php?id=<?= $command->command_id ?>">Cancel Command</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


<div id="info-popup" class="info-popup"></div>
<style>
    /* Styling for info popups */
    .info-popup {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        padding: 10px;
        display: none;
    }
</style>

<!-- Add Car Button -->
<button><a href="http://localhost/Mini-PHP-Project/carya.tn/templates/add_car_form.php">Add Car</a></button>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
